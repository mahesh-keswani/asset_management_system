@extends('pages.index')

@section('content')
<center>
    <div style="width:600px;">
<form method="post" action="{{ action('ReservationController@stockReservation') }}">
    {{ csrf_field() }}
    <input type="number" value="{{ $stock_id }}" name="stock_id" hidden>
    <div class="form-group">    
        <label class="form-control">From Date</label>
    <input type="date" name="from_date" autocomplete="off" class="form-control" required>
    </div>

    <div class="form-group">    
            <label class="form-control">To Date</label>
        <input type="date" name="to_date" autocomplete="off" class="form-control" required>
        </div>
        

    <div class="form-group">
        <label class="form-control">Reservation For</label>
        <select class="form-control" name="reservation_for" required>
          @foreach($user as $loc)
                <option>{{ $loc->name }}</option>
            @endforeach
        </select>
    </div>
   
        
    <div class="form-group">
        <label class="form-control">Location</label>
        <select class="form-control" name="location" required>
            @foreach($location as $loc)
                <option>{{ $loc->name }}</option>
            @endforeach
        </select>
    </div>
    
   
    <div class="form-group">
        <label class="form-control">Quantity</label>
        <input type="number" name="quantity" name="created_at" class="form-control">
</div>
<input type="submit" value="Reserve" class="btn btn-primary btn-block">
</form>
    </div>
</center>
@endsection