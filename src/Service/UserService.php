<?php

declare(strict_types=1);

namespace App\Service;

use App\DTO\UserDTO;
use App\Entity\User;
use App\Exception\UserNotFoundException;
use App\Factory\UserFactory;
use App\Mapper\UserMapper;
use App\Repository\UserRepository;
use App\Security\AuthUserInterface;
use App\Security\UserFetcherInterface;
use Symfony\Bundle\SecurityBundle\Security;

readonly class UserService implements UserFetcherInterface
{
    public function __construct(
        private Security $security,
        private UserFactory $userFactory,
        private UserRepository $userRepository,
    ) {}

    public function getAuthUserInfo(): UserDTO
    {
        /** @var User $user */
        $user = $this->getAuthUser();

        return UserMapper::mapToUserDTO($user);
    }

    /**  @throws UserNotFoundException */
    public function getUser(string $uuid): UserDTO
    {
        $user = $this->userRepository->getByUuid($uuid);

        if ($user === null) {
            throw new UserNotFoundException();
        }

        return UserMapper::mapToUserDTO($user);
    }

    public function createUser(array $data): void
    {
        $user = $this->userFactory->create(
            $data['login'],
            $data['password'],
            $data['firstname'],
            $data['lastname']
        );

        $this->userRepository->save($user);
    }

    /** @throws UserNotFoundException */
    public function updateUser(string $uuid, array $data): void
    {
        $user = $this->userRepository->getByUuid($uuid);

        if ($user === null) {
            throw new UserNotFoundException();
        }

        $user->setLogin($data['login']);
        $user->setFirstName($data['firstname']);
        $user->setLastName($data['lastname']);

        $this->userRepository->save($user);
    }

    /** @throws UserNotFoundException */
    public function deleteUser(string $uuid): void
    {
        $user = $this->userRepository->getByUuid($uuid);

        if ($user === null) {
            throw new UserNotFoundException();
        }

        $this->userRepository->delete($user);
    }

    public function getAuthUser(): AuthUserInterface
    {
        /** @var AuthUserInterface $user */
        $user = $this->security->getUser();

        return $user;
    }
}
