<?php

namespace App\Services;

use App\Repositories\Interfaces\EventRepositoryInterface;
use Illuminate\Support\Facades\Log;
use Exception;

class EventService
{
    protected $eventRepository;

    public function __construct(EventRepositoryInterface $eventRepository)
    {
        $this->eventRepository = $eventRepository;
    }

    public function getAllEvents()
    {
        return $this->eventRepository->all();
    }

    public function createEvent(array $data)
    {
        try {
            return $this->eventRepository->create($data);
        } catch (Exception $e) {
            Log::error('Erro ao criar evento: ' . $e->getMessage());
            return null;
        }
    }
}
