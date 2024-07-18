<?php

namespace Database\Seeders;

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
        DB::beginTransaction();
        try {

            $this->insertProvince();
            $this->insertMunicipio();

            // Realizar una solicitud GET a la API JSONPlaceholder para obtener datos de prueba
            $httpProvince = $client->get('https://api.digital.gob.do/v1/territories/provinces');

            $data = json_decode($httpProvince->getBody(), true);
            if (isset($data["data"])) {

                foreach ($data["data"] as $key => $value) {

                    //$province = Province::where("api_code", $value["code"])->first();
                    //if (empty($province->id)) {
                    $province = new Province();
                    $province->api_code = $value["code"];
                    $province->name = $value["name"];
                    // $province->slug =  Str::slug($value["name"]);
                    $province->active = 1;
                    $province->save();
                    //}
                }
            }
            $httpMunicipe = $client->get('https://api.digital.gob.do/v1/territories/municipalities');

            $dataMunicipio = json_decode($httpMunicipe->getBody(), true);
            $cont = 0;
            if (isset($dataMunicipio["data"])) {
                // dd(count($dataMunicipio["data"]));
                foreach ($dataMunicipio["data"] as $value) {

                    $province = Province::where("api_code", $value["provinceCode"])->first();

                    //$municipio = Municipio::where("api_code", $value["code"])->first();

                    $municipio = new Municipio();
                    $municipio->api_code = $value["code"];
                    $municipio->name = $value["name"];
                    //$municipio->slug =  Str::slug($value["name"]);
                    $municipio->province_id =   $province->id;
                    $municipio->active = 1;
                    $municipio->save();
                    $cont++;
                }
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            dd($e);
            // Manejar errores en caso de que la solicitud falle

        }
    }

    private function insertProvince()
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

                $province = new Province();
                $province->name = $data->provincia;
                $province->id = $data->provincia_id;
                // $province->slug =  Str::slug($value["name"]);
                $province->active = 1;
                $province->save();
            }
        }
    }
    private function insertMunicipio()
    {
        $jsonPath = public_path('json/municipios.json');

        // Verificar si el archivo existe
        if (File::exists($jsonPath)) {
            $jsonData = File::get($jsonPath);

            // Convertir el JSON en un array
            $dataArray = json_decode($jsonData, true);

            // O si prefieres, convertirlo en un objeto
            $dataObject = json_decode($jsonData);

            foreach ($dataObject as $data) {
                $municipio = new Municipio();
                $municipio->name = $data->municipio;
                $municipio->id = $data->municipio_id;
                $municipio->province_id = $data->provincia_id;
                // $municipio->slug =  Str::slug($value["name"]);
                $municipio->active = 1;
                $municipio->save();
            }
        }
    }
}
