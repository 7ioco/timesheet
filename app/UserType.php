<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class UserType extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_type'
    ];
    
    /**
     * Get the users for the brand.
     */
    public function users()
    {
        return $this->hasMany(User::class,'user_type_id','id');
    }

    
}
