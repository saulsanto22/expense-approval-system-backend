<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Expense;

/**
 * @OA\Schema(
 *     schema="ApproveExpenseRequest",
 *     type="object",
 *     required={"approved_by"},
 *     @OA\Property(
 *         property="approved_by",
 *         type="string",
 *         example="manager1",
 *         description="Nama atau ID pengguna yang menyetujui"
 *     )
 * )
 */
class ApproveExpenseRequest extends FormRequest
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
            'approver_id' => [
                'required',
                'exists:approvers,id',
                function ($attribute, $value, $fail) {
                    $expense = Expense::find($this->route('id'));
                    $nextStage = $expense->nextApprovalStage();

                    // Memastikan approver yang memberikan approval sesuai dengan urutan
                    if (!$nextStage || $nextStage->approver_id != $value) {
                        $fail('Approver tidak sesuai dengan urutan approval.');
                    }
                }
            ]
        ];
    }
}
