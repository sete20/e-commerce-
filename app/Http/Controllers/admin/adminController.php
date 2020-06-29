<?php

namespace App\Http\Controllers\admin;
use App\Http\Controllers\controller;
use Illuminate\Http\Request;
use App\DataTables\adminDatatTable;
use App\Admin;
class adminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(adminDatatTable $admin)
    {
        return $admin->render('admin.admins.index',['title'=>'admin control']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.admins.create',['title'=>'admin control']);
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
        'email'=>'unique:admins|required|email|min:10|max:62',
        'password'=>"required|min:8|confirmed"
       ]);
       $data['password'] = bcrypt(request('password'));
       Admin::create($data);
       session()->flash('success', trans('admin.record_added'));
       return redirect(aurl('admin'));
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
        $admin = Admin::find($id);
        $title ='edit';
        return view('admin.admins.edit',compact(['admin','title']));
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
            'email'=>'required|email|min:10|max:62|unique:admins,email'.$id,
            'password'=>"sometimes|nullable|min:8"
           ]);
           if ($request->has('password')) {
            $data['password'] = bcrypt(request('password'));
           }
           Admin::where('id',$id)->update($data);
           session()->flash('success', trans('admin.updated_record'));
           return redirect(aurl('admin'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Admin::find($id)->delete();
        session()->flash('success', trans('admin.deleted_record'));
        return redirect(aurl('admin'));
    }
    public function multi_delete(){
        // return request();
        if (is_array(request('item'))) {
            Admin::destroy(request('item'));
        }else {
            Admin::find(request('item'))->delete();
        }
        session()->flash('success', trans('admin.deleted_record'));
        return redirect(aurl('admin'));
    }
}
