<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UserSeeder::class,
            EmployeeSeeder::class,
            RoleSeeder::class,
            CertificateTypeSeeder::class,
            CraftSeeder::class,
            JobPositionSeeder::class,
            ProjectTypeSeeder::class,
            ScopeSeeder::class,
            ProjectSeeder::class,
            PMOrderSeeder::class,
        ]);
    }
}
