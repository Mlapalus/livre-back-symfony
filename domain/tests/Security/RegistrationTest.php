<?php

namespace Domain\Tests\Security;

use Assert\LazyAssertionException;
use Domain\Security\Presenter\RegistrationPresenterInterface;
use Domain\Security\Request\RegistrationRequest;
use Domain\Security\Response\RegistrationResponse;
use Domain\Security\Usecase\RegistrationUsecase;
use Generator;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class RegistrationTest extends TestCase
{
    private const EMAIL = "email@email.com";
    private const USER = "goodUser";
    private const PASSWORD = "123AZEqsd@!m";
    private const SHORT_PASSWORD = "1aZ&";
    private const NON_MAJ_FORMAT_PASSWORD = "123aze!&";
    private const NON_MIN_FORMAT_PASSWORD = "123AZE!&";
    private const NON_SPEC_CHAR_FORMAT_PASSWORD = "123AZEqsd";
    private const USED_EMAIL = "used@email.com";
    private const USED_USERNAME = "usedUserName";

    /**
     * @var RegistrationUsecase $usecase
     */
    private RegistrationUsecase $usecase;

    /**
     * @var RegistrationPresenterInterface $presenter
     */
    private RegistrationPresenterInterface $presenter;

    public function setUp(): void
    {
        $this->presenter = new class () implements RegistrationPresenterInterface {
            public RegistrationResponse $response;

            public function present(RegistrationResponse $response): void
            {
                $this->response = $response;
            }

            public function getResponse(): RegistrationResponse
            {
                return $this->response;
            }
        };

        $playerRepository = new PlayerInMemoryRepository();
        $this->usecase =  new RegistrationUsecase($playerRepository);
    }

    public function testRegistrationSuccessful(): void
    {
        $request = RegistrationRequest::createFromRequest(
            self::EMAIL,
            self::USER,
            self::PASSWORD
        );

        $this->usecase->execute($request, $this->presenter);

        $this->assertInstanceOf(RegistrationResponse::class, $this->presenter->getResponse());
        $this->assertEquals(self::EMAIL, $this->presenter->getResponse()->getEmail());
        $this->assertEquals(self::USER, $this->presenter->getResponse()->getUserName());
        $this->assertEquals(self::PASSWORD, $this->presenter->getResponse()->getPlainPassword());
    }

    /**
     * @dataProvider registrationProvider
     * @param string $email
     * @param string $userName
     * @param string $plainpassword
     */
    public function testRegistrationFail(
        string $email,
        string $userName,
        string $plainpassword
    ): void {

        $request = RegistrationRequest::createFromRequest(
            $email,
            $userName,
            $plainpassword
        );

        $this->expectException(InvalidArgumentException::class);
        $this->usecase->execute($request, $this->presenter);
    }

    /**
     * @return string[][]
     */
    public function registrationProvider(): array
    {
        return [
            ["", self::USER, self::PASSWORD],
            ["notAEmail", self::USER, self::PASSWORD],
            [self::EMAIL, "", self::PASSWORD],
            [self::EMAIL, self::USER, ""],
            [self::EMAIL, self::USER, self::SHORT_PASSWORD],
            [self::EMAIL, self::USER, self::NON_MAJ_FORMAT_PASSWORD],
            [self::EMAIL, self::USER, self::NON_MIN_FORMAT_PASSWORD],
            [self::EMAIL, self::USER, self::NON_SPEC_CHAR_FORMAT_PASSWORD],
            [self::USED_EMAIL, self::USER, self::PASSWORD],
            [self::EMAIL, self::USED_USERNAME, self::PASSWORD],
        ];
    }
}
