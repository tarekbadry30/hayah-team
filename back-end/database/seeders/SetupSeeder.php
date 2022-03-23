<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Testing\Fluent\Concerns\Has;

class SetupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Admin::create([
            'name'              =>  'admin',
            'phone'             =>  '123456',
            'national_number'   =>  '123456',
            'password'          =>  Hash::make('123456'),
        ]);
    }
}
