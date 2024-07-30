@extends('layouts.admin')
@section('content')
<div class="col-lg-8">
    <div class="card">
        <div class="card-header">Coupon List</div>
        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <th>Sl</th>
                    <th>Coupon Name</th>
                    <th>Type</th>
                    <th>Amount</th>
                    <th>Limit</th>
                    <th>Validity</th>
                    <th>Status</th>
                  <th>Action</th> 
                </tr>
                @foreach ($coupons as $sl=>$coupon)
                <tr>
                    <td>{{ $sl+1 }}</td>
                    <td>{{ $coupon->coupon_name }}</td>
                    <td>{{ $coupon->type==1?'Persentage':'Solid ' }}</td>
                    <td>{{ $coupon->amount }}</td>
                    <td>{{ $coupon->limit }}</td>
                    <td>
                        @if(Carbon\Carbon::now() > $coupon->validity)
                        <span class="badge badge-warning">Expired</span>
                        @else
                       <span class="badge badge-success"> {{ Carbon\Carbon::now()->diffInDays($coupon->validity, false) }} Days Left</span>
                        @endif
                    </td>
                    <td>
                        <input data-id='{{ $coupon->id }}' {{ $coupon->status==1?'checked':'' }} class="check" type="checkbox" checked data-toggle="toggle" value='{{ $coupon->status }}' name='status' >
                    </td>
                 <td>
                        <a href='' class="btn btn-danger">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
                                <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
                              </svg>
                        </a>
                    </td>


                </tr>

                @endforeach

            </table>
        </div>
    </div>
</div>

<div class="col-lg-4">
    <form action="{{ route('coupon.store') }}" method="post">
        @csrf
        <div class="mb-3">
            <label for="coupon" class="form-label">Coupon Name:</label>
            <input type="text" name="coupon_name" id="cla" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label" for="Coupon_type">Coupon Type:</label>
            <select name="type" id="type" class="form-control">
                <option value="">Select Coupon Type</option>
                <option value="1">Persentage</option>
                <option value="2">Solid Amount</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="coupon" class="form-label">Coupon Amount:</label>
            <input type="number" name="amount" id="cla" class="form-control">
        </div>
        <div class="mb-3">
            <label for="coupon" class="form-label">Coupon Limit:</label>
            <input type="number" name="limit" id="cla" class="form-control">
        </div>
        <div class="mb-3">
            <label for="coupon" class="form-label">Coupon Validity:</label>
            <input type="date" name="validity" id="cla" class="form-control">
        </div>
        <div class="mb-3">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>
</div>

@endsection
