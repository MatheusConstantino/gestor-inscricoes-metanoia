<?php

namespace App\Services;

use App\Repositories\Interfaces\EventAttendanceRepositoryInterface;
use Illuminate\Support\Facades\Log;
use Exception;

class EventAttendanceService
{
    protected $eventAttendanceRepository;

    public function __construct(EventAttendanceRepositoryInterface $eventAttendanceRepository)
    {
        $this->eventAttendanceRepository = $eventAttendanceRepository;
    }

    public function getAllEventAttendances()
    {
        return $this->eventAttendanceRepository->all();
    }

    public function createEventAttendance(array $data)
    {
        try {
            return $this->eventAttendanceRepository->create($data);
        } catch (Exception $e) {
            Log::error('Erro ao criar presença em evento: ' . $e->getMessage());
            return null;
        }
    }
}
