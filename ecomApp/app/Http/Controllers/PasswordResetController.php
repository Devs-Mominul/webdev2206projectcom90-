<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\PasswordReset;
use App\Notifications\InvoicePaid;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class PasswordResetController extends Controller
{
    public  function password_reset(){
        return view('customerAuth.passwordreset');
    }
    public function password_reset_request(Request $request){
        if(Customer::where('email', $request->email)->exists()){
            $customer=Customer::where('email', $request->email)->first();
            PasswordReset::where('customer_id', $customer->id)->delete();
           $reset_info= PasswordReset::create([
                'customer_id'=>$customer->id,
                'token'=>uniqid(),
                'created_at'=>Carbon::now()


            ]);


         Notification::send($customer,new InvoicePaid($reset_info));


        }
        else{
            echo 'email not found';
        }
    }
    public  function password_reset_form($data){
        return view('customerAuth.reset_form',[
            'data'=>$data
        ]);
    }
    public function password_reset_form_store(Request $request, $data){
        $customer_id= PasswordReset::where('token', $data)->first()->customer_id;
        Customer::find($customer_id)->update([
            'password'=>bcrypt($request->password),
            'updated_at'=>Carbon::now(),

        ]);



    }
}
