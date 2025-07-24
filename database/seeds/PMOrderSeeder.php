<?php

use Illuminate\Database\Seeder;
use App\Models\PMOrder;

class PMOrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pmOrders = [
            [
                'id' => 1,
                'project_id' => 1,
                'SupPMOrder' => 1,
                'PMOrder' => '999999',
                'PMOrderName' => 'Main',
                'Status' => 'ใชงาน',
                'Remark' => null,
            ],
        ];

        foreach ($pmOrders as $order) {
            PMOrder::create($order);
        }
    }
}
