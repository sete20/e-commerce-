<?php

namespace App\Http\Controllers\admin;
use App\Http\Controllers\controller;
use Illuminate\Http\Request;
use App\DataTables\UsersDatatTable;
use App\user;
class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(UsersDatatTable $admin)
    {
        return $admin->render('admin.users.index',['title'=>'users control']);
    } 

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.users.create',['title'=>'users control']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
   $data =  $request->validate([
        'name'=>'string|required|min:4|max:64',
        'email'=>'required|email|min:10|max:62|unique:users,email|unique:admins,email',
		'password'=>"required|min:8|confirmed",
		'level'=>"required|in:user,company,vendor",
       ]);
       $data['password'] = bcrypt(request('password'));
		user::create($data);
       session()->flash('success', trans('admin.record_added'));
       return redirect(aurl('users'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = user::find($id);
        $title ='edit';
        return view('admin.users.edit',compact(['user','title']));
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
        $data =  $request->validate([
            'name'=>'string|required|min:4|max:16',
            'email'=>'required|email|min:10|max:62|unique:users,email|unique:admins,email'.$id,
			'password'=>"sometimes|nullable|min:8",
            'level'=>"required|in:user,company,vendor",
			
           ]);
           if ($request->has('password')) {
            $data['password'] = bcrypt(request('password'));
           }
           user::where('id',$id)->update($data);
           session()->flash('success', trans('admin.updated_record'));
           return redirect(aurl('user'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        user::find($id)->delete();
        session()->flash('success', trans('admin.deleted_record'));
        return redirect(aurl('admin'));
    }
    public function multi_delete(){
        // return request();
        if (is_array(request('item'))) {
            user::destroy(request('item'));
        }else {
            user::find(request('item'))->delete();
        }
        session()->flash('success', trans('users.deleted_record'));
        return redirect(aurl('users'));
    }
}
