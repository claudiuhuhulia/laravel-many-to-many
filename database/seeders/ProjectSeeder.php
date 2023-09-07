<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\Type;
use Faker\Generator;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use illuminate\Support\Str;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(Generator $faker): void
    {
        $type_ids = Type::pluck('id')->toArray();


        for ($i = 0; $i < 50; $i++) {
            $project = new Project();
            $project->type_id = Arr::random($type_ids);
            $project->name = $faker->text(20);
            $project->slug = Str::slug($project->name, '-');
            $project->image = $faker->imageURL(250, 250);
            $project->content = $faker->paragraphs(15, true);
            $project->save();
        }
    }
}
