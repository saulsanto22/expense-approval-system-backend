<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="StoreApproverRequest",
 *     type="object",
 *     required={"name", "email"},
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         example="John Doe",
 *         description="Nama approver"
 *     ),

 * )
 */
class StoreApproverRequest extends FormRequest
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
            'name' => 'required|string|unique:approvers,name'
        ];
    }
}
