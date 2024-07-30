@extends('layouts.admin')
@section('content')
<div class="col-lg-12">
    <div class="card">
        <div class="card-header">Order List</div>
        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <th>Order Id</th>
                    <th>Customer</th>
                    <th>Total</th>
                    <th>Discount</th>
                    <th>Charge</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                @foreach ($orders as $order)
                <tr>
                    <td>{{ $order->order_id }}</td>
                    <td>{{ $order->rel_to_customer->fname }}</td>
                    <td>{{ $order->total }}</td>
                    <td>{{ $order->discount }}</td>
                    <td>{{ $order->charge }}</td>
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
                        <form action="{{ route('order.status') }}" method="post">
                            @csrf
                            <input type="hidden" name="order_id" value="{{ $order->order_id }}">

                            <!-- Example single danger button -->
                            <div class="btn-group">
                              <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                select status
                              </button>
                              <div class="dropdown-menu">
                               <button name="status" class="dropdown-item"   value='0'>placed</button>

                               <button name="status" class="dropdown-item"   value='1'>processing</button>
                               <button name="status" class="dropdown-item"   value='2'>shipped</button>

                               <button name="status" class="dropdown-item"  value='3'>out of devivery</button>
                               <button name="status" class="dropdown-item"  value='4'>deliberied</button>

                               <button name="status" class="dropdown-item"   value='5'>cancel</button>



                              </div>
                            </div>

                        </form>

                    </td>

                </tr>

                @endforeach
            </table>
        </div>
    </div>
</div>


@endsection
@push('backend_js')
<script>
    $('#active_id').change(function(){
        var active_id=$(this).val();
        // $.ajaxSetup({
        //     headers: {
        //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //     }
        // });
        // $.ajax({
        //     type:'POST',
        //     url:'getsubcategory',
        //     data:{'category_id':category_id},
        //     success:function (data){
        //         $('#subcategory').html(data)
        //     }

        // })
        alert(active_id)



    })

</script>


@endpush
