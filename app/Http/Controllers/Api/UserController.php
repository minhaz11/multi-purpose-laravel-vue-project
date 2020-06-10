<?php

namespace App\Http\Controllers\Api;
use Image;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
// use Symfony\Component\HttpFoundation\Request;


class UserController extends Controller
{
    public function __construct(){
        $this->middleware('auth:api');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return User::latest()->paginate(5);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'name'=>'required|max:191|string',
            'email'=>'required|email|string',
            'type'=>'required',
            'password'=>'required|min:6'
        ]);
        return User::create([
            'name'=>$request['name'],
            'email'=>$request['email'],
            'type'=>$request['type'],
            'password'=>bcrypt($request['password']),
            'bio'=>$request['bio'],
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $update = User::findOrFail($id);
        $this->validate($request,[
            'name'=>'required|max:191|string',
            'email'=>'required|email|string|unique:users,email,'.$update->id,
            'type'=>'required',
            'password'=>'sometimes|min:6'
        ]);
        $update->update($request->all());
        return ['message'=>'done'];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('isAdmin');
        $delete = User::findOrFail($id);
        $delete->delete();
        return ['message'=>'User deleted'];
    }
    public function profile()
    {
      return  auth('api')->user();
    }
    public function updateInfo(Request $request)
    {
      $user = auth('api')->user();
      $this->validate($request,[
        'name'=>'required|max:191|string',
        'email'=>'required|email|string|unique:users,email,'.$user->id,
        'password'=>'sometimes|min:6'
    ]);

    if( $request->photo != $user->photo){

        $fileName = time(). '.'.explode('/', explode(':',substr($request->photo,0,strpos($request->photo,';')))[1])[1];

        $oldPhoto = public_path().'/uploads/profile/'.$user->photo;

        if(file_exists($oldPhoto)){
            unlink($oldPhoto);
        }
        Image::make($request->photo)->save(public_path().'/uploads/profile/'.$fileName);
        $request->merge(['photo'=> $fileName]);
      }
      if(!empty($request->password)){
        $request->merge(['password'=> bcrypt($request['password'])]);
      }
      $user->update($request->all());
      return ['message'=>'profile hasbeen updated'];

    }
    public function search()
    {

         if($search = \Request::get('q')){
            $user = User::where(function($query) use ($search){
                $query->where('name','LIKE',"%$search%")->orWhere('email','LIKE',"%$search%");
            })->paginate(10);
         } else{
             $user = User::latest()->paginate(10);
         }
         return $user;



    }
}

