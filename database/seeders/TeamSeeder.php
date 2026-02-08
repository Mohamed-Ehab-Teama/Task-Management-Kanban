<?php

namespace Database\Seeders;

use App\Models\Team;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $team01 = Team::create(['name' => 'Team 01']);
        $team02 = Team::create(['name' => 'Team 02']);
        $team03 = Team::create(['name' => 'Team 03']);
        
        $team04 = Team::create(['name' => 'Team 04']);
        $team05 = Team::create(['name' => 'Team 05']);
        $team06 = Team::create(['name' => 'Team 06']);
    }
}
