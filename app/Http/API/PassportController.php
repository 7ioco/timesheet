<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\UserType;
use Illuminate\Support\Facades\Auth;
use Validator;

class PassportController extends Controller
{

    public $successStatus = 200;

    /**
     * login api
     *
     * @return \Illuminate\Http\Response
     */
    public function login(){
        if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){
            $user = Auth::user();
            $success['token'] =  $user->createToken('MyApp')->accessToken;
            return response()->json(['success' => $success], $this->successStatus);
        }
        else{
            return response()->json(['error'=>'Unauthorised'], 401);
        }
    }

    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);            
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] =  $user->createToken('MyApp')->accessToken;
        $success['name'] =  $user->name;

        return response()->json(['success'=>$success], $this->successStatus);
    }

    /**
     * details api
     *
     * @return \Illuminate\Http\Response
     */
    public function getDetails()
    {
        $user = Auth::user();
        return response()->json(['success' => $user], $this->successStatus);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function userList()
    {
        $users = User::with('UserType')->orderBy('position','ASC')->get();
        return response()->json(['success' => $users], $this->successStatus);
    }
    /**
     * User Details API.
     *
     * @return \Illuminate\Http\Response
     */
    public function userDetails($id)
    {
        $user = User::find($id);
        return response()->json(['success' => $user], $this->successStatus);
    }
    /**
     * User Update api
     *
     * @return \Illuminate\Http\Response
     */
    public function userUpdate(Request $request,$id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'sometimes',
            
        ]);

        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);            
        }
        
        if ($request->filled('password')) {
            $input = $request->all();
            $input['password'] = bcrypt($input['password']);
            User::find($id)->update($input);
        }else{
            User::find($id)->update($request->except('password'));
        }
        $success['msg'] =  $request->input('name').' is updated.';
        return response()->json(['success'=>$success], $this->successStatus);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function userTypesList()
    {
        $users = UserType::orderBy('id','ASC')->get();
        return response()->json(['success' => $users], $this->successStatus);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function userDelete($id)
    {
        User::find($id)->delete();
        $success['msg'] =  'User deleted successfully';
        return response()->json(['success'=>$success], $this->successStatus);
    }
}