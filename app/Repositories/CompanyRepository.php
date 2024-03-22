<?php

namespace App\Repositories;

use App\Interfaces\BaseRepositoryInterface;
use App\Models\Company;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Query\Builder;

class CompanyRepository implements BaseRepositoryInterface
{
    public function index(): Builder
    {
        return DB::table('companies');
    }

    public function getById($id)
    {
        return Company::findOrFail($id);
    }

    public function store(array $data)
    {
        return Company::create($data);
    }

    public function update(array $data, $id)
    {
        return Company::whereId($id)->update($data);
    }

    public function delete($id)
    {
        Company::destroy($id);
    }
}
