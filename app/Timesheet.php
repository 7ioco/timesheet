<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Timesheet extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'project_id','user_id','date','client_rate','normal_rate','ot_eligible','ot_rate','normal_hours','entered_by','verified'
    ];
    
    
    /**
     * Get the Timesheet detail that owns the comment.
     */
    public function TimesheetDetail()
    {
        return $this->hasMany(TimesheetDetail::class,'timesheet_id');
    }
    
}
