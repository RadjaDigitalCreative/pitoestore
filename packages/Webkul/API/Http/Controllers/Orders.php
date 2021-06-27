<?php

namespace Webkul\API\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class Orders extends Controller
{
	public function index()
	{
		$data = DB::table('orders')
		->select(
			'orders.increment_id', 
			'orders.status', 
			'orders.is_guest',
			'orders.customer_email',
			'orders.customer_first_name',
			'orders.customer_last_name',
			'orders.customer_company_name',
			'orders.customer_vat_id',
			'orders.shipping_method',
			'orders.shipping_title',
			'orders.shipping_description',
			'orders.is_gift',
			'orders.total_item_count',
			'orders.total_qty_ordered',
			'orders.base_currency_code',
			'orders.channel_currency_code',
			'orders.order_currency_code',
			'orders.grand_total',
			'orders.base_grand_total',
			'orders.grand_total_invoiced',
			'orders.base_grand_total_invoiced',
			'orders.base_grand_total_refunded',
			'orders.sub_total',
			'orders.base_sub_total',
			'orders.sub_total_invoiced',
			'orders.base_sub_total_invoiced',
			'orders.sub_total_refunded',
			'orders.base_sub_total_refunded',
			'orders.discount_percent',
			'orders.discount_amount',
			'orders.base_discount_amount',
			'orders.discount_invoiced',
			'orders.base_discount_invoiced',
			'orders.discount_refunded',
			'orders.base_discount_refunded',
			'orders.tax_amount',
			'orders.base_tax_amount',
			'orders.tax_amount_invoiced',
			'orders.tax_amount_refunded',
			'orders.shipping_amount',
			'orders.base_shipping_amount',
			'orders.base_shipping_invoiced',
			'orders.shipping_refunded',
			'orders.base_shipping_refunded',
			'orders.customer_id',
			'orders.channel_id',
			'orders.cart_id',
		)
		->get();


		$data2 = DB::table('orders')
		->join('shipments', function($join){
			$join->on('orders.id', '=', 'shipments.order_id')
			->on('orders.customer_id', '=', 'shipments.customer_id');
		})
		->join('invoices', function($join){
			$join->on('orders.id', '=', 'invoices.order_id');
		})
		->select(
			'shipments.status',
			'shipments.total_qty',
			'shipments.total_weight',
			'shipments.carrier_code',
			'shipments.track_number',
			'shipments.email_sent',
			'shipments.customer_id',
			'shipments.order_id',
			'shipments.order_address_id',
			'shipments.inventory_source_id',
			'shipments.inventory_source_name',
		)
		->get();
		$data3 = DB::table('orders')
		->join('invoices', function($join){
			$join->on('orders.id', '=', 'invoices.order_id');
		})
		->select(
			'invoices.increment_id',
			'invoices.state',
			'invoices.email_sent',
			'invoices.total_qty',
			'invoices.base_currency_code',
			'invoices.channel_currency_code',
			'invoices.order_currency_code',
			'invoices.sub_total',
			'invoices.base_sub_total',
			'invoices.grand_total',
			'invoices.base_grand_total',
			'invoices.base_shipping_amount',
			'invoices.tax_amount',
			'invoices.base_tax_amount',
			'invoices.discount_amount',
			'invoices.base_discount_amount',
			'invoices.order_id',
			'invoices.order_address_id',
			'invoices.transaction_id',
		)
		->get();
		return response()->json([
			'orders [menunggu konfirmasi]' => $data,
			'invoices [sedang diproses]' => $data3,
			'shipments [sedang dikirim]' => $data2,
			'status_code'   => 200,
			'msg'           => 'success',
		], 200);

	}
	public function get($id)
	{
		$data = DB::table('orders')
		->select(
			'orders.increment_id', 
			'orders.status', 
			'orders.is_guest',
			'orders.customer_email',
			'orders.customer_first_name',
			'orders.customer_last_name',
			'orders.customer_company_name',
			'orders.customer_vat_id',
			'orders.shipping_method',
			'orders.shipping_title',
			'orders.shipping_description',
			'orders.is_gift',
			'orders.total_item_count',
			'orders.total_qty_ordered',
			'orders.base_currency_code',
			'orders.channel_currency_code',
			'orders.order_currency_code',
			'orders.grand_total',
			'orders.base_grand_total',
			'orders.grand_total_invoiced',
			'orders.base_grand_total_invoiced',
			'orders.base_grand_total_refunded',
			'orders.sub_total',
			'orders.base_sub_total',
			'orders.sub_total_invoiced',
			'orders.base_sub_total_invoiced',
			'orders.sub_total_refunded',
			'orders.base_sub_total_refunded',
			'orders.discount_percent',
			'orders.discount_amount',
			'orders.base_discount_amount',
			'orders.discount_invoiced',
			'orders.base_discount_invoiced',
			'orders.discount_refunded',
			'orders.base_discount_refunded',
			'orders.tax_amount',
			'orders.base_tax_amount',
			'orders.tax_amount_invoiced',
			'orders.tax_amount_refunded',
			'orders.shipping_amount',
			'orders.base_shipping_amount',
			'orders.base_shipping_invoiced',
			'orders.shipping_refunded',
			'orders.base_shipping_refunded',
			'orders.customer_id',
			'orders.channel_id',
			'orders.cart_id',
		)
		->where('orders.customer_id', $id)
		->get();


		$data2 = DB::table('orders')
		->join('shipments', function($join){
			$join->on('orders.id', '=', 'shipments.order_id')
			->on('orders.customer_id', '=', 'shipments.customer_id');
		})
		->join('invoices', function($join){
			$join->on('orders.id', '=', 'invoices.order_id');
		})
		->select(
			'shipments.status',
			'shipments.total_qty',
			'shipments.total_weight',
			'shipments.carrier_code',
			'shipments.track_number',
			'shipments.email_sent',
			'shipments.customer_id',
			'shipments.order_id',
			'shipments.order_address_id',
			'shipments.inventory_source_id',
			'shipments.inventory_source_name',
		)
		->where('orders.customer_id', $id)
		->get();
		$data3 = DB::table('orders')
		->join('invoices', function($join){
			$join->on('orders.id', '=', 'invoices.order_id');
		})
		->select(
			'invoices.increment_id',
			'invoices.state',
			'invoices.email_sent',
			'invoices.total_qty',
			'invoices.base_currency_code',
			'invoices.channel_currency_code',
			'invoices.order_currency_code',
			'invoices.sub_total',
			'invoices.base_sub_total',
			'invoices.grand_total',
			'invoices.base_grand_total',
			'invoices.base_shipping_amount',
			'invoices.tax_amount',
			'invoices.base_tax_amount',
			'invoices.discount_amount',
			'invoices.base_discount_amount',
			'invoices.order_id',
			'invoices.order_address_id',
			'invoices.transaction_id',
		)
		->where('orders.customer_id', $id)
		->get();
		return response()->json([
			'orders [menunggu konfirmasi]' => $data,
			'invoices [sedang diproses]' => $data3,
			'shipments [sedang dikirim]' => $data2,
			'status_code'   => 200,
			'msg'           => 'success',
		], 200);

	}
    public function create(Request $request)
{
	$customer = DB::table('customers')
	->where('id', $request->customer_id)
	->first();
	$cart = DB::table('cart')
	->where('id', $request->cart_id)
	->first();
	$cart_item = DB::table('cart_items')
	->where('cart_id', $request->cart_id)
	->first();
	$cart_item_all = DB::table('cart_items')
	->where('cart_id', $request->cart_id)
	->get();
	$itung_cart_item = DB::table('cart_items')
	->where('cart_id', $request->cart_id)
	->count();
	

	$data = DB::table('orders')
	->insert([
		'status' => 'pending',
		'increment_id' => rand(),
		'is_guest' => 0,
		'channel_name' => 'Default',


		// base customer
		'customer_email' => $customer->email,
		'customer_id' => $request->customer_id,
		'customer_first_name' => $customer->first_name,
		'customer_last_name' => $customer->last_name,
		'customer_type' => 'Webkul\Customer\Models\Customer',
		'channel_id' => 1,
		'channel_type' => 'Webkul\Core\Models\Channel',

		// base shipping			
		'shipping_method' => $request->shipping_method,
		'shipping_title' => $request->shipping_title,
		'shipping_description' => $request->shipping_description,
		'is_gift' => 0,
		'shipping_amount' => $request->shipping_amount,
		'base_shipping_amount' => $request->shipping_amount,
		'shipping_invoiced' => $request->shipping_amount,
		'base_shipping_invoiced' => $request->shipping_amount,

		// base cart
			// base total barang
		'total_item_count' => $cart->items_count,
		'total_qty_ordered' => $cart->items_count,
			// base curency
		'channel_currency_code' => 'IDR',
		'base_currency_code' => 'IDR',
		'order_currency_code' => 'IDR',

			// base harga total
		'sub_total' => $cart->sub_total,
		'base_sub_total' => $cart->sub_total,
		'base_sub_total_invoiced' => $cart->sub_total,
		'sub_total_invoiced' => $cart->sub_total,
		'base_grand_total_invoiced' => $cart->grand_total + $request->shipping_amount,
		'base_grand_total' => $cart->grand_total + $request->shipping_amount,
		'grand_total' => $cart->grand_total + $request->shipping_amount,
			//base harga pengiriman
		'cart_id' => $request->cart_id,
		'created_at' => now(),
		'updated_at' => now(),

	]);

	$id = DB::getPdo()->lastInsertId();
		// BASE BUAT PERITEM
	
	foreach ($cart_item_all as $row) {
		DB::table('order_items')
		->insert([
			'order_id' => $id,
			'qty_ordered' => $cart->items_count,
			'sku' => $row->sku,
			'type' => $row->type,
			'name' => $row->name,
			'total_weight' => $row->total_weight,
			'weight' => $row->weight,
			'price' => $row->price,
			'base_price' => $row->price,
			'total' => $row->total,
			'base_total' => $row->total,
			'total_invoiced' => $row->total,
			'base_total_invoiced' => $row->total,
			'amount_refunded' => 0,
			'base_amount_refunded' => 0,
			'product_id' => $row->product_id,
			'product_type' => 'Webkul\Product\Models\Product',
			'created_at' => now(),
			'updated_at' => now(),
		]);
		$item_id = DB::getPdo()->lastInsertId();

		// BASE BUAT BRANDS
		DB::table('order_brands')
		->insert([
			'order_id' => $id,
			'order_item_id' => $item_id,
			'product_id' => $row->product_id,
			'created_at' => now(),
			'updated_at' => now(),
		]);
	}
	
	
		// BASE BUAT PEMBAYARAN
	DB::table('order_payment')
	->insert([
		'order_id' => $id,
		'method' => $request->method,
		'created_at' => now(),
		'updated_at' => now(),
	]);

		// BASE BUAT CREATE ALAMAT DIA
	DB::table('addresses')
	->insert([
		'address_type' => 'order_shipping',
		'customer_id' => $request->customer_id,
			// 'cart_id' => $request->cart_id,
		'order_id' => $id,
		'first_name' => $customer->first_name,
		'last_name' => $customer->last_name,

		'address1' => $request->address1,
		'postcode' => $request->postcode,
		'city' => $request->city,
		'state' => $request->state,
		'country' => 'indonesia',
		'email' => $customer->email,
		'phone' => $request->phone,
		'default_address' => 1,
		'created_at' => now(),
		'updated_at' => now(),
	]);
	DB::table('addresses')
	->insert([
		'address_type' => 'order_billing',
		'customer_id' => $request->customer_id,
			// 'cart_id' => $request->cart_id,
		'order_id' => $id,
		'first_name' => $customer->first_name,
		'last_name' => $customer->last_name,

		'address1' => $request->address1,
		'postcode' => $request->postcode,
		'city' => $request->city,
		'state' => $request->state,
		'country' => 'indonesia',
		'email' => $customer->email,
		'phone' => $request->phone,
		'default_address' => 1,
		'created_at' => now(),
		'updated_at' => now(),
	]);
	DB::table('cart')
	->where('id', $request->cart_id)
	->delete();
	return response()->json([
		'order' => $data,
		'status_code'   => 200,
		'msg'           => 'success',
	], 201);
}
	public function update(Request $request, $id)
	{
		$data = DB::table('products')
		->where('id', $id)
		->update($request->all());
		if (is_null($data)) {
			return response()->json('data tidak ada', 404);
		}else{
			return response()->json([
				'products' => $data,
				'status_code'   => 200,
				'msg'           => 'success',
			], 200);
		}
	}
	public function delete(Request $request)
	{
		$data = DB::table('orders')
		->join('order_brands', function($join){
			$join->on('orders.id', '=', 'order_brands.order_id');
		})
		->where('orders.customer_id', '=', $request->customer_id)
		->where('order_brands.product_id', '=', $request->product_id)
		->delete();
		return response()->json([
			'order' => 'Data Berhasil Dihapus',
			'data' => $data,
			'status_code'   => 200,
			'msg'           => 'success',
		], 200);

	}
}
