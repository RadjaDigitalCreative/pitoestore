<?php
/**
 * Copyright (c) 2021.
 * Dinokhan
 * PHP Storm
 * Last Modified: 6/12/21, 3:35 AM
 */
namespace Webkul\API\Http\Repository;
use Illuminate\Support\Facades\DB;
use Webkul\API\Http\Traits\BaseCRUL;

class ShipmentRepository
{
    private $baseCRUL;
    public function __construct(BaseCRUL $baseCRUL)
    {
        $this->baseCRUL = $baseCRUL;
    }

    public function province(){
        $CURLOPT_URL = 'https://pro.rajaongkir.com/api/province';
        $CURLOPT_CUSTOMREQUEST ='GET';

        $response = $this->baseCRUL->API_GET($CURLOPT_URL, $CURLOPT_CUSTOMREQUEST);

        return json_decode($response);
    }
    public function city(){

        $CURLOPT_URL = 'https://pro.rajaongkir.com/api/city';
        $CURLOPT_CUSTOMREQUEST ='GET';

        $response = $this->baseCRUL->API_GET($CURLOPT_URL, $CURLOPT_CUSTOMREQUEST);

        return json_decode($response);
    }
    public function cost($request){

        $CURLOPT_URL = 'https://pro.rajaongkir.com/api/cost';
        $CURLOPT_CUSTOMREQUEST ='POST';
        $CURLPOST_DATA = [
            'origin' => $request->origin,
            'originType' => $request->originType,
            'destination' => $request->destination,
            'destinationType' => $request->destinationType,
            'weight' => $request->weight,
            'courier' => $request->courier,
        ];

        $response = $this->baseCRUL->API_POST($CURLOPT_URL, $CURLOPT_CUSTOMREQUEST, $CURLPOST_DATA);

        return json_decode($response);
    }
    public function internationalCost($request){

        $CURLOPT_URL = 'https://pro.rajaongkir.com/api/v2/internationalCost';
        $CURLOPT_CUSTOMREQUEST ='POST';
        $CURLPOST_DATA = [
            'origin' => $request->origin,
            'destination' => $request->destination,
            'weight' => $request->weight,
            'courier' => $request->courier,
        ];

        $response = $this->baseCRUL->API_POST($CURLOPT_URL, $CURLOPT_CUSTOMREQUEST, $CURLPOST_DATA);

        return json_decode($response);
    }

    public function subdistrict($request)
    {
        $CURLOPT_URL = 'https://pro.rajaongkir.com/api/subdistrict?city='.$request->city.'';
        $CURLOPT_CUSTOMREQUEST ='GET';
        $response = $this->baseCRUL->API_GET($CURLOPT_URL, $CURLOPT_CUSTOMREQUEST);

        return json_decode($response);
    }

    public function waybill($request)
    {
        $CURLOPT_URL = 'https://pro.rajaongkir.com/api/waybill';
        $CURLOPT_CUSTOMREQUEST ='POST';
        $CURLPOST_DATA = [
            'waybill' => $request->waybill,
            'courier' => $request->courier,
        ];

        $response = $this->baseCRUL->API_POST($CURLOPT_URL, $CURLOPT_CUSTOMREQUEST, $CURLPOST_DATA);

        return json_decode($response);
    }
}

