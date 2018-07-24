<?php

namespace Droplister\JobCore\Database\Seeds;

use Illuminate\Database\Seeder;

class AgencySubElementsTableSeeder extends Seeder
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

            // if($this->guardAgainstAgencyWide($data)) continue;

            \Droplister\JobCore\App\AgencySubElements::firstOrCreate($data);
        }
    }

    /**
     * Return API Results
     *
     * @return object
     */
    private function fetchApiResults()
    {
        $this->curl->get('https://data.usajobs.gov/api/codelist/agencysubelements');

        return json_decode($this->curl->response);
    }

    /**
     * Return Data Blob
     *
     * @return array
     */
    private function fetchDataArray($result)
    {
        $parent_code = property_exists($result, 'ParentCode') ? trim($result->ParentCode) : null;
        $code = trim($result->Code);
        $value = trim($result->Value);
        $disabled = $result->IsDisabled === 'Yes' ? 1 : 0;

        return compact('parent_code', 'code', 'value', 'disabled');
    }

    // /**
    //  * Guard Against Data
    //  *
    //  * @return boolean
    //  */
    // private function guardAgainstAgencyWide($data)
    // {
    //     return substr($data['value'], -11) === 'Agency Wide';
    // }
}