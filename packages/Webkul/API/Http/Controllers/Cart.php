<?php

namespace Webkul\API\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class Cart extends Controller
{
	public function index()
	{
		$data = DB::table('cart')
		->join('cart_items', function($join){
			$join->on('cart.id', '=', 'cart_items.cart_id');
		})
		->join('product_images', function($join){
			$join->on('cart_items.product_id', '=', 'product_images.product_id');
		})
		->join('product_flat', function($join){
			$join->on('cart_items.product_id', '=', 'product_flat.product_id');
		})
		->select('*', 'product_flat.name as nama_produk')
		->where('cart.is_active', 1)
		->groupBy('product_images.product_id')
		->get();
		return response()->json([
			'cart' => $data,
			'status_code'   => 200,
			'msg'           => 'success',
		], 200);
	}
	public function get($id)
	{
		$data = DB::table('cart')
		->join('cart_items', function($join){
			$join->on('cart.id', '=', 'cart_items.cart_id');
		})
		->join('product_images', function($join){
			$join->on('cart_items.product_id', '=', 'product_images.product_id');
		})
			->join('product_flat', function($join){
			$join->on('cart_items.product_id', '=', 'product_flat.product_id');
		})
		->select('*', 'product_flat.name as nama_produk')
		->groupBy('product_images.product_id')
		->where('customer_id', $id)
		->where('cart.is_active', 1)
		->get();
		return response()->json([
			'cart' => $data,
			'status_code'   => 200,
			'msg'           => 'success',
		], 200);
	}
   public function create(Request $request)
{
	$customer_id = $request->customer_id;
	$is_gift = $request->is_gift;
	$channel_id = $request->channel_id;
	$quantity = $request->quantity;
	$price = $request->price;
	$product_id = $request->product_id;

	$data = DB::table('customers')
	->where('id', $request->customer_id)
	->first();
	$data2 = DB::table('cart')
	->where('customer_id', $request->customer_id)
	->first();
	$data3 = DB::table('product_flat')
	->where('product_id', $request->product_id)
	->first();
	$data4 = DB::table('products')
	->where('id', $request->product_id)
	->first();

	if ($data2 == TRUE) {
		$count  = count($request->product_id);
		for ($i=0; $i < $count; $i++) {
			$create = DB::table('cart_items')
			->insert([
				'cart_id' => $data2->id,
				'sku' => $data3->sku,
				'type' => $data4->type,
				'name' => $data3->name,
				'weight' => $data3->weight,
				'total_weight' => $data3->weight,
				'base_total_weight' => $data3->weight,
				'price' => $data3->price[$i],
				'base_price' => $data3->price[$i],
				'total' => $data3->price[$i] * $request->quantity[$i],
				'base_total' => $data3->price[$i] * $request->quantity[$i],
				'product_id' => $request->product_id[$i],
				'quantity' => $request->quantity[$i],
				'created_at' => now(),
				'updated_at' => now(),
			]);
			DB::table('cart')
			->where('customer_id', $request->customer_id)
			->update([
				'items_count' => $data2->items_count + $request->quantity[$i],
				'items_qty' => $data2->items_count + $request->quantity[$i],
				'grand_total' => $data2->grand_total + ($data3->price[$i] * $request->quantity[$i]),
				'base_grand_total' => $data2->grand_total + ($data3->price[$i] * $request->quantity[$i]),
				'sub_total' => $data2->grand_total + ($data3->price[$i] * $request->quantity[$i]),
				'base_sub_total' => $data2->grand_total + ($data3->price[$i] * $request->quantity[$i]),
				'created_at' => now(),
				'updated_at' => now(),
			]);
		}
		
		return response()->json([
			'cart add' => $create,
			'status_code'   => 200,
			'msg'           => 'success',
		], 201);
	}else{
		for ($i=0; $i < 1; $i++) {
			$create = DB::table('cart')
			->insert([
				'customer_email' => $data->email,
				'customer_first_name' => $data->first_name,
				'customer_last_name' => $data->last_name,
				'customer_id' => $request->customer_id,
				'is_gift' => $request->is_gift,
				'is_active' => 1,
				'channel_id' => $request->channel_id,
				'items_count' => $request->quantity[$i],
				'items_qty' => $request->quantity[$i],
				'global_currency_code' => 'USD',
				'channel_currency_code' => 'IDR',
				'cart_currency_code' => 'IDR',
				'grand_total' => $data3->price * $request->quantity[$i],
				'base_grand_total' => $data3->price * $request->quantity[$i],
				'sub_total' => $data3->price * $request->quantity[$i],
				'base_sub_total' => $data3->price * $request->quantity[$i],
				'created_at' => now(),
				'updated_at' => now(),

			]);
		}
		
		$id = DB::getPdo()->lastInsertId();

		$count  = count($request->product_id);
		for ($i=0; $i < $count; $i++) {
			DB::table('cart_items')
			->insert([
				'cart_id' => $id,
				'sku' => $data3->sku,
				'type' => $data4->type,
				'name' => $data3->name,
				'weight' => $data3->weight,
				'total_weight' => $data3->weight,
				'base_total_weight' => $data3->weight,
				'price' => $data3->price[$i],
				'base_price' => $data3->price[$i],
				'total' => $data3->price[$i] * $request->quantity[$i],
				'base_total' => $data3->price[$i] * $request->quantity[$i],
				'product_id' => $request->product_id[$i],
				'quantity' => $request->quantity[$i],
				'created_at' => now(),
				'updated_at' => now(),

			]);
		}
		return response()->json([
			'cart add' => $create,
			'status_code'   => 200,
			'msg'           => 'success',
		], 201);
	}
	
}
	public function update(Request $request)
	{
		$customer_id = $request->customer_id;
		$is_gift = $request->is_gift;
		$channel_id = $request->channel_id;
		$quantity = $request->quantity;
		$price = $request->price;
		$product_id = $request->product_id;

		$data = DB::table('cart')
		->where('customer_id', $request->customer_id)
		->first();

		if ($data == TRUE) {
			$count  = count($request->product_id);
			for ($i=0; $i < $count; $i++) {
				$data2 = DB::table('cart_items')
				->where('product_id', $request->product_id[$i])
				->update([
					'quantity' => $request->quantity[$i],
				]);
			}
		}

		return response()->json([
			'cart update' => $data2,
			'status_code'   => 200,
			'msg'           => 'success',
		], 201);
	}
	public function delete(Request $request, $id)
	{
		$data = DB::table('cart_items')
		->where('cart_items.id', $request->cart_id)
		->delete();
		return response()->json([
			'User' => $id,
			'Cart' => 'Data Berhasil Dihapus',
			'status_code'   => 200,
			'msg'           => 'success',
		], 200);

	}
}
