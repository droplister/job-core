<?php

namespace Droplister\JobCore\Database\Seeds;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(AgencySubElementsTableSeeder::class);
        $this->call(AgencySubElementsDataTableSeeder::class);
        $this->call(HiringPathsTableSeeder::class);
        $this->call(OccupationalSeriesTableSeeder::class);
        $this->call(PayPlansTableSeeder::class);
        $this->call(PositionSchedulesTableSeeder::class);
        $this->call(SecurityClearancesTableSeeder::class);
        $this->call(TravelPercentagesTableSeeder::class);
    }
}