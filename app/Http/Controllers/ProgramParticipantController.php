<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Helpers\PaginateHelper;
use App\Http\Requests\StoreProgramParticipantRequest;
use App\Http\Requests\UpdateProgramParticipantRequest;
use App\Models\Challenge;
use App\Models\Company;
use App\Models\ProgramParticipant;
use App\Models\User;
use App\Repositories\ProgramParticipantRepository;

class ProgramParticipantController extends Controller
{
    private ProgramParticipantRepository $programParticipantRepository;

    public function __construct(ProgramParticipantRepository $programParticipantRepository)
    {
        $this->programParticipantRepository = $programParticipantRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return PaginateHelper::returnDataPaginate($this->programParticipantRepository->index());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProgramParticipantRequest $request)
    {
        try {
            $validatedData = $request->validated();

            $programParticipant = new ProgramParticipant;

            $programParticipant->program_id = $validatedData['program_id'];
            $entityType = $validatedData['entity_type'];
            $entityId = $validatedData['entity_id'];

            $modelMapping = [
                'users' => User::class,
                'challenges' => Challenge::class,
                'companies' => Company::class,
            ];
            if (!isset($modelMapping[$entityType])) {
                // Manejar el caso en que el entity_type no es válido
                throw new \Exception("Invalid entity type: $entityType");
            }

            $entityClass = $modelMapping[$entityType];
            $entity = $entityClass::find($entityId);

            if (!$entity) {
                throw new \Exception("Entity not found: $entityType $entityId");
            }

            $programParticipant->entity()->associate($entity);

            $programParticipant->save();
            return ApiResponse::sendResponse($programParticipant, 201);
        } catch (\Exception $e) {
            return ApiResponse::throw($e, $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(ProgramParticipant $programParticipant)
    {
        $programParticipant = $this->programParticipantRepository->getById($programParticipant->id);

        return ApiResponse::sendResponse($programParticipant, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id, UpdateProgramParticipantRequest $request)
    {
        try {
            $this->programParticipantRepository->update($request->validated(), $id);
            return ApiResponse::sendResponse('Program Participant Update Successful');
        } catch (\Exception $e) {
            return ApiResponse::throw($e, "Program Participant could not be updated!");
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $this->programParticipantRepository->delete($id);
            return ApiResponse::sendResponse('Program Participant Deleted Successfully');
        } catch (\Exception $e) {
            return ApiResponse::throw($e, "Program Participant could not be deleted!");
        }
    }
}
