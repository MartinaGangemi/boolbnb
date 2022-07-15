<?php

use Illuminate\Database\Seeder;
use App\Models\Service;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $services = ['Wifi','Parcheggio interno','Belvedere','Asciugacapelli','TV', 'Climatizzatore', 'Microonde'];

        foreach ($services as $service){
            $new_service = new Service();
            $new_service->name = $service;
            $new_service->save();
        }
    }
}
