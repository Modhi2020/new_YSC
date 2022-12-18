<?php

namespace Database\Seeders;

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
      
        $this->call(PostApprovedSeeder::class);
        $this->call(PostStatusSeeder::class);

        $this->call(AgreeSeeder::class);
        $this->call(JobTypeSeeder::class);
        $this->call(DirectorateSeeder::class);
        $this->call(SessionTypeSeeder::class);
        $this->call(CorrectAnswerSeeder::class);
        $this->call(SubmitMethodSeeder::class);
        $this->call(OpportunityTypeSeeder::class);
        $this->call(QuestionTypeSeeder::class);

        $this->call(UserTypeSeeder::class);
        $this->call(UserStatusSeeder::class);
        $this->call(PermissionTableSeeder::class);
        $this->call(RoleTableSeeder::class);
        $this->call(UserSeeder::class);
    }
}