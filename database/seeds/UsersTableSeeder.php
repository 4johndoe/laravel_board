<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        App\Entity\User::create([
            'name' => 'admin',
            'email' => 'admin@crm.com',
            'password' => bcrypt(11111111),
            'status' => App\Entity\User::STATUS_ACTIVE
        ]);

        factory(App\Entity\User::class, 50)->create();
    }
}
