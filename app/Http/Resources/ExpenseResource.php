<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="ExpenseResource",
 *     type="object",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="amount", type="integer", example=100000),
 *     @OA\Property(property="status", type="string", example="approved")
 * )
 */
class ExpenseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'amount' => $this->amount,
            'status' => [
                'id' => $this->status->id,
                'name' => $this->status->name
            ],
            'approvals' => ApprovalResource::collection($this->approvals)
        ];
    }
}
