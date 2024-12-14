<?php
namespace App\Repositories;

use App\Contracts\GenericRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class GenericRepository implements GenericRepositoryInterface
{
    protected $model;

    // Inject the specific model into the repository
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function getAll(): array
    {
        return $this->model->all()->toArray();
    }

    public function findById($id)
    {
        return $this->model->find($id);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update($id, array $data)
    {
        $record = $this->findById($id);

        if (!$record) {
            return null;
        }

        $record->update($data);
        return $record;
    }

    public function delete($id)
    {
        $record = $this->findById($id);

        if (!$record) {
            return false;
        }

        return $record->delete();
    }
}
