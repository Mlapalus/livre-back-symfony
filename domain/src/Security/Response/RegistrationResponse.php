<?php

namespace Domain\Security\Response;

class RegistrationResponse
{
    /**
     * @var string
     */
    private string $email;

    /**
     * @var string
     */
    private string $userName;

    /**
     * @var string
     */
    private string $plainPassword;

    public function __construct(string $email, string $user, string $plainPassword)
    {
        $this->email = $email;
        $this->userName = $user;
        $this->plainPassword = $plainPassword;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getUserName(): string
    {
        return $this->userName;
    }

    /**
     * @return string
     */
    public function getPlainPassword(): string
    {
        return $this->plainPassword;
    }
}
