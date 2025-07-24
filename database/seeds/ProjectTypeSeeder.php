<?php

use Illuminate\Database\Seeder;
use App\Models\ProjectType;

class ProjectTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $projectTypes = [
            [
                'id' => 1,
                'TypeName' => 'บํารุงรักษาพลังนํ้าในประเทศ',
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'id' => 2,
                'TypeName' => 'บํารุงรักษาพลังนํ้าตางประเทศ',
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'id' => 3,
                'TypeName' => 'บํารุงรักษาพลังลมในประเทศ',
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'id' => 4,
                'TypeName' => 'บํารุงรักษาเครนในประเทศ',
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'id' => 5,
                'TypeName' => 'บํารุงรักษาใตนํ้า',
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'id' => 6,
                'TypeName' => 'Governor Performance Test',
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'id' => 7,
                'TypeName' => 'สนับสนุนผูปฏิบัติงานแบบฝากสายบังคับบัญชา(คด.17)',
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'id' => 8,
                'TypeName' => 'จัดซื้อ จัดจาง',
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'id' => 9,
                'TypeName' => 'ซอมอุปกรณเครื่องมือ',
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'id' => 10,
                'TypeName' => 'สอบเทียบเครื่องมือ',
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'id' => 11,
                'TypeName' => 'สนับสนุนผูปฏิบัติงานแบบไมฝากสายบังคับบัญชา(คด.16)',
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'id' => 13,
                'TypeName' => 'สํารวจ/ประชุม ภายในประเทศ',
                'created_at' => '2022-11-07 09:45:00',
                'updated_at' => '2022-11-07 09:45:00',
            ],
            [
                'id' => 14,
                'TypeName' => 'สํารวจ/ประชุม ตางประเทศ',
                'created_at' => '2022-11-07 09:52:00',
                'updated_at' => '2022-11-07 09:52:00',
            ],
            [
                'id' => 15,
                'TypeName' => 'ตรวจสอบและทดสอบรอก',
                'created_at' => '2022-08-12 11:04:00',
                'updated_at' => '2022-08-12 11:04:00',
            ],
        ];

        foreach ($projectTypes as $type) {
            ProjectType::create($type);
        }
    }
}
