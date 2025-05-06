<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use App\Models\ApprovalStage;

class ApprovalStageRepository
{
  public function createApprovalStage(array $data)
  {
    return DB::transaction(function () use ($data) {
      return ApprovalStage::create($data);
    });
  }
}
