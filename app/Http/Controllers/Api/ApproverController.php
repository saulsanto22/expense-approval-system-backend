<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreApproverRequest;
use App\Helpers\ResponseHelper;
use App\Repositories\ApproverRepository;

/**
 * @OA\Tag(
 *     name="Approvers",
 *     description="Approver operations"
 * )
 */
class ApproverController extends Controller
{
    protected $approverRepository;
    public function __construct(ApproverRepository $approverRepository)
    {
        $this->approverRepository = $approverRepository;
    }
    /**
     * @OA\Schema(
     *     schema="ApproverResource",
     *     type="object",
     *     @OA\Property(property="id", type="integer", example=1),
     *     @OA\Property(property="name", type="string", example="John Doe"),
     *     @OA\Property(property="created_at", type="string", format="date-time", example="2025-01-01T00:00:00Z")
     * )
     */

    /**
     * @OA\Post(
     *     path="/api/approvers",
     *     tags={"Approvers"},
     *     summary="Create a new approver",
     *     @OA\RequestBody(
     *         required=true,
     *         content={
     *             @OA\MediaType(
     *                 mediaType="application/json",
     *                 @OA\Schema(ref="#/components/schemas/StoreApproverRequest")
     *             )
     *         }
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Approver created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Berhasil membuat data baru!"),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="name", type="string", example="John Doe"),
     *                 @OA\Property(property="created_at", type="string", format="date-time", example="2025-01-01T00:00:00Z")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid data"
     *     )
     * )
     */
    public function __invoke(StoreApproverRequest $request)
    {
        $approver = $this->approverRepository->createApprover($request->validated());
        return ResponseHelper::success($approver, 'Berhasil membuat data baru!', 201);
    }
}
