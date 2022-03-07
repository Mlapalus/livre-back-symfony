<?php

namespace Domain\Security\Usecase;

use Domain\Security\Gateway\PlayerRepositoryInterface;
use Domain\Security\Presenter\RegistrationPresenterInterface;
use Domain\Security\Request\RegistrationRequest;
use Domain\Security\Response\RegistrationResponse;

class RegistrationUsecase
{
    /**
     * @var PlayerRepositoryInterface $repository
     */
    private PlayerRepositoryInterface $repository;

    public function __construct(PlayerRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param RegistrationRequest $request
     * @param RegistrationPresenterInterface $presenter
     */
    public function execute(RegistrationRequest $request, RegistrationPresenterInterface $presenter): void
    {
        $request->isValid($this->repository);

        $response = new RegistrationResponse(
            $request->getEmail(),
            $request->getUserName(),
            $request->getPlainPassword()
        );

        $presenter->present($response);
    }
}
