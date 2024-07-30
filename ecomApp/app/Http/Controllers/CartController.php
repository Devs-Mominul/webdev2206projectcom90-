<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\City;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Coupon;
use Illuminate\Support\Carbon;
use App\Models\Order;
use App\Models\Billing;
use App\Models\Shipping;
use App\Models\Inventory;
use App\Models\OrderProduct;
use App\Mail\invoiceMail;
use Illuminate\Support\Facades\Mail;
use PDF;


class CartController extends Controller
{
    function cart(Request $request){
        $coupon=$request->coupon_name;
        $msg='';
        $type='';
        $discount=0;
        if(isset($coupon)){
            if(Coupon::where('coupon_name',$coupon)->exists()){
                if(Carbon::now()->format('Y-m-d') <= Coupon::where('coupon_name', $coupon)->first()->validity){
                    if(Coupon::where('coupon_name',$coupon)->first()->limit !=0){
                        $type=Coupon::where('coupon_name',$coupon)->first()->type;
                        $discount=Coupon::where('coupon_name',$coupon)->first()->amount;

                    }
                    else{
                        $msg='coupon code limit exists';

                    }


                }
                else{
                    $msg='coupon code expired!';
                    $discount=0;


                }


            }
            else{
                $msg='Invalid Coupon Code!';
                $discount=0;

            }
        }





        $carts=Cart::where('customer_id', Auth::guard('customer')->id())->get();
        return view('frontend.cart',[
            'carts'=>$carts,
            // 'card'=>$card,
            // 'products'=>$products,
            'msg'=>$msg,
            'discount'=>$discount,
            'type'=>$type,
        ]);
    }
    function cart_update(Request $request){
        foreach($request->quantity as $cart_id=>$quantity){
            Cart::find($cart_id)->update([
                'quantity'=>$quantity,
            ]);
        }
        return back();


    }
    function coupon(){


        $coupons =Coupon::all();
        return view('frontend.coupon',[
            'coupons'=>$coupons
        ]);
    }
    function coupon_store(Request $request){
        Coupon::insert([
            'coupon_name'=>$request->coupon_name,
            'type'=>$request->type,
            'amount'=>$request->amount,
            'limit'=>$request->limit,
            'validity'=>$request->validity,
            'created_at'=>Carbon::now(),

        ]);
        return back();
    }
    function checkout(){
        $carts=Cart::where('customer_id', Auth::guard('customer')->id())->get();
        $cities= City::all();
        $countries=Country::all();
        return view('frontend.checkout',[
            'carts'=>$carts,
            'cities'=>$cities,
            'countries'=>$countries
        ]);
    }
    function getCity(Request $request){
        $cities=City::where('country_id',$request->country_id)->get();
        $str='<option >City*</option>';

        foreach($cities as $city){
            $str.='<option value="'.$city->id.'">'.$city->name.'</option>';

        }
        echo $str;

    }
    function order_store(Request $request){
        if($request->payment==1){
            $order_id='#'.uniqid().'-'.Carbon::now()->format('Y-m-d');
            Order::insert([
                'order_id'=>$order_id,
                'customer_id'=>Auth::guard('customer')->id(),
                'discount'=>$request->discount,
                'charge'=>$request->charge,
                'payment_method'=>$request->payment,
                'sub_total'=>$request->sub_total,
                'total'=>$request->total+$request->charge,
                'created_at'=>Carbon::now(),






            ]);
            Billing::insert([
                'order_id'=>$order_id,
                'customer_id'=>Auth::guard('customer')->id(),
                'fname'=>$request->fname,
                'lname'=>$request->lname,
                'country_id'=>$request->country,
                'city_id'=>$request->city,
                'zip'=>$request->zip,
                'company'=>$request->company,
                'email'=>$request->email,
                'phone'=>$request->phone,
                'address'=>$request->address,
                'message'=>$request->message,
                'created_at'=>Carbon::now(),



            ]);
            if($request->ship_check==1){
                Shipping::insert([
                    'order_id'=>$order_id,
                    'customer_id'=>Auth::guard('customer')->id(),
                    'ship_fname'=>$request->ship_fname,
                    'ship_lname'=>$request->ship_lname,
                    'ship_country_id'=>$request->ship_country,
                    'ship_city_id'=>$request->ship_city,
                    'ship_zip'=>$request->ship_zip,
                    'ship_company'=>$request->ship_company,
                    'ship_email'=>$request->ship_email,
                    'ship_phone'=>$request->ship_phone,
                    'ship_address'=>$request->ship_adress,
                    'ship_message'=>$request->ship_message,
                    'created_at'=>Carbon::now(),



                ]);
            }
            $carts=Cart::where('customer_id',Auth::guard('customer')->id())->get();
            foreach($carts as $cart){
                if($cart->rel_to_product){
                OrderProduct::insert([
                    'order_id'=>$order_id,
                    'customer_id'=>Auth::guard('customer')->id(),
                    'product_id'=>$cart->product_id,
                    'price'=>$cart->rel_to_product->after_discount,
                    'color_id'=>$cart->color_id,
                    'size_id'=>$cart->size_id,
                    'quantity'=>$cart->quantity,
                    'created_at'=>Carbon::now(),


                ]);
            }
                Inventory::where('product_id',$cart->product_id)->where('color_id',$cart->color_id)->where('size_id',$cart->size_id)->decrement('quantity',$cart->quantity);
                Cart::find($cart->id)->delete();

            }
            // Mail::to($request->email)->send(new InvoiceMail($order_id));
            return back();


        }
        elseif($request->payment==2){
           return redirect()->route('pay');
        }
        elseif($request->payment==3){
            $data=$request->all();
            return redirect()->route('stripe')->with('data',$data);
        }

    }
    function myorder(){

        $myorders=Order::where('customer_id',Auth::guard('customer')->id())->paginate(1);
        return view('frontend.order',[
            'myorders'=>$myorders
        ]);
    }
    function myorder_pdf($id){
        $data=Order::find($id);
        $pdf = PDF::loadView('frontend.invoice.pdf', [
            'data'=>$data,
        ]);

        return $pdf->download('asha.pdf');


    }
    function border(){
        $orders=Order::all();
        return view('frontend.border',[
            'orders'=>$orders,
        ]);
    }
    function order_status(Request $request){
       Order::where('order_id', $request->order_id)->update([
        'status'=>$request->status,

       ]);
       return back();

    }
    function review_store(Request $request){
        OrderProduct::where('customer_id', Auth::guard('customer')->id())->where('product_id', $request->product_id)->first()->update([
            'review'=>$request->reviewmessage,
            'star'=>$request->stars,

        ]);

    }
}
