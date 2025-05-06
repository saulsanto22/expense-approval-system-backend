<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="StoreExpenseRequest",
 *     type="object",
 *     required={"amount"},
 *     @OA\Property(
 *         property="amount",
 *         type="integer",
 *         minimum=1,
 *         example=100000,
 *         description="Jumlah pengeluaran"
 *     )
 * )
 */
class StoreExpenseRequest extends FormRequest
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
            'amount' => 'required|integer|min:1'
        ];
    }
}
