<?php

namespace Database\Seeders;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         // $this->call(UserSeeder::class);
         DB::table('users')->delete();
        //  DB::table('roles')->delete();

		 User::create(
            [
                'role_id'       => 1,
                'name'          => ['en'=> 'Modhi', 'ar'=> 'مضيء العبيدي'],
                'username'      => ['en'=> 'modhi', 'ar'=> 'مضيء العبيدي'],
                'slug'          => 'modhi',
                'email'         => 'eng.modhi2020@gmail.com',
                'phone'         => '774982299',
                'roles_name'         => 'owner',
                'image'         => 'default.png',
                'path'          => 'attachments/users',
                'about'         => 'Bio of admin',
                'password'      => bcrypt('asdasdasd'),
                'created_at'    => date("Y-m-d H:i:s")
            ]);

         User::create([
                'role_id'       => 2,
                'name'          => ['en'=> 'Maged', 'ar'=> 'ماجد الخليدي'],
                'username'      => ['en'=> 'maged', 'ar'=> 'ماجد الخليدي'],
                'slug'          => 'maged',
                'email'         => 'maged@gmail.com',
                'phone'         => '735000909',
                'roles_name'         => 'super_admin',
                'image'         => 'default.png',
                'about'         => '',
                'path'          => 'attachments/users',
                'password'      => bcrypt('735000909'),
                'created_at'    => date("Y-m-d H:i:s")
             ]);
         User::create([
                'role_id'       => 3,
                'name'          => ['en'=> 'User', 'ar'=> 'مستخدم'],
                'username'      => ['en'=> 'user', 'ar'=> 'مستخدم'],
                'slug'          => 'user',
                'email'         => 'user@user.com',
                'phone'         => '77498229900',
                'roles_name'         => 'visitor',
                'image'         => 'default.png',
                'about'         => null,
                'path'          => 'attachments/users',
                'password'      => bcrypt('123456'),
                'created_at'    => date("Y-m-d H:i:s")
        ]);

        $user = User::find(1);
        $user->assignRole('owner');
        // DB::table('roles')->    insert([
        //     [
        //         'name'          => 'Admin',
        //         'guard_name'    => 'web',
        //         'created_at'    => date("Y-m-d H:i:s")
        //     ],
        //     [
        //         'name'          => 'Agent',
        //         'guard_name'    => 'web',
        //         'created_at'    => date("Y-m-d H:i:s")
        //     ],
        //     [
        //         'name'          => 'User',
        //         'guard_name'    => 'web',
        //         'created_at'    => date("Y-m-d H:i:s")
        //     ]
        // ]);
    }
}
