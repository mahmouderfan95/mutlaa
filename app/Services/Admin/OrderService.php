<?php
namespace App\Services\Admin;
use App\Models\Order;
use App\Models\Trip;
use App\Repositories\Eloquent\OrderRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class OrderService
{
    public function __construct(protected OrderRepository $repository){}
    public function list(array $filters, int $perPage = 15): LengthAwarePaginator
    {
        return $this->repository->paginate($perPage, $filters,['trip']);
    }
    public function find(int $id): Order
    {
        return $this->repository->findOrFail($id);
    }
}
