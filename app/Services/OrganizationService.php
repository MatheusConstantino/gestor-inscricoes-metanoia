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
        return $this->organizationRepository->paginate();
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

    public function findOrganization(int $id)
    {
        return $this->organizationRepository->find($id);
    }

    public function updateOrganization(int $id, array $data)
    {
        try {
            return $this->organizationRepository->update($id, $data);
        } catch (Exception $e) {
            Log::error('Erro ao atualizar organização: ' . $e->getMessage());
            return false;
        }
    }

    public function deleteOrganization(int $id)
    {
        try {
            return $this->organizationRepository->delete($id);
        } catch (Exception $e) {
            Log::error('Erro ao excluir organização: ' . $e->getMessage());
            return false;
        }
    }
}
