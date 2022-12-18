<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Spatie\Translatable\HasTranslations;
use App\Traits\EscapeUniCodeJson;
use App\Models\User_type;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

use Illuminate\Contracts\Auth\MustVerifyEmail;


class User extends Authenticatable

{
    use Notifiable;
    use HasRoles;
  
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    use HasTranslations;
    use EscapeUniCodeJson;
    public $translatable = ['name','username'];
    protected $fillable = [
        'name', 'email', 'password', 'role_id', 'username', 'image', 'about','slug','roles_name','status','path'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        // 'email_verified_at' => 'datetime',
        'roles_name' => 'array',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function hasRoles()
    {
        return $this->role->name;
    } 

    public function departments()
    {
        return $this->belongsToMany('App\Models\Department','user_departments')->withPivot(
            'date',
            
           );
     }

    
    public function user_status()
    {
        // return $this->belongsTo(UserStatu::class);
        return $this->belongsTo('App\Models\UserStatu', 'status');
    }

    public function get_roles_name($val)
    {
        return UserType::where('roles_name','LIKE','%'.$val.'%')->value('name');
        
    }

}
