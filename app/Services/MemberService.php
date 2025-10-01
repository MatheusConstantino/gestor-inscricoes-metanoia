<?php

namespace App\Services;

use App\Repositories\Interfaces\MemberRepositoryInterface;
use Illuminate\Support\Facades\Log;
use Exception;

class MemberService
{
    protected $memberRepository;

    public function __construct(MemberRepositoryInterface $memberRepository)
    {
        $this->memberRepository = $memberRepository;
    }

    public function getAllMembers()
    {
        return $this->memberRepository->all();
    }

    public function createMember(array $data)
    {
        try {
            return $this->memberRepository->create($data);
        } catch (Exception $e) {
            Log::error('Erro ao criar membro: ' . $e->getMessage());
            return null;
        }
    }
}
