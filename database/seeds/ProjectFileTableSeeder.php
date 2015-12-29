<?php

use Illuminate\Database\Seeder;

class ProjectFileTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //CodeProject\Entities\ProjectFile::truncate();
        factory(CodeProject\Entities\ProjectFile::class, 10)->create();
    }
}
