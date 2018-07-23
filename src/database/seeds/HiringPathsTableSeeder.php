<?php

namespace Droplister\JobCore\Database\Seeds;

use Illuminate\Database\Seeder;

class HiringPathsTableSeeder extends Seeder
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
        $results = $this->fetchApiResults();

        foreach($results->CodeList[0]->ValidValue as $result)
        {
            $data = $this->fetchDataArray($result);

            Droplister\JobCore\App\HiringPaths::firstOrCreate($data);
        }
    }

    /**
     * Return API Results
     *
     * @return object
     */
    private function fetchApiResults()
    {
        $this->curl->get('https://data.usajobs.gov/api/codelist/hiringpaths');

        return json_decode($this->curl->response);
    }

    /**
     * Create In-Memory Data Blob
     *
     * @return array
     */
    private function fetchDataArray($result)
    {
        $code = trim($result->Code);
        $value = title_case(trim($result->Value));
        $disabled = $result->IsDisabled === 'Yes' ? 1 : 0;

        return compact('code', 'value', 'disabled');
    }
}