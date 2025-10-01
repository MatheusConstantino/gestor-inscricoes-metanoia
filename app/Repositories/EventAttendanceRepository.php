<?php

namespace App\Repositories;

use App\Models\EventAttendance;
use App\Repositories\Interfaces\EventAttendanceRepositoryInterface;

class EventAttendanceRepository extends BaseRepository implements EventAttendanceRepositoryInterface
{
    public function __construct(EventAttendance $model)
    {
        parent::__construct($model);
    }
}
