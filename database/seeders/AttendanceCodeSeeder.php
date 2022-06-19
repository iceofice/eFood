<?php

namespace Database\Seeders;

use App\Models\AttendanceCode;
use Illuminate\Database\Seeder;

class AttendanceCodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AttendanceCode::create([
            'code' => 123,
        ]);
    }
}
