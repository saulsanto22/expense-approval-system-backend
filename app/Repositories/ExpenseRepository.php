<?php

namespace App\Repositories;

use App\Models\Expense;
use Illuminate\Support\Facades\DB;
use App\Models\Status;
use App\Models\ApprovalStage;
use App\Models\Approval;

class ExpenseRepository
{

  public function createExpense(array $data): Expense
  {
    return DB::transaction(function () use ($data) {
      // Membuat Expense baru dengan status PENDING
      $expense = Expense::create([
        'amount' => $data['amount'],
        'status_id' => Status::PENDING
      ]);

      // Mengambil semua stages approval sesuai urutan ID
      $stages = ApprovalStage::orderBy('id')->get();

      // Membuat Approval untuk setiap stage yang ada
      foreach ($stages as $stage) {
        Approval::create([
          'expense_id' => $expense->id,
          'approver_id' => $stage->approver_id,
          'status_id' => Status::PENDING
        ]);
      }

      return $expense;
    });
  }

  public function approveExpense(int $expenseId, int $approverId): Expense
  {

    return DB::transaction(function () use ($expenseId, $approverId) {
      $expense = Expense::find($expenseId);
      $nextStage = $expense->nextApprovalStage();
      \Log::debug('Next approval stage:', ['nextStage' => $nextStage]);

      if (!$nextStage || $nextStage->approver_id !== $approverId) {
        throw new \Exception('Approver not in correct sequence');
      }

      $approval = $expense->approvals()
        ->where('approver_id', $approverId)
        ->first();

      $approval->update(['status_id' => Status::APPROVED]);

      // Check if all approvals are completed
      $pendingApprovals = $expense->approvals()
        ->where('status_id', Status::PENDING)
        ->count();

      if ($pendingApprovals === 0) {
        $expense->update(['status_id' => Status::APPROVED]);
      }

      return $expense->fresh();
    });
  }

  public function findById(int $id): Expense
  {
    return Expense::with(['approvals.approver', 'approvals.status', 'status'])
      ->findOrFail($id);
  }
}
