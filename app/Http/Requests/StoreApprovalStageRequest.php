<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="StoreApprovalStageRequest",
 *     type="object",
 *     required={"name"},
 *     @OA\Property(property="name", type="string", example="Stage 1"),
 *     @OA\Property(property="description", type="string", example="Description of approval stage")
 * )
 */

class StoreApprovalStageRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'approver_id' => 'required|exists:approvers,id|unique:approval_stages,approver_id'
        ];
    }
}
