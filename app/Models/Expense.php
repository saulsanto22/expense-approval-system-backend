<?php

namespace App\Models;

use App\Models\Status;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    protected $fillable = ['amount', 'status_id', 'appr'];

    public function approvals()
    {
        return $this->hasMany(Approval::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function nextApprovalStage()
    {
        $approved = $this->approvals()
            ->where('status_id', Status::APPROVED)
            ->pluck('approver_id')
            ->toArray();

        return ApprovalStage::whereNotIn('approver_id', $approved)
            ->orderBy('id')
            ->first();
    }
}
