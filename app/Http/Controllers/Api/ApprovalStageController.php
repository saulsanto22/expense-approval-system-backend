<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreApprovalStageRequest;
use App\Repositories\ApprovalStageRepository;

class ApprovalStageController extends Controller
{
    protected $repository;
    /**
     * @OA\Schema(
     *     schema="ApprovalStageResource",
     *     type="object",
     *     @OA\Property(property="id", type="integer", example=1),
     *     @OA\Property(property="name", type="string", example="Stage 1"),
     *     @OA\Property(property="description", type="string", example="Description of approval stage"),
     *     @OA\Property(property="created_at", type="string", format="date-time", example="2025-01-01T00:00:00Z"),
     *     @OA\Property(property="updated_at", type="string", format="date-time", example="2025-01-01T00:00:00Z")
     * )
     */

    public function __construct(ApprovalStageRepository $repository)
    {
        $this->repository = $repository;
    }
    /**
     * @OA\Post(
     *     path="/api/approval-stages",
     *     tags={"ApprovalStages"},
     *     summary="Create a new approval stage",
     *     @OA\RequestBody(
     *         required=true,
     *         content={
     *             @OA\MediaType(
     *                 mediaType="application/json",
     *                 @OA\Schema(ref="#/components/schemas/StoreApprovalStageRequest")
     *             )
     *         }
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Approval stage created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/ApprovalStageResource")
     *     )
     * )
     */
    public function store(StoreApprovalStageRequest $request)
    {
        $stage =  $this->repository->createApprovalStage($request->validated());
        return ResponseHelper::success($stage, 'Berhasil membuat data', 201);
    }
}
