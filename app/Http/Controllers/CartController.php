<?php

namespace App\Http\Controllers;


use App\Models\Cart;
use App\Models\CartProduct;
use App\Models\Customer;
use App\Models\VatPercentage;
use App\Models\VatValue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
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
    public function addProduct(Customer $customer,Request $request){
        Log::info(json_encode($customer->carts()));
        $cart = Cart::where('customer_id','=',$customer->id)->orderBy('created_at','DESC')->first();
        if ($cart){
            $cartProduct = new CartProduct();
            $cartProduct->product_id = $request->product_id;
            $cartProduct->cart_id = $cart->id;
            $cartProduct->save();
        }else{
            $cart = new Cart();
            $cart->customer_id = $customer->id;
            $cart->save();
            $cartProduct = new CartProduct();
            $cartProduct->product_id = $request->product_id;
            $cartProduct->cart_id =$cart->id;
            $cartProduct->save();

        }
    }

    public function createInvoice(Cart $cart,Request $request){
    $cartProducts = DB::table('cart_products')->where('cart_id','=',$cart->id)->get();
    $totalPrice = 0;
    foreach ($cartProducts as $cartProduct){
        $store = DB::table('stores')->where('id','=',$cartProduct->store_id)->get();
        $product = DB::table('products')->where('id','=',$cartProduct->product_id)->get();
        if($store->vat_included){
            $totalPrice += $product->price;
            $totalPrice += $store->shipping_cost;
        }else{
        $vatpercentage = VatPercentage::where('store_id','=',$store->id)->get();
        if($vatpercentage){
            $totalPrice += ( ($product->price)* ( 1 + ($vatpercentage->percentage/100 ) ) );
            $totalPrice += $store->shipping_cost;
        }else{
            $vatValue = VatValue::where('store_id','=',$store->id)->get();
            $totalPrice += $product->price + $vatValue->value;
        }
        }
    }
    return $totalPrice;
    }

}
