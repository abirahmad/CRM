<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

use DB;

class Admin extends Authenticatable
{
    use Notifiable;
    use HasRoles;

    protected $guard_name = 'admin';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'is_central_admin', 'email', 'password', 'api_token', 'unit_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
    
    public static function getLatesVersionApp($app_name="team"){
        $latest_version = "1.0.0";
        $appModel = DB::table('applications')->where('app_short_name', $app_name)->first();
        
        return $appModel->latest_version;
    }
    
    public static function isInstallVersion($email, $app_name="team")
    {
        $latest_version = Admin::getLatesVersionApp($app_name);
        
        $attempt = DB::table('login_attempts')
        ->where('name', $app_name)
        ->where('user_email', $email)
        ->where('version', $latest_version)
        ->orderBy('id', 'desc')
        ->first();
        
        // dd($attempt->version);
        
        if(!is_null($attempt)){
            if($latest_version == $attempt->version){
                return true;
            }
            return $attempt->version;
        }
        return false;
    }
    
     
    public static function getInstalledVersion($email, $app_name="team"){
        
        $attempt = DB::table('login_attempts')
        ->where('name', $app_name)
        ->where('user_email', $email)
        ->orderBy('id', 'desc')
        ->first();
        
        if(!is_null($attempt)){
            return $attempt->version;
        }
        return null;
    }
    
    
}
