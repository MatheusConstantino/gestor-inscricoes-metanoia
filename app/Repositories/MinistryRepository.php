<?php

namespace App\Repositories;

use App\Models\Ministry;
use App\Repositories\Interfaces\MinistryRepositoryInterface;

class MinistryRepository extends BaseRepository implements MinistryRepositoryInterface
{
    public function __construct(Ministry $model)
    {
        parent::__construct($model);
    }
}
