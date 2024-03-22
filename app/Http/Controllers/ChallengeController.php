<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Helpers\PaginateHelper;
use App\Http\Requests\StoreChallengeRequest;
use App\Http\Requests\UpdateChallengeRequest;
use App\Models\Company;
use App\Repositories\ChallengeRepository;

class ChallengeController extends Controller
{
    private ChallengeRepository $challengeRepository;

    public function __construct(ChallengeRepository $challengeRepository)
    {
        $this->challengeRepository = $challengeRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return PaginateHelper::returnDataPaginate($this->challengeRepository->index());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function store(StoreChallengeRequest $request)
    {
        try {
            $challenge = $this->challengeRepository->store($request->validated());
            return ApiResponse::sendResponse($challenge, 201);
        } catch (\Exception $e) {
            return ApiResponse::throw($e, "Challenge could not be created!");
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $challenge = $this->challengeRepository->getById($id);

        return ApiResponse::sendResponse($challenge, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id, UpdateChallengeRequest $request)
    {
        try {
            $this->challengeRepository->update($request->validated(), $id);
            return ApiResponse::sendResponse('Challenge Update Successful');
        } catch (\Exception $e) {
            return ApiResponse::throw($e, "Challenge could not be updated!");
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $this->challengeRepository->delete($id);
            return ApiResponse::sendResponse('Challenge Deleted Successfully');
        } catch (\Exception $e) {
            return ApiResponse::throw($e, "Challenge could not be deleted!");
        }
    }
}
