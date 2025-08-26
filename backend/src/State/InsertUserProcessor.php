<?php

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class InsertUserProcessor implements ProcessorInterface
{
    public function __construct(
        private UserPasswordHasherInterface $userPasswordHasher,
        // private EntityManagerInterface $entityManager
        #[Autowire(service: 'api_platform.doctrine.orm.state.persist_processor')]
        private ProcessorInterface $processor
    ) {}

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): User
    {
        $hashedPassword = $this->userPasswordHasher->hashPassword(
            $data, $data->getPassword()
        );
        $data->setPassword($hashedPassword);

        // Instead this, use ProcessorInterface and autowiring
        // $this->entityManager->persist($data);
        // $this->entityManager->flush();

        // return $data;

        return $this->processor->process($data, $operation, $uriVariables, $context);
    }
}
