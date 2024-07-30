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
                        <li><a href="product.html">Product</a></li>
                        <li>Product Single</li>
                    </ol>
                </div>
            </div>
        </div> <!-- end row -->
    </div> <!-- end container -->
</section>
<!-- end page-title -->
<div class="container mb-5">
    <div class="row">
        <div class="col-lg-3">
            <div class="text-center card" style="width: 18rem;">
                @if(Auth::guard('customer')->user()->photo==null)
                <img width="70px" src="{{ Avatar::create('Joko Widodo')->toBase64() }}" class="mx-auto mt-3" alt="...">
                @else

                <img width="70px" height="70px" style="border-radius:50%;" src="{{ asset('uploads/profile/') }}/{{ Auth::guard('customer')->user()->photo }}" class="mx-auto mt-3" alt="...">



                @endif






                <div class="card-body">
                  <h5 class="card-title">{{ Auth::guard('customer')->user()->fname }}</h5>

                </div>
                <ul class="list-group list-group-flush">
                  <li class="list-group-item">Update Profile</li>
                  <li class="list-group-item"><a href="{{ route('myorder') }}">My Order</a></li>
                  <li class="list-group-item">Wishlist</li>
                  <li class="list-group-item"><a href="{{ route('customer.logout') }}">Logout</a></li>
                </ul>

              </div>
        </div>
        <div class="col-lg-9">
            <div class="card">
                <div class="card-header">Update Profile</div>
                <div class="card-body">
                    <form action="" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6">
                                <label for="firstname">First Name:</label>
                                <input type="text" name="fname" id="fname" class="form-control">
                            </div>
                            <div class="col-lg-6">
                                <label for="firstname">Last Name:</label>
                                <input type="text" name="laname" id="lname" class="form-control">
                            </div>
                            <div class="col-lg-6">
                                <label for="email">Email:</label>
                                <input type="email" name="email" id="email" class="form-control">
                            </div>
                            <div class="col-lg-6">
                                <label for="password">Password:</label>
                                <input type="password" name="password" id="password" class="form-control">
                            </div>
                            <div class="col-lg-6">
                                <label for="firstname">Phone:</label>
                                <input type="text" name="phone" id="fname" class="form-control">
                            </div>
                            <div class="col-lg-6">
                                <label for="country">Country:</label>
                                <input type="text" name="country" id="country" class="form-control">
                            </div>
                            <div class="col-lg-6">
                                <label for="address">Address:</label>
                                <input type="text" name="address" id="address" class="form-control">
                            </div>
                            <div class="col-lg-6">
                                <label for="firstname">Zip:</label>
                                <input type="text" name="zip" id="fname" class="form-control">
                            </div>
                            <div class="col-lg-6">
                                <label for="firstname">Photo:</label>
                                <input type="file" name="photo" id="photo" class="form-control">
                            </div>
                            <div class="mx-auto mt-5 col-lg-12">
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
