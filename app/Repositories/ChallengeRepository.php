<?php

namespace App\Repositories;

use App\Interfaces\BaseRepositoryInterface;
use App\Models\Challenge;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Query\Builder;

class ChallengeRepository implements BaseRepositoryInterface
{
    public function index(): Builder
    {
        return DB::table('challenges');
    }

    public function getById($id)
    {
        return Challenge::findOrFail($id);
    }

    public function store(array $data)
    {
        return Challenge::create($data);
    }

    public function update(array $data, $id)
    {
        return Challenge::whereId($id)->update($data);
    }

    public function delete($id)
    {
        Challenge::destroy($id);
    }
}
