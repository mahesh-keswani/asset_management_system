@extends('pages.index')

@section('content')

<a href="{{ url('dynamicPdfCustomer/pdf') }}" class="btn btn-success pull-right">convert To PDF</a>
    <table class="table table-striped">
        <th>Customer Id</th>
        <th>Product name</th>
        <th>Seller ID</th>
        <th>Cost</th>

        @foreach($cus as $c)
            <tr>
                <th> {{ $c->id }} </th>
                <th>{{ $c->product_name }}</th>
                <th>{{ $c->seller_id }}</th>
                <th>{{ $c->cost }}</th>
            </tr>
        @endforeach
    </table>
@endsection