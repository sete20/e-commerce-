<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Model\Department;
use Illuminate\Http\Request;

class DepartmentsController extends Controller {
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
        return view('admin.departments.index', ['title' => trans('admin.departments')]);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {
            return view('admin.departments.create', ['title' => trans('admin.create_departments')]);
          
            
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store() {

		$data = $this->validate(request(),
			[
				'dep_name_ar' => 'required',
				'dep_name_en' => 'required',
				'parent'      => 'sometimes|nullable|numeric',
                'description' =>'sometimes|nullable|string',
                'keyword'     =>'sometimes|nullable|string',
				'icon'        => 'sometimes|nullable|'.v_image(),
			], [], [
				'dep_name_ar' => trans('admin.dep_name_ar'),
				'dep_name_en' => trans('admin.dep_name_en'),
				'parent'   => trans('admin.parent'),
				'description'   => trans('admin.description'),
				'keyword'   => trans('admin.keyword'),
				'icon'   => trans('admin.icon'),

			]);
				if (request()->hasFile('icon')) {
					$data['icon'] = up()->upload([
						'file' =>'icon',
						'path'=>'departments',
						'upload_type'=>'single',
						'delete_file' =>'',
					]);
				}
				Department::create($data);
				session()->flash('success', trans('admin.record_added'));
				return redirect(aurl('departments'));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id) {
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id) {
		$department = department::find($id);
		$title   = trans('admin.edit');
		return view('admin.departments.edit', compact('department', 'title'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $r, $id) {
        $data = $this->validate(request(),
        [
            'dep_name_ar' => 'required',
            'dep_name_en' => 'required',
			'parent'      => 'sometimes|nullable|numeric',

            'description' =>'sometimes|nullable|string',
            'keyword'     =>'sometimes|nullable|string',
            'icon'        => 'sometimes|nullable|'.v_image()
        ], [], [
            'dep_name_ar' => trans('admin.dep_name_ar'),
            'dep_name_en' => trans('admin.dep_name_en'),
            'paren'   => trans('admin.parent'),
            'description'   => trans('admin.description'),
            'keyword'   => trans('admin.keyword'),
            'icon'   => trans('admin.icon'),

		]);
		if (request()->hasFile('icon')) {
			$data['icon'] = up()->upload([
				'file' =>'icon',
				'path'=>'departments',
				'upload_type'=>'single',
				'delete_file' =>department::find($id)->icon,
			]);
		}

		department::where('id', $id)->update($data);
		session()->flash('success', trans('admin.updated_record'));
		return redirect(aurl('departments'));
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id) {
		$departments = department::find($id);

		$departments->delete();
		session()->flash('success', trans('admin.deleted_record'));
		return redirect(aurl('departments'));
	}

	public function multi_delete() {
		if (is_array(request('item'))) {
			foreach (request('item') as $id) {
				$departments = department::find($id);
				$departments->delete();
			}
		} else {
			$departments = department::find(request('item'));
			$departments->delete();
		}
		session()->flash('success', trans('admin.deleted_record'));
		return redirect(aurl('departments'));
	}
}
