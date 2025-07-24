<?php

use Illuminate\Database\Seeder;
use App\Models\Scope;

class ScopeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $scopes = [
            [
                'id' => 1,
                'ScopeName' => 'Minor Inspection',
                'created_at' => '2020-09-16 15:42:00',
                'updated_at' => '2020-09-16 22:42:00',
            ],
            [
                'id' => 2,
                'ScopeName' => 'Medium Inspection',
                'created_at' => '2020-10-02 06:53:00',
                'updated_at' => '2020-10-02 06:53:00',
            ],
            [
                'id' => 3,
                'ScopeName' => 'Major Inspection',
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'id' => 5,
                'ScopeName' => 'Admin/Support',
                'created_at' => '2020-03-15 01:58:00',
                'updated_at' => '2020-03-15 01:58:00',
            ],
            [
                'id' => 6,
                'ScopeName' => 'Test System',
                'created_at' => '2020-10-19 09:34:00',
                'updated_at' => '2020-10-19 16:34:00',
            ],
            [
                'id' => 8,
                'ScopeName' => 'Test Unit',
                'created_at' => '2020-10-19 16:34:00',
                'updated_at' => '2020-10-19 16:34:00',
            ],
            [
                'id' => 9,
                'ScopeName' => 'Load Test',
                'created_at' => null,
                'updated_at' => null,
            ],
        ];

        foreach ($scopes as $scope) {
            Scope::create($scope);
        }
    }
}
