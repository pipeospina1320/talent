<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Helpers\PaginateHelper;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Repositories\UserRepository;

class UserController extends Controller
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return PaginateHelper::returnDataPaginate($this->userRepository->index());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        try {
            $user = $this->userRepository->store($request->validated());
            return ApiResponse::sendResponse($user, 201);
        } catch (\Exception $e) {
            return ApiResponse::throw($e, "User could not be created!");
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $user = $this->userRepository->getById($id);

        return ApiResponse::sendResponse($user, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id, UpdateUserRequest $request)
    {
        try {
            $this->userRepository->update($request->validated(), $id);
            return ApiResponse::sendResponse('User Update Successful');
        } catch (\Exception $e) {
            return ApiResponse::throw($e, "User could not be updated!");
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $this->userRepository->delete($id);
            return ApiResponse::sendResponse('User Delete Successful', 200);
        } catch (\Exception $e) {
            return ApiResponse::throw($e, "User could not be deleted!");
        }
    }
}
