<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Generator as Faker;
use App\Models\Admin\Project;
use App\Models\Admin\Type;

use Illuminate\Support\Str;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {

        for ($i = 0; $i < 10; $i++) {
            $new_project = new Project();

            $new_project->name = $faker->sentence;
            $new_project->client = $faker->company;
            $new_project->description = $faker->text(200);
            $new_project->cover_image = $faker->imageUrl(640, 480, 'animals', true);
            $new_project->slug = Str::slug($new_project->name, '-');
            $new_project->save();
        }
    }
}
