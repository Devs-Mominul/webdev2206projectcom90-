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
                    <table class="table table-bordered">
                        <tr>
                            <th>Sl</th>
                            <th>Order Id</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        @foreach ($myorders as $order)
                        <tr>
                            <td>{{ $order->id }}</td>
                            <td>{{ $order->order_id }}</td>
                            <td>{{ $order->total }}</td>
                            <td>
                                @if($order->status==0)
                                <span class="badge bg-secondary">placed</span>
                                @elseif($order->status==1)
                                <span class="badge bg-info">processing</span>
                                @elseif($order->status==2)
                                <span class="badge bg-primary">shipped</span>
                                @elseif($order->status==3)
                                <span class="badge bg-warning">Ready To Delibery</span>
                                @elseif($order->status==4)
                                <span class="badge bg-success">Reccevied</span>
                                @elseif($order->status==5)
                                <span class="badge bg-danger">Cancel</span>
                                @endif

                            </td>
                            <td>
                                <a href="" class="btn btn-danger">Cancel Order</a>
                                <a href="{{ route('myorder.pdf', $order->id) }}" class="btn btn-success">Download</a>
                            </td>
                        </tr>

                        @endforeach

                    </table>
                    {{ $myorders->links() }}

                </div>
            </div>
        </div>
    </div>
</div>

@endsection
