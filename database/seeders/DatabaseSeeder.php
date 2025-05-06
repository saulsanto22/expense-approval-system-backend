<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Status;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Status::create(['id' => Status::PENDING, 'name' => 'Menunggu persetujuan']);
        Status::create(['id' => Status::APPROVED, 'name' => 'Disetujui']);
    }
}
