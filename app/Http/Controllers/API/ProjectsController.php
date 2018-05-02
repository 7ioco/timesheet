<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\UserType;
use App\Project;
use App\Timesheet;
use App\TimesheetDetail;
use Illuminate\Support\Facades\Auth;
use Validator;

class ProjectsController extends Controller
{

    public $successStatus = 200;

    
    /**
     * Project Add api
     *
     * @return \Illuminate\Http\Response
     */
    public function projectAdd(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'project_title' => 'required',
            'address' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);            
        }

        $input = $request->all();
        $project = Project::create($input);
        $success['msg'] =  $project->project_title.' has been created.';

        return response()->json(['success'=>$success], $this->successStatus);
    }

    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function projectsList()
    {
        $projects = Project::orderBy('project_title','ASC')->get();
        return response()->json(['success' => $projects], $this->successStatus);
    }
    /**
     * Project Details API.
     *
     * @return \Illuminate\Http\Response
     */
    public function projectDetails($id)
    {
        $project = Project::find($id);
        return response()->json(['success' => $project], $this->successStatus);
    }
    /**
     * Project Update api
     *
     * @return \Illuminate\Http\Response
     */
    public function projectUpdate(Request $request,$id)
    {
        $validator = Validator::make($request->all(), [
            'project_title' => 'required',
            'address' => 'required'
            
        ]);

        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);            
        }
        Project::find($id)->update($request->all());
        $success['msg'] =  $request->input('project_title').' has been updated.';
        return response()->json(['success'=>$success], $this->successStatus);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function projectDelete($id)
    {
        Project::find($id)->delete();
        $success['msg'] =  'Project deleted successfully';
        return response()->json(['success'=>$success], $this->successStatus);
    }
    /**
     * Timesheet Add api
     *
     * @return \Illuminate\Http\Response
     */
    public function timesheetAdd(Request $request)
    {
        $input = $request->input('data');
        $post_data = json_decode($input,true);
        
        $save_arr['date'] = date("Y-m-d", strtotime($post_data['date']));
        $times= Timesheet::where(['project_id'=>$post_data['project_id'],'user_id'=>$post_data['user_id'],'date'=>date('Y-m-d',strtotime($post_data['date']))])->first();
        if(!empty($times)){ 
            return response()->json(['success'=>'There is already entry exist for this date and user'], $this->successStatus);
        }else{
            $getRates = User::find($post_data['user_id']);
            $save_arr['client_rate']  = $getRates->client_rate;
            $save_arr['normal_rate']  = $getRates->normal_rate;
            $save_arr['ot_eligible']  = $getRates->ot_eligible;
            $save_arr['ot_rate']      = $getRates->ot_rate;
            $save_arr['normal_hours'] = $getRates->normal_hours;
            $save_arr['entered_by']   = Auth::user()->id;
            $save_arr['user_id']      = $post_data['user_id'];
            $save_arr['project_id']   = $post_data['project_id'];
            $save_arr['verified']     = 0;
            $id = Timesheet::create($save_arr)->id;
        }
        $times_arr = $post_data['times'];
        if(!empty($times_arr)) {
            
            foreach($times_arr as $val) {
                $sdata = $val;
                $sdata['timesheet_id'] = $id;
                $sdata['modified_on'] = date("Y-m-d H:i:s");
                $time1 = strtotime($val['start_time']);
                $time2 = strtotime($val['end_time']);
                $difference = round(abs($time2 - $time1) / 3600,2);
                $sdata['decimal_duration'] = $difference;
                
                if(!TimesheetDetail::create($sdata)){
                    return response()->json(['success'=>'Unable to save data.'], $this->successStatus);
                }
            }
            return response()->json(['success'=>'Your data has been saved.'], $this->successStatus);
        }else{
            return response()->json(['success'=>'Unable to save data.'], $this->successStatus);
        }
        
    }
    /**
     * Timesheet Update api
     *
     * @return \Illuminate\Http\Response
     */
    public function timesheetUpdate(Request $request,$id)
    {
        $input = $request->input('data');
        $post_data = json_decode($input,true);
        
        $save_arr['date'] = date("Y-m-d", strtotime($post_data['date']));
        
        $getRates = User::find($post_data['user_id']);
        $save_arr['client_rate']  = $getRates->client_rate;
        $save_arr['normal_rate']  = $getRates->normal_rate;
        $save_arr['ot_eligible']  = $getRates->ot_eligible;
        $save_arr['ot_rate']      = $getRates->ot_rate;
        $save_arr['normal_hours'] = $getRates->normal_hours;
        $save_arr['user_id']      = $post_data['user_id'];
        $save_arr['project_id']   = $post_data['project_id'];
        $save_arr['verified']     = 0;
        Timesheet::where('id', $id)->update($save_arr);
        
        TimesheetDetail::where('timesheet_id', $id)->delete();
        $times_arr = $post_data['times'];
        if(!empty($times_arr)) {
            
            foreach($times_arr as $val) {
                $sdata = $val;
                $sdata['timesheet_id'] = $id;
                $sdata['modified_on'] = date("Y-m-d H:i:s");
                $time1 = strtotime($val['start_time']);
                $time2 = strtotime($val['end_time']);
                $difference = round(abs($time2 - $time1) / 3600,2);
                $sdata['decimal_duration'] = $difference;
                
                if(!TimesheetDetail::create($sdata)){
                    return response()->json(['success'=>'Unable to update data.'], $this->successStatus);
                }
            }

            return response()->json(['success'=>'Your data has been updated.'], $this->successStatus);
        }else{
            return response()->json(['success'=>'Unable to update data.'], $this->successStatus);
        }
        
    }
    /**
     * Timesheet Details API.
     *
     * @return \Illuminate\Http\Response
     */
    public function timesheetDetails($id)
    {
        $timesheet = Timesheet::with('TimesheetDetail')->find($id);
        return response()->json(['success' => $timesheet], $this->successStatus);
    }
    /**
     * Timesheet List API.
     *
     * @return \Illuminate\Http\Response
     */
    public function timesheetList(Request $request)
    {
        if($request->has('field')){
            $filter = $request->input('field');
            $filter_value = $request->input('value');
            $project_id = $request->input('project_id');
            $timesheet = Timesheet::with('TimesheetDetail')->where([$filter=>$filter_value,'project_id'=>$project_id])->orderBy('date','ASC')->get();
        }else{
            $project_id = $request->input('project_id');
            $timesheet = Timesheet::with('TimesheetDetail')->where(['project_id'=>$project_id])->orderBy('date','ASC')->get();
        }
        return response()->json(['success' => $timesheet], $this->successStatus);
    }
    /**
     * Timesheet Details List API.
     *
     * @return \Illuminate\Http\Response
     */
    public function timesheetDetailsList($time_id)
    {
        $timesheet = TimesheetDetail::with('Timesheet')->where('timesheet_id',$time_id)->orderBy('start_time','ASC')->get();
        return response()->json(['success' => $timesheet], $this->successStatus);
    }
    /**
     * Timesheet summary by position API.
     *
     * @return \Illuminate\Http\Response
     */
    public function timesheetListByPosition(Request $request)
    {
        $project_id = $request->input('project_id');
        $date = $request->input('date');       
        $positions = User::where('position','!=',null)->select('position')->groupBy('position')->get();
        
        foreach($positions as $pos){
            $position = $pos->position;
            $entry_data[$position] = Timesheet::select('timesheets.*')
                     ->leftJoin('users', function($join)
                         {
                             $join->on('users.id', '=', 'timesheets.user_id');
                         })
                     ->where('timesheets.project_id', '=', $project_id)
                     ->where('timesheets.date', '=', $date)
                     ->where('users.position','=',$position)
                     ->orderBy('timesheets.date','DESC')
                     ->get();     
        }
        
        return response()->json(['success' => $entry_data], $this->successStatus);
    }
}