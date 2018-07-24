<?php

namespace Droplister\JobCore\Database\Seeds;

use Illuminate\Database\Seeder;

class OccupationalSeriesTableSeeder extends Seeder
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

            \Droplister\JobCore\App\OccupationalSeries::firstOrCreate($data);
        }
    }

    /**
     * Return API Results
     *
     * @return object
     */
    private function fetchApiResults()
    {
        $this->curl->get('https://data.usajobs.gov/api/codelist/occupationalseries');

        return json_decode($this->curl->response);
    }

    /**
     * Return Data Blob
     *
     * @return array
     */
    private function fetchDataArray($result)
    {
        $job_family = trim($result->JobFamily);
        $code = trim($result->Code);
        $value = trim($result->Value);
        $disabled = $result->IsDisabled === 'Yes' ? 1 : 0;

        return compact('job_family' , 'code', 'value', 'disabled');
    }
}