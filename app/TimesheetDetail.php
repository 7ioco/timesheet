<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class TimesheetDetail extends Authenticatable
{
    use Notifiable;
    public $table = 'timesheet_details';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'timesheet_id','start_time','end_time','break_hours','decimal_duration','apn_no','task_no','plc_no'
    ];
    
    public function Timesheet()
    {
        return $this->belongsTo(Timesheet::class,'timesheet_id');
    }

    
}
