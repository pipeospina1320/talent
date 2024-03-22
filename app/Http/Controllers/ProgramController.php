<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Helpers\PaginateHelper;
use App\Http\Requests\StoreProgramRequest;
use App\Http\Requests\UpdateProgramRequest;
use App\Models\Program;
use App\Repositories\ProgramRepository;

class ProgramController extends Controller
{
    private ProgramRepository $programRepository;

    public function __construct(ProgramRepository $programRepository)
    {
        $this->programRepository = $programRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return PaginateHelper::returnDataPaginate($this->programRepository->index());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProgramRequest $request)
    {
        try {
            $program = $this->programRepository->store($request->validated());
            return ApiResponse::sendResponse($program, 201);
        } catch (\Exception $e) {
            return ApiResponse::throw($e, "Program could not be created!");
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $program = $this->programRepository->getById($id);

        return ApiResponse::sendResponse($program, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id, UpdateProgramRequest $request)
    {
        try {
            $this->programRepository->update($request->validated(), $id);
            return ApiResponse::sendResponse('Program Update Successful');
        } catch (\Exception $e) {
            return ApiResponse::throw($e, "Program could not be updated!");
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $this->programRepository->delete($id);
            return ApiResponse::sendResponse('Program Deleted Successfully');
        } catch (\Exception $e) {
            return ApiResponse::throw($e, "Program could not be deleted!");
        }
    }
}
