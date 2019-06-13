@extends('pages.index')

@section('content')
<a href="{{ url('dynamicPdfCustomer/pdf') }}" class="btn btn-success pull-right">convert To PDF</a>
    
    <h3><center>Customers</center></h3>
    <table class="table table-striped">
        <tr>
            <th>Id</th>
            <th>Product Name</th>
            <th>Seller Id</th>
            <th>Cost</th>
            <th>Vendor</th>
        </tr>
        @foreach($customer as $asset)
            <tr>
                <th>{{ $asset->id }}</th>
                <th>{{ $asset->product_name }}</th>
                <th>{{ $asset->seller_id }}</th>
                <th>{{ $asset->cost }}</th>
                <th>{{ $asset->vendor }}</th>
            </tr>
        @endforeach
    </table>

@endsection