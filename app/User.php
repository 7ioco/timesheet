<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;
    public $table = 'users';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','user_type_id','position','phone_no','normal_hours','ot_eligible','ot_rate','normal_rate','client_rate','city','state','country','postal_code'
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
     * Get the user type that owns the comment.
     */
    public function userType()
    {
        return $this->belongsTo(UserType::class,'user_type_id');
    }
    
    public function setPasswordAttribute($password)
    {
        if(Hash::needsRehash($password)) 
            $password = Hash::make($password);
    
        $this->attributes['password'] = $password;
    }
}
