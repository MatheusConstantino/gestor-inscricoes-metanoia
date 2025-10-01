<?php

namespace App\Services;

use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Exception;

class UserService
{
    protected $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getAllUsers()
    {
        return $this->userRepository->all();
    }

    public function createUser(array $data)
    {
        try {
            $data['password'] = Hash::make($data['password']);
            return $this->userRepository->create($data);
        } catch (Exception $e) {
            Log::error('Erro ao criar usuário: ' . $e->getMessage());
            return null;
        }
    }
}
