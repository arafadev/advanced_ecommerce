<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use App\Models\Permission;
use Faker\Factory as Faker;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

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

        $admin = User::create(['first_name' => 'Admin', 'last_name' => 'System', 'username' => 'admin', 'email' => 'admin@ecommerce.test', 'email_verified_at' => now(), 'mobile' => '966500000000', 'password' => bcrypt('123123123'), 'user_image' => 'avatar.svg', 'status' => 1, 'remember_token' => Str::random(10)]);
        $admin->attachRole($adminRole);

        $supervisor = User::create(['first_name' => 'Supervisor', 'last_name' => 'System', 'username' => 'supervisor', 'email' => 'supervisor@ecommerce.test', 'email_verified_at' => now(), 'mobile' => '966500000001', 'password' => bcrypt('123123123'), 'user_image' => 'avatar.svg', 'status' => 1, 'remember_token' => Str::random(10)]);
        $supervisor->attachRole($supervisorRole);

        $customer = User::create(['first_name' => 'Sami', 'last_name' => 'Mansour', 'username' => 'sami', 'email' => 'sami@gmail.com', 'email_verified_at' => now(), 'mobile' => '966500000002', 'password' => bcrypt('123123123'), 'user_image' => 'avatar.svg', 'status' => 1, 'remember_token' => Str::random(10)]);
        $customer->attachRole($customerRole);

        for ($i = 1; $i <= 20; $i++) {

            $random_customer = User::create([
                'first_name' => $faker->firstName,
                'last_name' => $faker->lastName,
                'username' => $faker->userName,
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


        $manageMain = Permission::create([
            'name' => 'main', // Main page
            'display_name' => 'Main',
            'route' => 'index', // this route for main page
            'module' => 'index',
            'as' => 'index',
            'icon' => 'fas fa-home',
            'parent' => '0',
            'parent_original' => '0',// هو الاوريجينال نفسه ,
            'sidebar_link' => '1',// تقريبا دا معناه ان اللينك دا هيبقي موجود ف السايد بار,
            'appear' => '1', // هيكون ظاهر ام لا ؟,
            'ordering' => '1' // ترتيب اللينكات (هنا انا بقوله خليه اول لينك ) ,
        ]);

        $manageMain->parent_show = $manageMain->id;
        $manageMain->save(); // عندك permission لأول create لحد هنا انت عملت 
// ======================================================================================

        //  PRODUCT CATEGORIES
        $manageProductCategories = Permission::create([
            'name' => 'manage_product_categories',
            'display_name' => 'Categories',
            'route' => 'product_categories',
            'module' => 'product_categories',
            'as' => 'product_categories.index',
            'icon' => 'fas fa-file-archive',
            'parent' => '0',
            'parent_original' => '0',
            'sidebar_link' => '1',
            'appear' => '1',
            'ordering' => '5'
        ]);

        $showProductCategories = Permission::create(['name' => 'show_product_categories', 'display_name' => 'Categories', 'route' => 'product_categories', 'module' => 'product_categories', 'as' => 'product_categories.index', 'icon' => 'fas fa-file-archive', 'parent' => $manageProductCategories->id, 'parent_original' => $manageProductCategories->id, 'parent_show' => $manageProductCategories->id, 'sidebar_link' => '1', 'appear' => '1']);
        $createProductCategories = Permission::create(['name' => 'create_product_categories', 'display_name' => 'Create Category', 'route' => 'product_categories', 'module' => 'product_categories', 'as' => 'product_categories.create', 'icon' => null, 'parent' => $manageProductCategories->id, 'parent_original' => $manageProductCategories->id, 'parent_show' => $manageProductCategories->id, 'sidebar_link' => '1', 'appear' => '0']);
        $displayProductCategories = Permission::create(['name' => 'display_product_categories', 'display_name' => 'Show Category', 'route' => 'product_categories', 'module' => 'product_categories', 'as' => 'product_categories.show', 'icon' => null, 'parent' => $manageProductCategories->id, 'parent_original' => $manageProductCategories->id, 'parent_show' => $manageProductCategories->id, 'sidebar_link' => '1', 'appear' => '0']);
        $updateProductCategories = Permission::create(['name' => 'update_product_categories', 'display_name' => 'Update Category', 'route' => 'product_categories', 'module' => 'product_categories', 'as' => 'product_categories.edit', 'icon' => null, 'parent' => $manageProductCategories->id, 'parent_original' => $manageProductCategories->id, 'parent_show' => $manageProductCategories->id, 'sidebar_link' => '1', 'appear' => '0']);
        $deleteProductCategories = Permission::create(['name' => 'delete_product_categories', 'display_name' => 'Delete Category', 'route' => 'product_categories', 'module' => 'product_categories', 'as' => 'product_categories.destroy', 'icon' => null, 'parent' => $manageProductCategories->id, 'parent_original' => $manageProductCategories->id, 'parent_show' => $manageProductCategories->id, 'sidebar_link' => '1', 'appear' => '0']);


        $manageProductCategories->parent_show = $manageProductCategories->id;
        $manageProductCategories->save();



    }
}
