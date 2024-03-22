<?php

namespace App\Repositories;

use App\Interfaces\BaseRepositoryInterface;
use App\Models\ProgramParticipant;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Query\Builder;

class ProgramParticipantRepository implements BaseRepositoryInterface
{
    public function index(): Builder
    {
        return DB::table('program_participants');
    }

    public function getById($id)
    {
        return ProgramParticipant::findOrFail($id);
    }

    public function store(array $data)
    {
    }

    public function update(array $data, $id)
    {
        return ProgramParticipant::whereId($id)->update($data);
    }

    public function delete($id)
    {
        ProgramParticipant::destroy($id);
    }
}
