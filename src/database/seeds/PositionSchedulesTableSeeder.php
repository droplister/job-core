<?php

namespace Droplister\JobCore\Database\Seeds;

use Droplister\JobCore\App\PositionSchedule;

use Illuminate\Database\Seeder;

class PositionSchedulesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $schedules = [
            '1' => 'Full-Time',
            '2' => 'Part-Time',
            '3' => 'Shift Work',
            '4' => 'Intermittent',
            '5' => 'Job Sharing',
            '6' => 'Multiple Schedules',
        ];

        foreach($schedules as $code => $value)
        {
            PositionSchedule::firstOrCreate([
                'code' => $code,
                'value' => $value,
            ]);
        }
    }
}