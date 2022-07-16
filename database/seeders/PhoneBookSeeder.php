<?php

namespace Database\Seeders;

use App\Models\PhoneBook;
use Illuminate\Database\Seeder;

class PhoneBookSeeder extends Seeder
{
    public function run()
    {
        PhoneBook::factory(10)->create();
    }
}
