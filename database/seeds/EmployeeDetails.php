<?php

use Illuminate\Database\Seeder;
use App\User;
use Carbon\Carbon;

class EmployeeDetails extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // php artisan migrate:fresh --seed

    User::truncate();

    $Employee_Details = [

        [   
            'name' => 'supervisor',
            'email' => 'supervisor@task.com',
            'password' => '$2y$10$a94RWRNRnNjgh4Nf30d1H.GaKte04Lw6gDnPdbHu/g8HS1c7k9bAy',
            'role' => 'Supervisor',
            'department' => 'Software',
            'Emp_ID' => 'supervisor_001',
            'status' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => null,
        ],

        [   
            'name' => 'user1',
            'email' => 'user1@task.com',
            'password' => '$2y$10$QeK.SWXEfDv4vkb.fRxieew3r2lK63RIWr3lFENP70UitfO.QtuU2',
            'role' => 'Agent',
            'department' => 'Software',
            'Emp_ID' => 'user1_002',
            'status' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => null,
        ],
     ];

     User::insert($Employee_Details);
    }
}
