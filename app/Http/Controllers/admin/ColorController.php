<?php

namespace App\Http\Controllers\admin;
use App\Http\Controllers\controller;
use App\DataTables\ColorsDatatTable;
use App\Model\color;
use Illuminate\Http\Request;
use Storage;
class ColorController extends Controller
{

	public function index(ColorsDatatTable $trade) {
		return $trade->render('admin.colors.index', ['title' => trans('admin.colors')]);
	}
    public function create()
    {
        return view('admin.colors.create',['title'=>'colors control']);
    }


    public function store(Request $request)
    {
        $data = $this->validate(request(),
        [
            'name_ar'      => 'required',
            'name_en'      => 'required',
            'color'        => 'required',
           
        ], [], [
            'name_ar'      => trans('admin.name_ar'),
            'name_en'      => trans('admin.name_en'),
            'color'      => trans('admin.color'),
        ]);

            color::create($data);
            session()->flash('success', trans('admin.record_added'));
            return redirect(aurl('colors'));
            }


    public function show($id)
    {
    }


    public function edit($id)
    {
        $color = color::find($id);
        $title ='edit';
        return view('admin.colors.edit',compact(['color','title']));
    }


    public function update(Request $request, $id)
    {
    
		$data = $this->validate(request(),
        [
            'name_ar'      => 'required',
            'name_en'      => 'required',
            'color'        => 'required',
           
        ], [], [
            'name_ar'      => trans('admin.name_ar'),
            'name_en'      => trans('admin.name_en'),
            'color'      => trans('admin.color'),
        ]);


    color::where('id', $id)->update($data);
    session()->flash('success', trans('admin.updated_record'));
    return redirect(aurl('colors'));
}


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
	public function destroy($id) {
		$color = color::find($id);
		$color->delete();
		session()->flash('success', trans('admin.deleted_record'));
		return redirect(aurl('colors'));
	}

	public function multi_delete() {
		if (is_array(request('item'))) {
			foreach (request('item') as $id) {
				$color = color::find($id);
				$color->delete();
			}
		} else {
			$color = color::find(request('item'));
			$color->delete();
		}
		session()->flash('success', trans('admin.deleted_record'));
		return redirect(aurl('colors'));
	}
}
