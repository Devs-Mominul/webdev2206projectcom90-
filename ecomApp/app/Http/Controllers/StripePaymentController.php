<?php

namespace App\Http\Controllers;

use App\Models\StripeOrder;
use Illuminate\Http\Request;
use Session;
use Stripe;

class StripePaymentController extends Controller
{
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function stripe()
    {
        $data=session('data');


       $stripe_id=StripeOrder::insertGetId([
        'fname' => $data['fname'],
        'email' => $data['email'],
        'phone' => $data['phone'],
        'total' =>$data['total'] +  $data['charge'],
        'address' => $data['address'],
        'lname'=>$data['lname'],
        'customer_id'=>$data['customer_id'],
        'country'=>$data['country'],
        'zip'=>$data['zip'],
        'company'=>$data['company'],
        'message'=>$data['message'],
        'city'=>$data['city'],
        'ship_fname'=>$data['ship_fname'],
        'ship_lname'=>$data['ship_lname'],
        'ship_country'=>$data['ship_country'],
        'ship_city'=>$data['ship_city'],
        'ship_zip'=>$data['ship_zip'],
        'ship_company'=>$data['ship_company'],
        'ship_email'=>$data['ship_email'],
        'ship_phone'=>$data['ship_phone'],
        'ship_address'=>$data['ship_adress'],
        'charge'=>$data['charge'],
        'discount'=>$data['discount'],
        'sub_total'=>$data['sub_total']
       ]);
        return view('stripe',[
            'id'=>$stripe_id,
        ]);
    }

    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function stripePost(Request $request)
    {
        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        $stripe_id=$request->stripe_id;
        $data=StripeOrder::find($stripe_id);
        $total=$data->first()->total;

        Stripe\Charge::create ([
                "amount" => 100 * $total,
                "currency" => "usd",
                "source" => $request->stripeToken,
                "description" => "Test payment from itsolutionstuff.com."
        ]);



       echo 'success';
    }
}
