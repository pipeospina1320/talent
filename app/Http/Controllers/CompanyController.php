<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Helpers\PaginateHelper;
use App\Http\Requests\StoreCompanyRequest;
use App\Http\Requests\UpdateCompanyRequest;
use App\Repositories\CompanyRepository;

class CompanyController extends Controller
{
    private CompanyRepository $companyRepository;

    public function __construct(CompanyRepository $companyRepository)
    {
        $this->companyRepository = $companyRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return PaginateHelper::returnDataPaginate($this->companyRepository->index());
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCompanyRequest $request)
    {
        try {
            $company = $this->companyRepository->store($request->validated());
            return ApiResponse::sendResponse($company, 201);
        } catch (\Exception $e) {
            return ApiResponse::throw($e, "Company could not be created!");
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $company = $this->companyRepository->getById($id);

        return ApiResponse::sendResponse($company, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id, UpdateCompanyRequest $request)
    {
        try {
            $this->companyRepository->update($request->validated(), $id);
            return ApiResponse::sendResponse('Company Update Successful');
        } catch (\Exception $e) {
            return ApiResponse::throw($e, "Company could not be updated!");
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $this->companyRepository->delete($id);
            return ApiResponse::sendResponse('Company Deleted Successfully');
        } catch (\Exception $e) {
            return ApiResponse::throw($e, "Company could not be deleted!");
        }
    }
}
