<?php

namespace App\Repositories;

use App\Models\Job;

class JobsRepository
{
    public function buscar()
    {
        return Job::all();
    }
}
