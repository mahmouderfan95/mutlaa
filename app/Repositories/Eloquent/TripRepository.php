<?php
namespace App\Repositories\Eloquent;
use App\Models\Trip;
use App\Repositories\Contracts\TripRepositoryInterface;

class TripRepository extends BaseRepository implements TripRepositoryInterface
{
    public function __construct(Trip $model)
    {
        parent::__construct($model);
    }
}
