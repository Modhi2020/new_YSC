<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->delete();


        $role = Role::create([
                                'name' => 'owner',
                                'guard_name'    => 'web',
                                'created_at'    => date("Y-m-d H:i:s")
                            ]);
                            
        $permissions = Permission::pluck('id','id')->all();
        $role->syncPermissions($permissions);

        $role = Role::create([
                                'name' => 'super_admin',
                                'guard_name'    => 'web',
                                'created_at'    => date("Y-m-d H:i:s")
                            ]);
        $permissions = Permission::pluck('id','id')->all();
        $role->syncPermissions($permissions);

        $manager = [
            'dashboard', 
            'sliders', 'show sliders', 'add sliders', 'edit sliders', 'delete sliders',
            'aboutus', 'show aboutus', 'add aboutus', 'edit aboutus', 'delete aboutus',
            'contacts', 'show contacts', 'add contacts', 'edit contacts', 'delete contacts',
            'regions', 'show regions', 'add regions', 'edit regions', 'delete regions',
            'cities', 'show cities', 'add cities', 'edit cities', 'delete cities',
            'testimonials', 'show testimonials', 'add testimonials', 'edit testimonials', 'delete testimonials',
            'services', 'show services', 'add services', 'edit services', 'delete services',
            'opportunities', 'show opportunities', 'add opportunities', 'edit opportunities', 'delete opportunities',
            'questions', 'show questions', 'add questions', 'edit questions', 'delete questions',
            'medias', 'show medias', 'add medias', 'edit medias', 'delete medias',
            'versions', 'show versions', 'add versions', 'edit versions', 'delete versions',
            'gallery', 'show gallery', 'add gallery', 'edit gallery', 'delete gallery',
            'tasks', 'show tasks', 'add tasks', 'edit tasks', 'delete tasks',
            'revenue_exports', 'show revenue_exports', 'add revenue_exports', 'edit revenue_exports', 'delete revenue_exports',
            'complaints', 'show complaints', 'add complaints', 'edit complaints', 'delete complaints',
            'needs', 'show needs', 'add needs', 'edit needs', 'delete needs',
            'categories', 'show categories', 'add categories', 'edit categories', 'delete categories',
            'tags', 'show tags', 'add tags', 'edit tags', 'delete tags',
            'posts', 'show posts', 'add posts', 'edit posts', 'delete posts',
            'message', 'show message', 'add message', 'edit message', 'delete message',
            
            ];

         
        $role = Role::create([
                                'name' => 'manager',
                                'guard_name'    => 'web',
                                'created_at'    => date("Y-m-d H:i:s")
                            ]);

        $permissions = Permission::whereIn('name',$manager)->pluck('id');
        $role->syncPermissions($permissions);

        $supervisor = [
            'dashboard', 
            'sliders', 'show sliders', 'add sliders', 'edit sliders', 'delete sliders',
            'aboutus', 'show aboutus', 'add aboutus', 'edit aboutus', 'delete aboutus',
            'contacts', 'show contacts', 'add contacts', 'edit contacts', 'delete contacts',
            'regions', 'show regions', 'add regions', 'edit regions', 'delete regions',
            'cities', 'show cities', 'add cities', 'edit cities', 'delete cities',
            'testimonials', 'show testimonials', 'add testimonials', 'edit testimonials', 'delete testimonials',
            'services', 'show services', 'add services', 'edit services', 'delete services',
            'opportunities', 'show opportunities', 'add opportunities', 'edit opportunities', 'delete opportunities',
            'questions', 'show questions', 'add questions', 'edit questions', 'delete questions',
            'medias', 'show medias', 'add medias', 'edit medias', 'delete medias',
            'gallery', 'show gallery', 'add gallery', 'edit gallery', 'delete gallery',
            'tasks', 'show tasks', 'add tasks', 'edit tasks', 'delete tasks',
            'revenue_exports', 'show revenue_exports', 'add revenue_exports', 'edit revenue_exports', 'delete revenue_exports',
            'complaints', 'show complaints', 'add complaints', 'edit complaints', 'delete complaints',
            'needs', 'show needs', 'add needs', 'edit needs', 'delete needs',
            'categories', 'show categories', 'add categories', 'edit categories', 'delete categories',
            'tags', 'show tags', 'add tags', 'edit tags', 'delete tags',
            'posts', 'show posts', 'add posts', 'edit posts', 'delete posts',
            'message', 'show message', 'add message', 'edit message', 'delete message',
            
            ];

        $role = Role::create([
                                'name' => 'supervisor',
                                'guard_name'    => 'web',
                                'created_at'    => date("Y-m-d H:i:s")
                            ]);

        $permissions = Permission::whereIn('name',$supervisor)->pluck('id');
        $role->syncPermissions($permissions);

        $secretarial = [
            'dashboard', 
            'sliders', 'show sliders', 'add sliders', 'edit sliders', 'delete sliders',
            'aboutus', 'show aboutus', 'add aboutus', 'edit aboutus', 'delete aboutus',
            'contacts', 'show contacts', 'add contacts', 'edit contacts', 'delete contacts',
            'regions', 'show regions', 'add regions', 'edit regions', 'delete regions',
            'cities', 'show cities', 'add cities', 'edit cities', 'delete cities',
            'testimonials', 'show testimonials', 'add testimonials', 'edit testimonials', 'delete testimonials',
            'services', 'show services', 'add services', 'edit services', 'delete services',
            'opportunities', 'show opportunities', 'add opportunities', 'edit opportunities', 'delete opportunities',
            'questions', 'show questions', 'add questions', 'edit questions', 'delete questions',
            'medias', 'show medias', 'add medias', 'edit medias', 'delete medias',
            'gallery', 'show gallery', 'add gallery', 'edit gallery', 'delete gallery',
            'tasks', 'show tasks', 'add tasks', 'edit tasks', 'delete tasks',
            'revenue_exports', 'show revenue_exports', 'add revenue_exports', 'edit revenue_exports', 'delete revenue_exports',
            'complaints', 'show complaints', 'add complaints', 'edit complaints', 'delete complaints',
            'needs', 'show needs', 'add needs', 'edit needs', 'delete needs',
            'categories', 'show categories', 'add categories', 'edit categories', 'delete categories',
            'tags', 'show tags', 'add tags', 'edit tags', 'delete tags',
            'posts', 'show posts', 'add posts', 'edit posts', 'delete posts',
            'message', 'show message', 'add message', 'edit message', 'delete message',
            
            ];

        $role = Role::create([
                                'name' => 'secretarial',
                                'guard_name'    => 'web',
                                'created_at'    => date("Y-m-d H:i:s")
                            ]);

        $permissions = Permission::whereIn('name',$secretarial)->pluck('id');
        $role->syncPermissions($permissions);

        
        $teacher = [
            'dashboard', 
            'sliders', 'show sliders', 'add sliders', 'edit sliders', 'delete sliders',
            'aboutus', 'show aboutus', 'add aboutus', 'edit aboutus', 'delete aboutus',
            'contacts', 'show contacts', 'add contacts', 'edit contacts', 'delete contacts',
            'regions', 'show regions', 'add regions', 'edit regions', 'delete regions',
            'cities', 'show cities', 'add cities', 'edit cities', 'delete cities',
            'testimonials', 'show testimonials', 'add testimonials', 'edit testimonials', 'delete testimonials',
            'services', 'show services', 'add services', 'edit services', 'delete services',
            'opportunities', 'show opportunities', 'add opportunities', 'edit opportunities', 'delete opportunities',
            'questions', 'show questions', 'add questions', 'edit questions', 'delete questions',
            'medias', 'show medias', 'add medias', 'edit medias', 'delete medias',
            'gallery', 'show gallery', 'add gallery', 'edit gallery', 'delete gallery',
            'tasks', 'show tasks', 'add tasks', 'edit tasks', 'delete tasks',
            'revenue_exports', 'show revenue_exports', 'add revenue_exports', 'edit revenue_exports', 'delete revenue_exports',
            'complaints', 'show complaints', 'add complaints', 'edit complaints', 'delete complaints',
            'needs', 'show needs', 'add needs', 'edit needs', 'delete needs',
            'categories', 'show categories', 'add categories', 'edit categories', 'delete categories',
            'tags', 'show tags', 'add tags', 'edit tags', 'delete tags',
            'posts', 'show posts', 'add posts', 'edit posts', 'delete posts',
            'message', 'show message', 'add message', 'edit message', 'delete message',
            
            ];

        $role = Role::create([
                                'name' => 'teacher',
                                'guard_name'    => 'web',
                                'created_at'    => date("Y-m-d H:i:s")
                            ]);

        $permissions = Permission::whereIn('name',$teacher)->pluck('id');
        $role->syncPermissions($permissions);

          
        $student = [
            'dashboard', 
            'sliders', 'show sliders', 'add sliders', 'edit sliders', 'delete sliders',
            'aboutus', 'show aboutus', 'add aboutus', 'edit aboutus', 'delete aboutus',
            'contacts', 'show contacts', 'add contacts', 'edit contacts', 'delete contacts',
            'regions', 'show regions', 'add regions', 'edit regions', 'delete regions',
            'cities', 'show cities', 'add cities', 'edit cities', 'delete cities',
            'testimonials', 'show testimonials', 'add testimonials', 'edit testimonials', 'delete testimonials',
            'services', 'show services', 'add services', 'edit services', 'delete services',
            'opportunities', 'show opportunities', 'add opportunities', 'edit opportunities', 'delete opportunities',
            'questions', 'show questions', 'add questions', 'edit questions', 'delete questions',
            'medias', 'show medias', 'add medias', 'edit medias', 'delete medias',
            'gallery', 'show gallery', 'add gallery', 'edit gallery', 'delete gallery',
            'tasks', 'show tasks', 'add tasks', 'edit tasks', 'delete tasks',
            'revenue_exports', 'show revenue_exports', 'add revenue_exports', 'edit revenue_exports', 'delete revenue_exports',
            'complaints', 'show complaints', 'add complaints', 'edit complaints', 'delete complaints',
            'needs', 'show needs', 'add needs', 'edit needs', 'delete needs',
            'categories', 'show categories', 'add categories', 'edit categories', 'delete categories',
            'tags', 'show tags', 'add tags', 'edit tags', 'delete tags',
            'posts', 'show posts', 'add posts', 'edit posts', 'delete posts',
            'message', 'show message', 'add message', 'edit message', 'delete message',
            
            ];

        $role = Role::create([
                                'name' => 'student',
                                'guard_name'    => 'web',
                                'created_at'    => date("Y-m-d H:i:s")
                            ]);

        $permissions = Permission::whereIn('name',$student)->pluck('id');
        $role->syncPermissions($permissions);

        $visitor = [
            'dashboard', 
            'sliders', 'show sliders', 'add sliders', 'edit sliders', 'delete sliders',
            'aboutus', 'show aboutus', 'add aboutus', 'edit aboutus', 'delete aboutus',
            'contacts', 'show contacts', 'add contacts', 'edit contacts', 'delete contacts',
            'regions', 'show regions', 'add regions', 'edit regions', 'delete regions',
            'cities', 'show cities', 'add cities', 'edit cities', 'delete cities',
            'testimonials', 'show testimonials', 'add testimonials', 'edit testimonials', 'delete testimonials',
            'services', 'show services', 'add services', 'edit services', 'delete services',
            'opportunities', 'show opportunities', 'add opportunities', 'edit opportunities', 'delete opportunities',
            'questions', 'show questions', 'add questions', 'edit questions', 'delete questions',
            'medias', 'show medias', 'add medias', 'edit medias', 'delete medias',
            'gallery', 'show gallery', 'add gallery', 'edit gallery', 'delete gallery',
            'tasks', 'show tasks', 'add tasks', 'edit tasks', 'delete tasks',
            'revenue_exports', 'show revenue_exports', 'add revenue_exports', 'edit revenue_exports', 'delete revenue_exports',
            'complaints', 'show complaints', 'add complaints', 'edit complaints', 'delete complaints',
            'needs', 'show needs', 'add needs', 'edit needs', 'delete needs',
            'categories', 'show categories', 'add categories', 'edit categories', 'delete categories',
            'tags', 'show tags', 'add tags', 'edit tags', 'delete tags',
            'posts', 'show posts', 'add posts', 'edit posts', 'delete posts',
            'message', 'show message', 'add message', 'edit message', 'delete message',
            
            ];

        $role = Role::create([
                                'name' => 'visitor',
                                'guard_name'    => 'web',
                                'created_at'    => date("Y-m-d H:i:s")
                            ]);

        $permissions = Permission::whereIn('name',$visitor)->pluck('id');
        $role->syncPermissions($permissions);

        $custom = [
            'dashboard', 
            
            ];

        $role = Role::create([
                                'name' => 'custom',
                                'guard_name'    => 'web',
                                'created_at'    => date("Y-m-d H:i:s")
                            ]);

        $permissions = Permission::whereIn('name',$custom)->pluck('id');
        $role->syncPermissions($permissions);

    }
}
