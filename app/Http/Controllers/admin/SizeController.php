<?php

namespace App\Http\Controllers\admin;
use App\Http\Controllers\controller;
use App\DataTables\SizesDatatable;
use App\Model\size;
use Illuminate\Http\Request;
use Storage;
class SizeController extends Controller
{

	public function index(SizesDatatable $trade) {
		return $trade->render('admin.sizes.index', ['title' => trans('admin.sizes')]);
	}
    public function create()
    {
        return view('admin.sizes.create',['title'=>'Sizes control']);
    }


    public function store(Request $request)
    {
		$data = $this->validate(request(),
        [
            'name_ar'      => 'required',
            'name_en'      => 'required',
            'department_id'=> 'required|numeric',
            'is_public'    =>'required|in:yes,no'  
           
        ], [], [
            'name_ar'      => trans('admin.name_ar'),
            'name_en'      => trans('admin.name_en'),
            'department_id'      => trans('admin.department_id'),
            'is_public'     => trans('admin.is_public'),
        ]);

            size::create($data);
            session()->flash('success', trans('admin.record_added'));
            return redirect(aurl('sizes'));
            }


    public function show($id)
    {
    }


    public function edit($id)
    {
        $Size = size::find($id);
        $title ='edit';
        return view('admin.sizes.edit',compact(['Size','title']));
    }


    public function update(Request $request, $id)
    {
    
		$data = $this->validate(request(),
        [
            'name_ar'      => 'required',
            'name_en'      => 'required',
            'department_id'=> 'required|numeric',
            'is_public'    =>'required|in:yes,no'  
           
        ], [], [
            'name_ar'      => trans('admin.name_ar'),
            'name_en'      => trans('admin.name_en'),
            'department_id'      => trans('admin.department_id'),
            'is_public'     => trans('admin.is_public'),
        ]);


    size::where('id', $id)->update($data);
    session()->flash('success', trans('admin.updated_record'));
    return redirect(aurl('sizes'));
}


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
	public function destroy($id) {
		$Size = size::find($id);
		$Size->delete();
		session()->flash('success', trans('admin.deleted_record'));
		return redirect(aurl('sizes'));
	}

	public function multi_delete() {
		if (is_array(request('item'))) {
			foreach (request('item') as $id) {
				$Size = size::find($id);
				$Size->delete();
			}
		} else {
            $Size = size::find(request('item'));
			$Size->delete();
		}
		session()->flash('success', trans('admin.deleted_record'));
		return redirect(aurl('sizes'));
    }
    
    
}
