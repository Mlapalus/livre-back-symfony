<?php

namespace Domain\Security\Request;

use Assert\AssertionFailedException;
use Assert\LazyAssertionException;
use Domain\Security\Assert\Assertion;
use Domain\Security\Gateway\PlayerRepositoryInterface;

class RegistrationRequest
{
    private string $email;
    private string $userName;
    private string $plainPassword;

    /**
     * @param string $email
     * @param string $userName
     * @param string $plainPassword
     * @return self
     */
    public static function createFromRequest(string $email, string $userName, string $plainPassword): self
    {
        $request = new self();
        $request->setEmail($email);
        $request->setUserName($userName);
        $request->setPlainPassword($plainPassword);
        return $request;
    }

    /**
     * @param string $email
     */
    private function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $userName
     */
    private function setUserName(string $userName): void
    {
        $this->userName = $userName;
    }

    /**
     * @return string
     */
    public function getUserName(): string
    {
        return $this->userName;
    }

    /**
     * @param string $plainPassword
     */
    private function setPlainPassword(string $plainPassword): void
    {
        $this->plainPassword = $plainPassword;
    }

    /**
     * @return string
     */
    public function getPlainPassword(): string
    {
        return $this->plainPassword;
    }

    public function isValid(PlayerRepositoryInterface $repository): void
    {
        try {
            Assertion::email($this->email);
            Assertion::string($this->email);
            Assertion::notBlank($this->email);

            Assertion::string($this->userName);
            Assertion::notBlank($this->userName);

            Assertion::string($this->plainPassword);
            Assertion::notBlank($this->plainPassword);
            Assertion::tooShortPassword($this->plainPassword);
            Assertion::badFormatPassword($this->plainPassword);

            Assertion::notUniqUserName($this->userName, $repository);
            Assertion::notUniqEmail($this->email, $repository);
        } catch (LazyAssertionException $e) {
            throw new LazyAssertionException($e->getMessage(), [$e]);
        }
    }
}
