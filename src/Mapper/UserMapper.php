<?php

declare(strict_types=1);

namespace App\Mapper;

use App\DTO\UserDTO;
use App\Entity\User;

readonly class UserMapper
{
    public static function mapToUserDTO(User $user): UserDTO
    {
        return (new UserDTO())
            ->setUuid($user->getUuid()->toString())
            ->setLogin($user->getLogin())
            ->setFirstName($user->getFirstName())
            ->setLastName($user->getLastName());
    }
}
