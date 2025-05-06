<?php

namespace App\Repositories;

use App\Models\Approver;


class ApproverRepository
{

  public function createApprover(array $data)
  {
    return Approver::create($data);
  }
}
