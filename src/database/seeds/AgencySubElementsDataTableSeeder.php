<?php

namespace Droplister\JobCore\Database\Seeds;

use Droplister\JobCore\App\Traits\LinksUrls;

use Illuminate\Database\Seeder;

class AgencySubElementsDataTableSeeder extends Seeder
{
    use LinksUrls;

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
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $results = $this->fetchApiResults();

        foreach($results as $result)
        {
            $data = $this->fetchDataArray($result);

            if($this->guardAgainstNonAgencies($data)) continue;

            $agency->update($data);
        }
    }

    /**
     * Return API Results
     *
     * @return object
     */
    private function fetchApiResults()
    {
        $this->curl->get('https://www.federalregister.gov/api/v1/agencies');

        return json_decode($this->curl->response);
    }

    /**
     * Return Data Blob
     *
     * @return array
     */
    private function fetchDataArray($result)
    {
        $name = trim($result->name);
        $description = $this->urlsToHtml(trim($result->description));
        $url = property_exists($result, 'agency_url') ? trim($result->agency_url) : null;
        $logo_url = property_exists($result, 'logo') && $result->logo ? trim($result->logo->thumb_url) : null;

        return compact('name', 'description', 'url', 'logo_url');
    }

    /**
     * Guard Against Data
     *
     * @return boolean
     */
    private function guardAgainstNonAgencies($data)
    {
        return \Droplister\JobCore\App\AgencySubElements::whereValue($data['name'])->first();
    }
}