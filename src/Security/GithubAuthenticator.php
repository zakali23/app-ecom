<?php
namespace App\Security;

use App\Entity\User;
use App\Security\Exceptions\EmailNotVerifiedException;
use Doctrine\ORM\EntityManagerInterface;
use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use KnpU\OAuth2ClientBundle\Security\Authenticator\OAuth2Authenticator;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Security;
use League\OAuth2\Client\Provider\GithubResourceOwner;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\PassportInterface;
use Symfony\Component\Security\Http\Authenticator\Passport\SelfValidatingPassport;

class GithubAuthenticator extends OAuth2Authenticator
{

    private $clientRegistry;
    private $entityManager;
    private $router;
    private $encoder;
    /**
     * GithubAuthenticator constructor.
     * @param ClientRegistry $clientRegistry
     * @param EntityManagerInterface $entityManager
     * @param RouterInterface $router
     */
    public function __construct(ClientRegistry $clientRegistry, EntityManagerInterface $entityManager, RouterInterface $router,UserPasswordEncoderInterface $encoder)
    {
        $this->clientRegistry = $clientRegistry;
        $this->entityManager = $entityManager;
        $this->router = $router;
        $this->encoder = $encoder;
    }

    /**
     * Does the authenticator support the given Request?
     *
     * If this returns false, the authenticator will be skipped.
     *
     * Returning null means authenticate() can be called lazily when accessing the token storage.
     * @param Request $request
     * @return bool|null
     */
    public function supports(Request $request): ?bool
    {
        return 'oauth_check' ===$request->attributes->get('_route') && $request->get('service') === 'github';
    }

    /**
     * Create a passport for the current request.
     *
     * The passport contains the user, credentials and any additional information
     * that has to be checked by the Symfony Security system. For example, a login
     * form authenticator will probably return a passport containing the user, the
     * presented password and the CSRF token value.
     *
     * You may throw any AuthenticationException in this method in case of error (e.g.
     * a UserNotFoundException when the user cannot be found).
     *
     * @throws AuthenticationException
     */
    public function authenticate(Request $request): PassportInterface
    {
        $client = $this->clientRegistry->getClient('github');
        $accessToken = $this->fetchAccessToken($client);
        return new SelfValidatingPassport(
            new UserBadge($accessToken, function() use ($accessToken, $client) {
                
                $githubUser = $client->fetchUserFromToken($accessToken);
                // 1) have they logged in with Facebook before? Easy!
                $existingUser = $this->entityManager->getRepository('App:User')->findOneBy(['github_id' => $githubUser->getId()]);

                if ($existingUser) {
                    return $existingUser;
                }
                // get email by api github
                $response = HttpClient::create()->request(
                    'GET',
                    'https://api.github.com/user/emails',
                    [
                        'headers'=>[
                            'authorization' => "token {$accessToken->getToken()}"
                        ]
                    ]
                );
                $emails = json_decode($response->getContent(),true);
                foreach ($emails as $email){
                    if( $email['primary']=== true && $email['verified']===true){
                        $data = $githubUser->toArray();
                        $data['email'] = $email['email'];
                        $githubUser = new GithubResourceOwner($data);
                    }
                }
                if($githubUser->getEmail() === null){
                    throw new EmailNotVerifiedException();
                }
                $user = $this->entityManager->getRepository('App:User')->findOneBy(['email' => $githubUser->getEmail()]);
                if($user){
                    $user->setGithubId($githubUser->getId());
                    $this->entityManager->flush();
                    return $user;
                }
                $user = new User();
                $user->setGithubId($githubUser->getId())
                     ->setEmail($githubUser->getEmail())
                     ->setRoles(['ROLE_USER'])
                     ->setIsAbNltr(false)
                     ->setPassword($this->encoder->encodePassword($user,$this->generateRandomString(24)))
                     ->setRegisterDat(new \DateTimeImmutable('now'));
                $this->entityManager->persist($user);
                $this->entityManager->flush();

                return $user;
            })
        );
    }

    private function generateRandomString($length) {
        return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
    }
    /**
     * Called when authentication executed and was successful!
     *
     * This should return the Response sent back to the user, like a
     * RedirectResponse to the last page they visited.
     *
     * If you return null, the current request will continue, and the user
     * will be authenticated. This makes sense, for example, with an API.
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        $targetUrl = $this->router->generate('app_home');

        return new RedirectResponse($targetUrl);
    }

    /**
     * Called when authentication executed, but failed (e.g. wrong username password).
     *
     * This should return the Response sent back to the user, like a
     * RedirectResponse to the login page or a 403 response.
     *
     * If you return null, the request will continue, but the user will
     * not be authenticated. This is probably not what you want to do.
     */
    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
        if ($request->hasSession()) {
            $request->getSession()->set(Security::AUTHENTICATION_ERROR, $exception);
        }
        return new RedirectResponse($this->router->generate('app_login'));
    }
}