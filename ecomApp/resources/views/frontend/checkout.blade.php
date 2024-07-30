@extends('frontend.master')
@section('content')
 <!-- start wpo-page-title -->
 <section class="wpo-page-title">
    <h2 class="d-none">Hide</h2>
    <div class="container">
        <div class="row">
            <div class="col col-xs-12">
                <div class="wpo-breadcumb-wrap">
                    <ol class="wpo-breadcumb-wrap">
                        <li><a href="index.html">Home</a></li>
                        <li><a href="cart.html">Cart</a></li>
                        <li>Checkout</li>
                    </ol>
                </div>
            </div>
        </div> <!-- end row -->
    </div> <!-- end container -->
</section>
<!-- end page-title -->

<!-- wpo-checkout-area start-->
<div class="wpo-checkout-area section-padding">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="single-page-title">
                    <h2>Your Checkout</h2>
                    <p>There are 4 products in this list</p>
                </div>
            </div>
        </div>
        <form action="{{ route('order.store') }}" method="POST">
            @csrf
            <div class="checkout-wrap">
                <div class="row">
                    <div class="col-lg-8 col-12">
                        <div class="caupon-wrap s3">
                            <div class="biling-item">
                                <div class="coupon coupon-3">
                                    <h2>Billing Address</h2>
                                </div>
                                <div class="billing-adress">
                                    <div class="contact-form form-style">
                                        <div class="row">
                                            <div class="col-lg-6 col-md-12 col-12">
                                                <input type="text" id="fname"
                                                    name="fname" value="{{ Auth::guard('customer')->user()->fname }}" >
                                            </div>
                                            <div class="col-lg-6 col-md-12 col-12 ">
                                                <input type="text"  id="lname"
                                                    name="lname" value="{{ Auth::guard('customer')->user()->lname }}" >
                                            </div>

                                            <div class="col-lg-6 col-md-12 col-12">

                                                <select name="country" id="country" class=" countries" >
                                                    <option >Country*</option>

                                                 @foreach ($countries as $country)
                                                 <option value="{{ $country->id }}">{{ $country->name }}</option>


                                                 @endforeach



                                                </select>
                                            </div>
                                            <div class="col-lg-6 col-md-12 col-12">
                                                <select name="city" id="city" class="form-control city">
                                                    <option >City</option>



                                                </select>
                                            </div>
                                            <div class="col-lg-6 col-md-12 col-12">
                                                <input type="number" value="{{ Auth::guard('customer')->user()->zip }}"
                                                    name="zip">
                                            </div>
                                            <div class="col-lg-6 col-md-12 col-12">
                                                <input type="text" placeholder="Company Name*" id="company"
                                                    name="company">
                                            </div>
                                            <div class="col-lg-6 col-md-12 col-12">
                                                <input type="email" placeholder="Email Address*" value="{{ Auth::guard('customer')->user()->email }}"
                                                    name="email">
                                            </div>
                                            <div class="col-lg-6 col-md-12 col-12">
                                                <input type="text" placeholder="Phone*" value="{{ Auth::guard('customer')->user()->phone }}"
                                                    name="phone">
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-12">
                                                <input type="text" placeholder="Address*" id="Adress"
                                                    name="address" value="{{ Auth::guard('customer')->user()->address }}" >
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-12">
                                                <div class="note-area">
                                                    <textarea name="message" type='text'
                                                        placeholder="Additional Information"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="biling-item-3">
                                    <input id="toggle4" type="checkbox" name='ship_check' value='1' >
                                    <label class="fontsize" for="toggle4">Ship to a Different Address?</label>
                                    <div class="billing-adress" id="open4">
                                        <div class="contact-form form-style">
                                            <div class="row">
                                                <div class="col-lg-6 col-md-12 col-12">
                                                    <input type="text" placeholder="First Name*" id="fname6"
                                                        name="ship_fname">
                                                </div>
                                                <div class="col-lg-6 col-md-12 col-12">
                                                    <input type="text" placeholder="Last Name*" id="fname7"
                                                        name="ship_lname">
                                                </div>
                                                <div class="col-lg-6 col-md-12 col-12">

                                                <select name="ship_country" id="country country2" class=" countries form-control" value=''>
                                                    <option >Country*</option>
                                                    @foreach ($countries as $country)
                                                    <option value="{{ $country->id }}">{{ $country->name }}</option>


                                                    @endforeach



                                                </select>
                                                </div>
                                                <div class="col-lg-6 col-md-12 col-12">
                                                    <select name="ship_city" id="city city2" class="form-control city">
                                                        <option >Select City</option>



                                                    </select>
                                                </div>
                                                <div class="col-lg-6 col-md-12 col-12">
                                                    <input type="number" placeholder="Postcode / ZIP*" id="Post1"
                                                        name="ship_zip">
                                                </div>
                                                <div class="col-lg-6 col-md-12 col-12">
                                                    <input type="text" placeholder="Company Name*" id="Company1"
                                                        name="ship_company">
                                                </div>
                                                <div class="col-lg-6 col-md-12 col-12">
                                                    <input type="email" placeholder="Email Address*" id="email5"
                                                        name="ship_email">
                                                </div>
                                                <div class="col-lg-6 col-md-12 col-12">
                                                    <input type="text" placeholder="Phone*" id="phone1"
                                                        name="ship_phone">
                                                </div>
                                                <div class="col-lg-12 col-md-12 col-12">
                                                    <input type="text" placeholder="Address*" id="Adress1"
                                                        name="ship_adress">
                                                </div>
                                                <div class="col-lg-12 col-md-12 col-12">
                                                    <div class="note-area">
                                                        <textarea name="ship_message" type='text'
                                                            placeholder="Additional Information"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-12">
                        <div class="cout-order-area">
                            <h3>Your Order</h3>
                            <div class="oreder-item">
                                <div class="title">
                                    <h2>Products <span>Subtotal</span></h2>
                                </div>
                                @php
                                    $sub_total=0
                                @endphp
                                @foreach ($carts as $cart)
                                @if($cart->rel_to_product)

                               <div class="oreder-product">
                                <div class="images">
                                    <span>
                                        <img  src="{{ asset('uploads/preview/') }}/{{ $cart->rel_to_product->preview }}" alt="">
                                    </span>
                                </div>

                                <div class="product">
                                    <ul>
                                        <li class="first-cart"></li>
                                        <li>
                                            <div class="rating-product">
                                                <i class="fi flaticon-star"></i>
                                                <i class="fi flaticon-star"></i>
                                                <i class="fi flaticon-star"></i>
                                                <i class="fi flaticon-star"></i>
                                                <i class="fi flaticon-star"></i>
                                                <span>15</span>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                                <span>${{ $cart->rel_to_product->after_discount }}</span>
                                </div>
                                @php
                                $sub_total +=  $cart->rel_to_product->after_discount*$cart->quantity

                                @endphp
                                @endif
                                @endforeach




                                <!-- Shipping -->
                                <div class="mt-3 mb-3">
                                    <h2>Discount:<span></span></h2>
                                    <div class="border-0 title">
                                        <h2>Delivery Charge</h2>
                                    </div>
                                    <ul>
                                        <li class="free">
                                            <input id="Free" class="charge"  data-total='{{ session('total') }}'  type="radio" name="charge" value="70" checked>
                                            <label for="Free">Inside City: <span>$10.00</span></label>
                                        </li>
                                        <li class="free">
                                            <input id="Local" data-total='{{ session('total') }}' class="charge" type="radio" name="charge" value="100">
                                            <label for="Local">Outside City: <span>$20.00</span></label>
                                        </li>
                                    </ul>
                                </div>
                                <div class="title s2">
                                    <h2>Totals<span id="grand">{{ session('total') }}</span></h2>
                                </div>
                               </div>



                        </div>
                        <input type="hidden" name="discount" value="{{ session('discount') }}" >
                        <input type="hidden" name="sub_total" value="{{ session('sub') }}" >
                        <input type="hidden" name="total" value="{{ session('sub') }}" >
                        <input type="hidden" name="customer_id" value="{{ Auth::guard('customer')->id() }}" >

                        <div class="caupon-wrap s5">
                            <div class="payment-area">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="payment-option" id="open5">
                                            <h3>Payment</h3>
                                            <div class="payment-select">
                                                <ul>
                                                    <li class="">
                                                        <input id="remove" type="radio" name="payment"
                                                            value="1">
                                                        <label for="remove">Cash on Delivery</label>
                                                    </li>
                                                    <li class="">
                                                        <input id="add" type="radio" name="payment" checked="checked" value="2">
                                                        <label for="add">Pay With SSLCOMMERZ</label>
                                                    </li>
                                                    <li class="">
                                                        <input id="getway" type="radio" name="payment"
                                                            value="3">
                                                        <label for="getway">Pay With STRIPE</label>
                                                    </li>
                                                </ul>
                                            </div>

                                            <div id="open6" class="payment-name active">
                                                <div class="contact-form form-style">
                                                    <div class="row">
                                                        <div class="col-lg-12 col-md-12 col-12">
                                                            <div class="text-center submit-btn-area">
                                                                <button class="theme-btn" type="submit">Place
                                                                    Order</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>



    </div>
</div>
<!-- wpo-checkout-area end-->

@endsection
@push('frontend_js')
<script>
    $('.charge').click(function(){
        var charge=$(this).val();
        var data_total=$(this).attr('data-total');
        var grand_total=parseInt(data_total ) + parseInt(charge)


        $('#grand').html(grand_total)

    })
</script>
<script>
    $('.countries').change(function(){
       var country_id=$(this).val();
       $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        url:'/getCity',
        type:'POST',
        data:{'country_id':country_id},
        success:function(data){
           $('.city').html(data)
        }
    })



    })
</script>


@endpush
