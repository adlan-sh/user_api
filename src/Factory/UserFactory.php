<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

readonly class UserFactory
{
    public function __construct(private UserPasswordHasherInterface $hasher) {}

    public function create(string $login, string $password, string $firstName, string $lastName): User
    {
        $user = (new User())
            ->setLogin($login)
            ->setFirstName($firstName)
            ->setLastName($lastName);

        $user->setPassword($this->hasher->hashPassword($user, $password));

        return $user;
    }
}
