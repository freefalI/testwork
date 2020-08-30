<?php

use App\Models\Status;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Status::create(['title'=>'Backlog']);
        Status::create(['title'=>'Development']);
        Status::create(['title'=>'Done']);
        Status::create(['title'=>'Review']);
    }
}
