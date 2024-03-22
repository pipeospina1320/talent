<?php

namespace App\Repositories;

use App\Interfaces\BaseRepositoryInterface;
use App\Models\Program;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Query\Builder;

class ProgramRepository implements BaseRepositoryInterface
{
    public function index(): Builder
    {
        return DB::table('programs');
    }

    public function getById($id)
    {
        return Program::findOrFail($id);
    }

    public function store(array $data)
    {
        return Program::create($data);
    }

    public function update(array $data, $id)
    {
        return Program::whereId($id)->update($data);
    }

    public function delete($id)
    {
        Program::destroy($id);
    }
}
