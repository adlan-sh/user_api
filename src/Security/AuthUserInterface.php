<?php

declare(strict_types=1);

namespace App\Security;

use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Uid\Uuid;

interface AuthUserInterface extends UserInterface, PasswordAuthenticatedUserInterface
{
    public function getUuid(): Uuid;
    public function getLogin(): string;
}
