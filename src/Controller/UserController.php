<?php

declare(strict_types=1);

namespace App\Controller;

use App\Exception\UserNotFoundException;
use App\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api')]
class UserController extends AbstractController
{
    public function __construct(private readonly UserService $userService) {}

    #[Route('/user/me', methods: ['GET'])]
    public function getAuthUser(): JsonResponse
    {
        $user = $this->userService->getAuthUserInfo();

        return $this->json($user);
    }

    #[Route('/user/{uuid}', methods: ['GET'])]
    public function getUserInfo(string $uuid): JsonResponse
    {
        try {
            $user = $this->userService->getUser($uuid);
        } catch (UserNotFoundException $e) {
            return $this->json(['message' => $e->getMessage()], Response::HTTP_NOT_FOUND);
        }

        return $this->json($user);
    }

    #[Route('/user/create', methods: ['POST'])]
    public function createUser(Request $request): JsonResponse
    {
        $data = [
            'login' => $request->get('login'),
            'password' => $request->get('password'),
            'firstname' => $request->get('firstname'),
            'lastname' => $request->get('lastname'),
        ];

        foreach ($data as $field) {
            if (is_null($field)) {
                return $this->json(['message' => 'Not all fields are provided.'], Response::HTTP_BAD_REQUEST);
            }
        }

        $this->userService->createUser($data);

        return $this->json(['message' => 'User created successfully.']);
    }

    #[Route('/user/update/{uuid}', methods: ['POST'])]
    public function updateUser(Request $request, string $uuid): JsonResponse
    {
        $data = [
            'login' => $request->get('login'),
            'firstname' => $request->get('firstname'),
            'lastname' => $request->get('lastname'),
        ];

        foreach ($data as $field) {
            if (is_null($field)) {
                return $this->json(['message' => 'Not all fields are provided.'], Response::HTTP_BAD_REQUEST);
            }
        }

        try {
            $this->userService->updateUser($uuid, $data);
        } catch (UserNotFoundException $e) {
            return $this->json(['message' => $e->getMessage()], Response::HTTP_NOT_FOUND);
        }

        return $this->json(['message' => 'User updated successfully.']);
    }

    #[Route('/user/delete/{uuid}', methods: ['DELETE'])]
    public function deleteUser(string $uuid): JsonResponse
    {
        try {
            $this->userService->deleteUser($uuid);
        } catch (UserNotFoundException $e) {
            return $this->json(['message' => $e->getMessage()], Response::HTTP_NOT_FOUND);
        }

        return $this->json(['message' => 'User deleted successfully.']);
    }
}
