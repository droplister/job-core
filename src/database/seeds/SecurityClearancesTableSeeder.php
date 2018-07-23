<?php

namespace Droplister\JobCore\Database\Seeds;

use Illuminate\Database\Seeder;

class SecurityClearancesTableSeeder extends Seeder
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
        $clearances = [
            '0' => 'Not Applicable',
            '1' => 'Confidential',
            '2' => 'Secret',
            '3' => 'Top Secret',
            '4' => 'Top Secret/SCI',
            '5' => 'Q - Sensitive',
            '6' => 'Q - Nonsensitive',
            '7' => 'L - Atomic Energy',
            '8' => 'Other',
            '9' => 'Public Trust - Background Investigation',
        ];

        foreach($clearances as $code => $value)
        {
            Droplister\JobCore\App\SecurityClearances::firstOrCreate([
                'code' => $code,
                'value' => $value,
            ]);
        }
    }
}