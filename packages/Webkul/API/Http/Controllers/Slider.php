<?php

namespace Webkul\API\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class Slider extends Controller
{
	public function index()
	{
		$data = DB::table('sliders')->get();
		return response()->json([
			'sliders' => $data,
			'status_code'   => 200,
			'msg'           => 'success',
		], 200);

	}
	public function icon()
	{
		$data = DB::table('channels')->get();
		return response()->json([
			'channels' => $data,
			'status_code'   => 200,
			'msg'           => 'success',
		], 200);

	}
}
