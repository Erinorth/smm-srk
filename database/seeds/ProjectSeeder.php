<?php

use Illuminate\Database\Seeder;
use App\Models\Project;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $projects = [
            [
                'id' => 1,
                'ProjectName' => 'หามลบ ถาลบขอมูลหายหมด',
                'project_type_id' => 1, // ต้องมี project_type_id = 1 ในตาราง project_types
                'StartDate' => '2018-10-28',
                'FinishDate' => '2018-10-28',
                'SiteEngineer' => 1, // ต้องมี employee id = 1
                'AreaManager' => 1, // ต้องมี employee id = 1
                'Supervisor' => 0,
                'Foreman' => 0,
                'Skill' => 0,
                'Status' => 'projects',
                'color' => '',
                'show' => '',
                'KeyDate' => null,
                'KeyDatePath' => null,
                'DailyReport' => null,
                'created_at' => null,
                'updated_at' => null,
            ],
        ];

        foreach ($projects as $project) {
            Project::create($project);
        }
    }
}
