<?php

namespace App\Entity;

/**
 * Password
 */
class Password
{

    /**
     * password
     *
     * @var string
     */
    private $password;

    /**
     * Get password
     *
     * @return  string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set password
     *
     * @param  string  $password  password
     *
     * @return  self
     */
    public function setPassword(string $password)
    {
        $this->password = $password;

        return $this;
    }
}
