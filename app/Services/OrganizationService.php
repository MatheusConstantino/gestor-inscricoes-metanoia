<?php

namespace App\Services;

use App\Repositories\Interfaces\OrganizationRepositoryInterface;
use Illuminate\Support\Facades\Log;
use Exception;

class OrganizationService
{
    protected $organizationRepository;

    public function __construct(OrganizationRepositoryInterface $organizationRepository)
    {
        $this->organizationRepository = $organizationRepository;
    }

    public function getAllOrganizations()
    {
        return $this->organizationRepository->all();
    }

    public function createOrganization(array $data)
    {
        try {
            // Aqui podemos adicionar lógica de negócio, como validação,
            // criação de slug, etc., antes de passar para o repositório.
            return $this->organizationRepository->create($data);
        } catch (Exception $e) {
            Log::error('Erro ao criar organização: ' . $e->getMessage());
            return null;
        }
    }

    // Outros métodos de serviço (update, delete, find, etc.)
}
