<?php

namespace App\Interfaces;

use Illuminate\Database\Query\Builder;

interface BaseRepositoryInterface
{
    public function index(): Builder;
    public function getById($id);
    public function store(array $data);
    public function update(array $data, $id);
    public function delete($id);
}
