<?php

namespace Droplister\JobCore\Database\Seeds;

use Illuminate\Database\Seeder;

class TravelPercentagesTableSeeder extends Seeder
{
    /**
     * USAJobs.gov API
     *
     * @var Curl
     */
    protected $curl;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->curl = new \Curl\Curl();
        $this->curl->setHeader('Host', config('job-core.usajobs_host'));
        $this->curl->setHeader('User-Agent', config('job-core.usajobs_email'));
        $this->curl->setHeader('Authorization-Key', config('job-core.usajobs_key'));
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $percentages = [
            '0' => 'Not Required',
            '1' => 'Occasional Travel',
            '2' => '25% or Greater',
            '5' => '50% or Greater',
            '7' => '75% or Greater',
        ];

        foreach($percentages as $code => $value)
        {
            \Droplister\JobCore\App\TravelPercentage::firstOrCreate([
                'code' => $code,
                'value' => $value,
            ]);
        }
    }
}