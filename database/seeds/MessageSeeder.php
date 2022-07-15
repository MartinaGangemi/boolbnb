<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use App\Models\Message;

class MessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        for ($i = 0; $i <10; $i++) {
            $newMessage = new Message();
            $newMessage ->fullname = $faker->name();
            $newMessage ->email = $faker->sentence();
            $newMessage ->description = $faker->paragraph(5);
            $newMessage ->save();

        }
    }
}
