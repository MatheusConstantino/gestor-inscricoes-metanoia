<?php

namespace App\Services;

use App\Repositories\Interfaces\MinistryRepositoryInterface;
use Illuminate\Support\Facades\Log;
use Exception;

class MinistryService
{
    protected $ministryRepository;

    public function __construct(MinistryRepositoryInterface $ministryRepository)
    {
        $this->ministryRepository = $ministryRepository;
    }

    public function getAllMinistries()
    {
        return $this->ministryRepository->all();
    }

    public function createMinistry(array $data)
    {
        try {
            return $this->ministryRepository->create($data);
        } catch (Exception $e) {
            Log::error('Erro ao criar ministério: ' . $e->getMessage());
            return null;
        }
    }
}
