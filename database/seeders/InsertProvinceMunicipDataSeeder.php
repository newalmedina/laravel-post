<?php

namespace Database\Seeders;

use App\Models\Country;
use App\Models\Municipio;
use App\Models\Province;
use Illuminate\Database\Seeder;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class InsertProvinceMunicipDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $client = new Client();


        $countrySlug = $this->insertCountry();

        $this->insertProvince($countrySlug);
        $this->insertMunicipio();

        // Realizar una solicitud GET a la API JSONPlaceholder para obtener datos de prueba
        // $httpProvince = $client->get('https://api.digital.gob.do/v1/territories/provinces');

        // $data = json_decode($httpProvince->getBody(), true);
        // if (isset($data["data"])) {

        //     foreach ($data["data"] as $key => $value) {

        //         //$province = Province::where("api_code", $value["code"])->first();
        //         //if (empty($province->id)) {
        //         $province = new Province();
        //         $province->api_code = $value["code"];
        //         $province->name = $value["name"];
        //         // $province->slug =  Str::slug($value["name"]);
        //         $province->active = 1;
        //         $province->save();
        //         //}
        //     }
        // }
        // $httpMunicipe = $client->get('https://api.digital.gob.do/v1/territories/municipalities');

        // $dataMunicipio = json_decode($httpMunicipe->getBody(), true);
        // $cont = 0;
        // if (isset($dataMunicipio["data"])) {
        //     // dd(count($dataMunicipio["data"]));
        //     foreach ($dataMunicipio["data"] as $value) {

        //         $province = Province::where("api_code", $value["provinceCode"])->first();

        //         //$municipio = Municipio::where("api_code", $value["code"])->first();

        //         $municipio = new Municipio();
        //         $municipio->api_code = $value["code"];
        //         $municipio->name = $value["name"];
        //         //$municipio->slug =  Str::slug($value["name"]);
        //         $municipio->province_id =   $province->id;
        //         $municipio->active = 1;
        //         $municipio->save();
        //         $cont++;
        //     }
        // }
    }

    private function insertCountry()
    {
        $country = Country::where("slug", Str::slug("ES"))->first();

        if (empty($country->id)) {
            $country = new Country();
            $country->name = "España";
            $country->slug =  Str::slug("ES");
            $country->active = 1;
            $country->save();
        }
        return $country->id;
    }
    private function insertProvince($country)
    {
        $jsonPath = public_path('json/provincias.json');

        // Verificar si el archivo existe
        if (File::exists($jsonPath)) {
            $jsonData = File::get($jsonPath);

            // Convertir el JSON en un array
            $dataArray = json_decode($jsonData, true);

            // O si prefieres, convertirlo en un objeto
            $dataObject = json_decode($jsonData);

            foreach ($dataObject as $data) {
                $province = Province::where("api_code", $data->code)->first();

                if (!empty($province->id)) {
                    continue;
                }

                $province = new Province();
                $province->api_code = $data->code;
                $province->name = $data->label;
                $province->country_id = $country;
                // $province->slug =  Str::slug($value["name"]);
                $province->active = 1;
                $province->save();
            }
        }
    }

    private function insertMunicipio()
    {
        $jsonPath = public_path('json/poblaciones.json');

        // Verificar si el archivo existe
        if (File::exists($jsonPath)) {
            $jsonData = File::get($jsonPath);

            // Convertir el JSON en un array
            $dataArray = json_decode($jsonData, true);

            // O si prefieres, convertirlo en un objeto
            $dataObject = json_decode($jsonData);

            foreach ($dataObject as $data) {
                $provincia = Province::where("api_code", $data->parent_code)->first();

                $municipio = Municipio::where("api_code", $data->code)->first();
                if (empty($provincia->id)) {
                    continue;
                }

                $municipio = new Municipio();
                $municipio->name = $data->label;
                $municipio->api_code = $data->code;
                $municipio->province_id = $provincia->id;
                // $municipio->slug =  Str::slug($value["name"]);
                $municipio->active = 1;
                $municipio->save();
            }
        }
    }
}
