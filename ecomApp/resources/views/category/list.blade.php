@extends('layouts.admin')
@section('content')
<div class="col-lg-12">
    <div class="card">
        <div class="card-header"><h4>product list</h4></div>
        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <th>status</th>
                    {{--  <th>Category</th>
                    <th>Subcategory</th>  --}}
                    <th>Brand</th>
                    <th>P_Name</th>
                    <th>Price</th>
                    <th>Discount</th>
                    <th>After Discount</th>
                    <th>preview</th>
                    <th>Action</th>
                </tr>
                @foreach ($products as $product)
                <tr>

                    {{--  <td>{{ $product->rel_to_category->category_name }}</td>
                    <td>{{ $product->rel_to_subcategory->subcategory_name }}</td>  --}}
                    <td>
                        <input data-id='{{ $product->id }}' {{ $product->status==1?'checked':'' }} class="check" type="checkbox" checked data-toggle="toggle" value='{{ $product->status }}' >
                    </td>
                    <td>{{ $product->rel_to_brand->brand_name }}</td>
                    <td>{{ $product->product_name }}</td>
                    <td>{{ $product->price }}</td>
                    <td>{{ $product->discount }}</td>
                    <td>{{ $product->after_discount }}</td>
                    <td>
                        <img width="30px" src="{{ asset('upload/preview/') }}/{{ $product->preview }}" alt="">
                    </td>
                    <td>
                        <div class="d-flex">
                            <a  href="{{ route('inventory',$product->id) }}" class="mr-1 shadow btn btn-primary btn-xs sharp"><i title="inventory" class="fa fa-archive"></i></a>
                            <a href="" class="mr-1 shadow btn btn-success btn-xs sharp"><i class="fa fa-eye"></i></a>
                            <a href="" class="shadow btn btn-danger btn-xs sharp"><i class="fa fa-trash"></i></a>
                        </div>
                    </td>
                </tr>

                @endforeach
            </table>
        </div>
    </div>
</div>

@endsection
@push('backend_css')
<link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">


@endpush
@push('backend_js')
<script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>

@endpush
@push('backend_js')
<script>
    $('.check').click(function(){
       if($(this).val()==1){
        $(this).attr('value',0)
       }
       else{
        $(this).attr('value',1)
       }
       var status=$(this).val();
       var product_id=$(this).attr('data-id');
       $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        type:'POST',
        url:'/changeStatus',
        data:{'product_id':product_id,'status':status},
        success:function (data){
            alert(data)
        }

    })

    })
</script>

@endpush
