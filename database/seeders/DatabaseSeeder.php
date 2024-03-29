<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Customer;
use App\Models\Item;
use App\Models\Purchase;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            ItemSeeder::class
        ]);
        
        Customer::factory(1000)->create();

        $items = Item::all();

        Purchase::factory(30000)->create()->each(function(Purchase $p) use ($items) {
            $p->items()->attach(
                $items->random(rand(1, 3))->pluck('id')->toArray(),
                ['quantity' => rand(1, 5)]
            );
        });

        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
