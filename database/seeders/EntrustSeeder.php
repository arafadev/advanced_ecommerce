<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class EntrustSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $faker = Faker::create();

        $adminRole = Role::create(['name' => 'admin', 'display_name' => 'Administration', 'description' => 'Administrator', 'allowed_route' => 'admin',]);
        $supervisorRole = Role::create(['name' => 'supervisor', 'display_name' => 'Supervisor', 'description' => 'Supervisor', 'allowed_route' => 'admin',]);
        $customerRole = Role::create(['name' => 'customer', 'display_name' => 'Customer', 'description' => 'Customer', 'allowed_route' => null,]);

        $admin = User::create(['first_name' => 'Admin', 'last_name' => 'System', 'email' => 'admin@ecommerce.test', 'email_verified_at' => now(), 'mobile' => '966500000000', 'password' => bcrypt('123123123'), 'user_image' => 'avatar.svg', 'status' => 1, 'remember_token' => Str::random(10)]);
        $admin->attachRole($adminRole);

        $supervisor = User::create(['first_name' => 'Supervisor', 'last_name' => 'System', 'email' => 'supervisor@ecommerce.test', 'email_verified_at' => now(), 'mobile' => '966500000001', 'password' => bcrypt('123123123'), 'user_image' => 'avatar.svg', 'status' => 1, 'remember_token' => Str::random(10)]);
        $supervisor->attachRole($supervisorRole);

        $customer = User::create(['first_name' => 'Sami', 'last_name' => 'Mansour', 'email' => 'sami@gmail.com', 'email_verified_at' => now(), 'mobile' => '966500000002', 'password' => bcrypt('123123123'), 'user_image' => 'avatar.svg', 'status' => 1, 'remember_token' => Str::random(10)]);
        $customer->attachRole($customerRole);

        for ($i = 1; $i <= 20; $i++) {

            $random_customer = User::create([
                'first_name' => $faker->firstName,
                'last_name' => $faker->lastName,
                'email' => $faker->unique()->safeEmail,
                'email_verified_at' => now(),
                'mobile' => '96650' . $faker->numberBetween(1000000, 9999999),
                'password' => bcrypt('123123123'),
                'user_image' => 'avatar.svg',
                'status' => 1,
                'remember_token' => Str::random(10)
            ]);
            $random_customer->attachRole($customerRole);

        }

    }
}
