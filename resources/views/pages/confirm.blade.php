@extends('pages.index')

@section('content')
 

  
    <div class="container">
        <table class="table table-bordered">
            <tr>
                <th>Id</th>
                <th>Asset Id</th>
                <th>Stock Id</th>
                <th>Inventory Id</th>
                <th>From Date</th>
                <th>To Date</th>
                <th>Reservation For</th>
                <th>Location</th>
                <th>Quantity</th>
                <th>Status</th>
            </tr>
            @foreach($reservations as $r)
                <tr>
                    <th>{{ $r->id }}</th>
                    <th>{{ $r->item_id }}</th>
                    <th>{{ $r->stock_id }}</th>
                    <th>{{ $r->inventory_id }}</th>
                    <th>{{ $r->from_date }}</th>
                    <th>{{ $r->to_date }}</th>
                    <th>{{ $r->reservation_for }}</th>
                    <th>{{ $r->location }}</th>
                    <th>{{ $r->quantity }}</th>
                    @if(auth()->user()->role == 'Admin')
                        @if($r->status == 0)
                            <th><a href="http://localhost/vesit/public/confirmReservation/{{$r->id}}" class="btn btn-warning">Pending</a></th>
                        @else
                            <th><a href="http://localhost/vesit/public/confirmReservation/{{$r->id}}" class="btn btn-success">Approved</a></th>
                        @endif
                    @else
                <th>{{ $r->status }}</th>
                    @endif
            @endforeach
        </table>
    </div>
   
@endsection