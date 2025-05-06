<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Approver extends Model
{

    protected $table = 'approvers';
    protected $fillable = ['name'];
}
