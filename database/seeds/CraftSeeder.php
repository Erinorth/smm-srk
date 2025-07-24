<?php

use Illuminate\Database\Seeder;
use App\Models\Craft;

class CraftSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $crafts = [
            [
                'id' => 1,
                'CraftName' => 'Admin',
                'created_at' => '2020-01-21 06:00:00',
                'updated_at' => '2020-01-21 06:00:00',
            ],
            [
                'id' => 2,
                'CraftName' => 'Supervisor',
                'created_at' => '2020-01-21 06:01:00',
                'updated_at' => '2020-01-21 06:01:00',
            ],
            [
                'id' => 3,
                'CraftName' => 'Foreman',
                'created_at' => '2020-01-21 06:01:00',
                'updated_at' => '2020-01-21 06:01:00',
            ],
            [
                'id' => 4,
                'CraftName' => 'Skills',
                'created_at' => '2020-01-21 06:01:00',
                'updated_at' => '2020-01-21 06:01:00',
            ],
        ];

        foreach ($crafts as $craft) {
            Craft::create($craft);
        }
    }
}
