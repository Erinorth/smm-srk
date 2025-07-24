<?php

use Illuminate\Database\Seeder;
use App\Models\Employee;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $employees = [
            [
                'user_id' => 1,
                'WorkID' => '123456',
                'ThaiName' => 'แอดมิน',
                'EnglishName' => 'Admin',
                'Position' => 'admin',
                'EGATEmail' => 'admin@egat.co.th',
                'department_id' => 'admin',
                'Admin' => 'Yes',
                'Telephone' => '123456789',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($employees as $employee) {
            Employee::create($employee);
        }
    }
}
