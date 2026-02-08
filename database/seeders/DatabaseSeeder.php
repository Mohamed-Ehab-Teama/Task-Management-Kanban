<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        // 1️⃣ Create Users
        $userIds = [];
        for ($i = 1; $i <= 10; $i++) {
            $userIds[] = DB::table('users')->insertGetId([
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // 2️⃣ Create Teams
        $teamIds = [];
        for ($i = 1; $i <= 3; $i++) {
            $teamIds[] = DB::table('teams')->insertGetId([
                'name' => $faker->company,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        foreach ($teamIds as $teamId) {

            // 3️⃣ Attach users to team with roles
            $teamUserCount = rand(3, 6);
            $assignedUsers = $faker->randomElements($userIds, $teamUserCount);
            foreach ($assignedUsers as $userId) {
                DB::table('team_user')->insert([
                    'team_id' => $teamId,
                    'user_id' => $userId,
                    'role' => $faker->randomElement(['admin', 'manager', 'member']),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            // 4️⃣ Create Boards
            $boardCount = rand(1, 3);
            $boardIds = [];
            for ($b = 1; $b <= $boardCount; $b++) {
                $boardIds[] = DB::table('boards')->insertGetId([
                    'team_id' => $teamId,
                    'name' => $faker->catchPhrase,
                    'description' => $faker->sentence,
                    'is_archived' => false,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            foreach ($boardIds as $boardId) {

                // 5️⃣ Create Columns (fixed names)
                $columns = ['To Do', 'In Progress', 'Review', 'Done'];
                $columnIds = [];
                foreach ($columns as $index => $columnName) {
                    $columnIds[] = DB::table('columns')->insertGetId([
                        'board_id' => $boardId,
                        'name' => $columnName,
                        'position' => $index + 1,
                        'wip_limit' => rand(2, 10),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }

                foreach ($columnIds as $columnId) {

                    // 6️⃣ Create Tasks
                    $taskCount = rand(3, 6);
                    for ($t = 1; $t <= $taskCount; $t++) {

                        $createdBy = $faker->randomElement($userIds);

                        $taskId = DB::table('tasks')->insertGetId([
                            'board_id' => $boardId,
                            'column_id' => $columnId,
                            'title' => $faker->sentence(3),
                            'description' => $faker->paragraph,
                            'priority' => $faker->randomElement(['Low', 'Medium', 'High', 'Urgent']),
                            'due_date' => $faker->dateTimeBetween('now', '+1 month')->format('Y-m-d'),
                            'estimate_minutes' => rand(30, 300),
                            'actual_minutes' => rand(30, 300),
                            'position' => $t,
                            'is_archived' => false,
                            'created_by' => $createdBy,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);

                        // 7️⃣ Assign 1-3 users from the team to this task
                        $assignedUsersToTask = $faker->randomElements($assignedUsers, rand(1, min(3, count($assignedUsers))));
                        foreach ($assignedUsersToTask as $userId) {
                            DB::table('task_assignments')->insert([
                                'task_id' => $taskId,
                                'user_id' => $userId,
                                'created_at' => now(),
                                'updated_at' => now(),
                            ]);
                        }
                    }
                }
            }
        }
    }
}
