<?php
namespace App\Contracts;

interface GenericRepositoryInterface
{
    public function getAll(): array;
    public function findById($id);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
}
