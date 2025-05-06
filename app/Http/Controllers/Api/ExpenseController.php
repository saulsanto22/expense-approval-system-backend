<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\ApproveExpenseRequest;
use App\Http\Requests\StoreExpenseRequest;
use App\Http\Resources\ExpenseResource;
use App\Repositories\ExpenseRepository;
use GuzzleHttp\Psr7\Response;

/**
 * @OA\Tag(
 *     name="Expenses",
 *     description="Expense operations"
 * )
 */
class ExpenseController extends Controller
{
    public function __construct(private ExpenseRepository $repository) {}
    /**
     * @OA\Post(
     *     path="/api/expenses",
     *     tags={"Expenses"},
     *     summary="Create a new expense",
     *     @OA\RequestBody(
     *         required=true,
     *         content={
     *             @OA\MediaType(
     *                 mediaType="application/json",
     *                 @OA\Schema(ref="#/components/schemas/StoreExpenseRequest")
     *             )
     *         }
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Expense created successfully",
     *         content={
     *             @OA\MediaType(
     *                 mediaType="application/json",
     *                 @OA\Schema(ref="#/components/schemas/ExpenseResource")
     *             )
     *         }
     *     )
     * )
     */
    public function store(StoreExpenseRequest $request)
    {
        $expense = $this->repository->createExpense($request->validated());
        return new ExpenseResource($expense);
    }

    /**
     * @OA\Patch(
     *     path="/api/expenses/{id}/approve",
     *     tags={"Expenses"},
     *     summary="Approve an expense",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         content={
     *             @OA\MediaType(
     *                 mediaType="application/json",
     *                 @OA\Schema(ref="#/components/schemas/ApproveExpenseRequest")
     *             )
     *         }
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Expense approved successfully",
     *         @OA\JsonContent(ref="#/components/schemas/ExpenseResource")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Expense not found"
     *     )
     * )
     */
    public function approve(ApproveExpenseRequest $request, $id)
    {
        try {
            $approverId = $request->input('approver_id');
            $expense = $this->repository->approveExpense($id, $approverId);
            return new ExpenseResource($expense);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException) {
            return ResponseHelper::notFound('Expense not found');
        } catch (\Throwable $th) {
            return ResponseHelper::error($th->getMessage());
        }
    }


    /**
     * @OA\Get(
     *     path="/api/expenses/detail/{id}",
     *     tags={"Expenses"},
     *     summary="Get a single expense by ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Expense details",
     *         @OA\JsonContent(ref="#/components/schemas/ExpenseResource")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Expense not found"
     *     )
     * )
     */

    public function show($id)
    {
        try {
            $expense = $this->repository->findById($id);
            return ResponseHelper::success(new ExpenseResource($expense), 'Data Berhasil diambil!!');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException) {
            return ResponseHelper::notFound('Expense not found');
        } catch (\Throwable $th) {
            return ResponseHelper::error($th->getMessage());
        }
    }
}
