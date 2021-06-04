<?php

namespace App\Imports;

use App\Models\City;
use App\Models\Client;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Str;

class ClientsImport implements ToModel
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        try {
            if (strtolower($row[0]) != "cod") {
                $city = City::where('name', $row[2])->firstOr(function () use ($row) {
                    return City::create([
                        'cod'  => strtoupper(Str::random(6)),
                        "name" => $row[2],
                    ]);
                });
                $city->client()->create([
                    'cod'  => strtoupper(Str::random(6)),
                    "name" => $row[2],
                ]);
            }
        } catch (\Exception $e) {
            \Log::info("Ha Ocurrido un Error {$e->getMessage()}");
        }
    }
}
