<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use App\Models\Apartment;
use Illuminate\Support\Str;

class ApartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        // creo ciclo for per creare nuovo appartamento
        for ($i = 0; $i <10; $i++) {
            $newApartment = new Apartment();
            $newApartment->summary = $faker->sentence();
            $newApartment->rooms = $faker->randomDigitNotNull();
            $newApartment->beds = $faker->randomDigitNotNull();
            $newApartment->bathrooms = $faker->randomDigitNotNull();
            $newApartment->square_meters = $faker->randomNumber(3, false);
            $newApartment->cover_img = $faker->imageUrl(600, 300, 'Apartment', true);
            $newApartment->slug = Str::slug($newApartment->summary, '-');
            $newApartment->visible = true;
            $newApartment->description = $faker->paragraph(5);
            $newApartment->address = $faker->sentence();
            $newApartment->lat = $faker->randomFloat(8, 10, 99);
            $newApartment->lon = $faker->randomFloat(8, 10, 99);
            $newApartment->save();

        }
    }
}
