<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permissions')->delete();
        $permissions = [
            'dashboard', 
            'sliders', 'show sliders', 'add sliders', 'edit sliders', 'delete sliders',
            'aboutus', 'show aboutus', 'add aboutus', 'edit aboutus', 'delete aboutus',
            'contacts', 'show contacts', 'add contacts', 'edit contacts', 'delete contacts',
            'regions', 'show regions', 'add regions', 'edit regions', 'delete regions',
            'cities', 'show cities', 'add cities', 'edit cities', 'delete cities',
            'occupations', 'show occupations', 'add occupations', 'edit occupations', 'delete occupations',
            'testimonials', 'show testimonials', 'add testimonials', 'edit testimonials', 'delete testimonials',
            'services', 'show services', 'add services', 'edit services', 'delete services',
            'opportunities', 'show opportunities', 'add opportunities', 'edit opportunities', 'delete opportunities',
            'questions', 'show questions', 'add questions', 'edit questions', 'delete questions',
            'medias', 'show medias', 'add medias', 'edit medias', 'delete medias',
            'versions', 'show versions', 'add versions', 'edit versions', 'delete versions',
            'gallery', 'show gallery', 'add gallery', 'edit gallery', 'delete gallery',
            'tasks', 'show tasks', 'add tasks', 'edit tasks', 'delete tasks',
            'documentations', 'show documentations', 'add documentations', 'edit documentations', 'delete documentations',
            'revenue_exports', 'show revenue_exports', 'add revenue_exports', 'edit revenue_exports', 'delete revenue_exports',
            'complaints', 'show complaints', 'add complaints', 'edit complaints', 'delete complaints',
            'needs', 'show needs', 'add needs', 'edit needs', 'delete needs',
            'categories', 'show categories', 'add categories', 'edit categories', 'delete categories',
            'tags', 'show tags', 'add tags', 'edit tags', 'delete tags',
            'posts', 'show posts', 'add posts', 'edit posts', 'delete posts',
            'usermanage', 'show usermanage', 'add usermanage', 'edit usermanage', 'delete usermanage',
            'users', 'show users', 'add users', 'edit users', 'delete users',
            'roles', 'show roles', 'add roles', 'edit roles', 'delete roles',
            'departments', 'show departments', 'add departments', 'edit departments', 'delete departments',
            'settings', 'show settings', 'add settings', 'edit settings', 'delete settings',
            'message', 'show message', 'add message', 'edit message', 'delete message',
        
            ];
            foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
            }
    }
}
