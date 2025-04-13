<?php

declare(strict_types=1);

namespace App\DTO;

use JsonSerializable;

class UserDTO implements JsonSerializable
{
    private string $uuid;

    private string $login;

    private string $lastName;

    private string $firstName;


    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function setUuid(string $uuid): self
    {
        $this->uuid = $uuid;

        return $this;
    }

    public function getLogin(): string
    {
        return $this->login;
    }

    public function setLogin(string $login): self
    {
        $this->login = $login;

        return $this;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function jsonSerialize(): mixed
    {
        return [
            'uuid' => $this->uuid,
            'login' => $this->login,
            'lastname' => $this->lastName,
            'firstName' => $this->firstName,
        ];
    }
}
