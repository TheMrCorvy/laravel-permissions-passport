<?php

namespace Database\Seeders;

use DB;
use Hash;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissionFree = array();

        array_push($permissionFree, Permission::create(['name' => 'pay_slots']));
        array_push($permissionFree, Permission::create(['name' => 'pay_premium']));

        $permissionsPremium = array();

        array_push($permissionsPremium, Permission::create(['name' => 'stop_premium']));
        array_push($permissionsPremium, Permission::create(['name' => 'levae_suggestions']));
        array_push($permissionsPremium, Permission::create(['name' => 'rate_app']));
        
        $roleFreeUser = Role::create(['name' => 'free']);
        $roleFreeUser->syncPermissions($permissionFree);

        $roleSemiPremium = Role::create(['name' => 'semi-premium']);
        $roleFreeUser->syncPermissions($permissionFree);

        $rolePremium = Role::create(['name' => 'premium']);
        $roleFreeUser->syncPermissions($permissionsPremium);



        $freeUser = User::create([
            'name' => 'usuario free',
            'email' => 'mr.corvy@gmail.com',
            'password' => Hash::make('Peni1234'),
        ]); 
        $freeUser->assignRole('free');
        
        $semiPremiumUser = User::create([
            'name' => 'usuario semi-permium',
            'email' => 'mr.corvy2@gmail.com',
            'password' => Hash::make('Peni1234'),
        ]); 
        $semiPremiumUser->assignRole('semi-premium');

        $premiumUser = User::create([
            'name' => 'usuario premium',
            'email' => 'mr.corvy3@gmail.com',
            'password' => Hash::make('Peni1234'),
        ]); 
        $premiumUser->assignRole('premium');
    }
}
