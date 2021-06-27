<?php

namespace Webkul\API\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Webkul\API\Http\Repository\ShipmentRepository;

class Pengiriman extends Controller
{
    private $shipmentRepository;

    public function __construct
    (
        ShipmentRepository $shipmentRepository
    )
    {
        $this->shipmentRepository = $shipmentRepository;

    }
    public function province()
    {
        $response = $this->shipmentRepository->province();
        return response()->json($response);
    }

    public function city()
    {
        $response = $this->shipmentRepository->city();
        return response()->json($response);
    }
    public function subdistrict(Request $request)
    {
        $response = $this->shipmentRepository->subdistrict($request);
        return response()->json($response);
    }

    public function cost(Request $request)
    {
        $response = $this->shipmentRepository->cost($request);
        return response()->json($response);
    }

    public function internationalCost(Request $request)
    {
        $response = $this->shipmentRepository->internationalCost($request);
        return response()->json($response);
    }
    public function waybill(Request $request)
    {
        $response = $this->shipmentRepository->waybill($request);
        return response()->json($response);
    }

}
