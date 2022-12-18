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
        $this->call(PropertyPurposeSeeder::class);
        $this->call(PropertyTypeSeeder::class);
        $this->call(PostApprovedSeeder::class);
        $this->call(PostStatusSeeder::class);

        $this->call(AgreeSeeder::class);
        $this->call(DenouncementTypeSeeder::class);
        $this->call(DiarySeeder::class);
        $this->call(DiaryStateSeeder::class);
        $this->call(SideTypeSeeder::class);
        $this->call(IncentivesTypeSeeder::class);
        $this->call(JobTypeSeeder::class);
        $this->call(DirectorateSeeder::class);
        $this->call(ReminderNotificationSeeder::class);
        $this->call(RequirementsTypeSeeder::class);
        $this->call(TaskDegreeSeeder::class);
        $this->call(TaskStateSeeder::class);
        $this->call(TasksTypeSeeder::class);
        $this->call(WaqfTypeSeeder::class);
        $this->call(SessionTypeSeeder::class);
        $this->call(CorrectAnswerSeeder::class);
        $this->call(DepartmentTypeSeeder::class);
        $this->call(MyeventSeeder::class);
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