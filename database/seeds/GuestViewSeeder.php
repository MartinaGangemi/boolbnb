<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use App\Models\Guest_View;


class GuestViewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        for ($i = 0; $i <10; $i++) {
            $newView = new Guest_View();
            $newView ->ip_address = $faker->ipv4();
            $newView ->visited_at = $faker->dateTime();
            $newView ->save();

        }
    }
}
