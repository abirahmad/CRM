<?php

use App\Models\Project;
use App\Models\Site;
use Illuminate\Database\Seeder;

class SiteTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create Site
        $site = new Site();
        $site->name = 'Madina Villa';
        $site->unit_id = 1;
        $site->structure_type_id = 1;
        $site->created_by = 2;
        $site->owner_name = 'Nur Hasan';
        $site->owner_phone_no = '019348734834';
        $site->address = 'Rajshahi';
        $site->save();

        // Create Project
        $project = new Project();
        $project->created_by = 2;
        $project->site_id = $site->id;
        $project->type = 'Old';
        $project->unit_id = 1;
        $project->responsible_name = 'Nur Hasan';
        $project->responsible_phone_no = '019348734834';
        $project->size = '200 Ft';
        $project->product_usage_qty = '200';
        $project->comment = 'Need to engage some people in here !';
        $project->save();
    }
}
