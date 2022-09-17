<?php

namespace App\Http\Controllers;

use App\Models\Merchant;
use App\Models\Store;
use App\Models\VatPercentage;
use App\Models\VatValue;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
//        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function create(Merchant $merchant,Request $request)
    {
        $store = new Store();
        $store->merchant_id = $merchant->id;
            $store->vat_included = $request->vat_included;
        $store->shipping_cost = $request->shipping_cost;
        $store->save();
        if (!$request->vat_included){
            if($request->vat_type == "percentage"){
                $vat_percentage = new VatPercentage();
                $vat_percentage->store_id = $store->id;
                $vat_percentage->percentage = $request->vat_percentage;
                $vat_percentage->save();
            }elseif($request->vat_type = "value"){
                $vat_value = new VatValue();
                $vat_value->store_id = $store->id;
                $vat_value->value = $request->vat_value;
                $vat_value->save();
            }
        }
    }
}
