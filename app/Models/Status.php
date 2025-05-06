<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use HasFactory;
    public const PENDING = 1;
    public const APPROVED = 2;

    protected $fillable = ['name'];
}
