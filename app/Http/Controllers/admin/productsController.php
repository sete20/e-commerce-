<?php

namespace App\Http\Controllers\admin;
use App\DataTables\productDatatable;
use App\Http\Controllers\Controller;

use App\Model\product;
use Illuminate\Http\Request;
use Storage;


class productsController extends Controller {
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(productDatatable $product) {
		return $product->render('admin.products.index', ['title' => trans('admin.products')]);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {
		return view('admin.products.create', ['title' => trans('admin.create_products')]);
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
				'product_name_ar' => 'required',
				'product_name_en' => 'required',
				'mob'             => 'required|numeric',
				'code'            => 'required|numeric',
				'logo'            => 'sometimes|nullable|'.v_image(),
			], [], [
				'product_name_ar' => trans('admin.product_name_ar'),
				'product_name_en' => trans('admin.product_name_en'),
				'mob'             => trans('admin.mob'),
				'code'            => trans('admin.code'),
				'logo'            => trans('admin.product_flag'),
			]);

		if (request()->hasFile('logo')) {
			$data['logo'] = up()->upload([
					'file'        => 'logo',
					'path'        => 'products',
					'upload_type' => 'single',
					'delete_file' => '',
				]);
		}

		product::create($data);
		session()->flash('success', trans('admin.record_added'));
		return redirect(aurl('products'));
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
		$product = product::find($id);
		$title   = trans('admin.edit');
		return view('admin.products.edit', compact('product', 'title'));
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
				'product_name_ar' => 'required',
				'product_name_en' => 'required',
				'mob'             => 'required|numeric',
				'code'            => 'required|numeric',
				'logo'            => 'sometimes|nullable|'.v_image(),
			], [], [
				'product_name_ar' => trans('admin.product_name_ar'),
				'product_name_en' => trans('admin.product_name_en'),
				'mob'             => trans('admin.mob'),
				'code'            => trans('admin.code'),
				'logo'            => trans('admin.logo'),
			]);

		if (request()->hasFile('logo')) {
			$data['logo'] = up()->upload([
					'file'        => 'logo',
					'path'        => 'products',
					'upload_type' => 'single',
					'delete_file' => product::find($id)->logo,
				]);
		}

		product::where('id', $id)->update($data);
		session()->flash('success', trans('admin.updated_record'));
		return redirect(aurl('products'));
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id) {
		$products = product::find($id);
		Storage::delete($products->logo);
		$products->delete();
		session()->flash('success', trans('admin.deleted_record'));
		return redirect(aurl('products'));
	}

	public function multi_delete() {
		if (is_array(request('item'))) {
			foreach (request('item') as $id) {
				$products = product::find($id);
				Storage::delete($products->logo);
				$products->delete();
			}
		} else {
			$products = product::find(request('item'));
			Storage::delete($products->logo);
			$products->delete();
		}
		session()->flash('success', trans('admin.deleted_record'));
		return redirect(aurl('products'));
	}
}
