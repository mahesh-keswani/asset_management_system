@extends('pages.index')

@section('content')
<center>
    <div style="width:600px;">
<form method="post" action="{{ action('CheckoutController@stockCheckout') }}">
    {{ csrf_field() }}
    <input type="number" value="{{ $stock_id }}" name="stock_id" hidden>
    <div class="form-group">    
        <label class="form-control">Return Date</label>
    <input type="date" name="return_date" autocomplete="off" class="form-control" required>
    </div>
    <div class="form-group">
        <label class="form-control">Checkout_to</label>
        <select class="form-control" name="checkout_to" required>
          @foreach($user as $loc)
                <option>{{ $loc->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
            <label class="form-control">Description</label>
            <input type="text" name="description" autocomplete="off" class="form-control" required>
           
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
            <input type="date" value="{{ date('Y-m-d @ H:i:s',time()) }}"  name="created_at" hidden>
    </div>
   
    <div class="form-group">
        <label class="form-control">Quantity</label>
        <input type="number" name="quantity" name="created_at" class="form-control">
</div>
<input type="submit" value="Checkout" class="btn btn-primary btn-block">
</form>
    </div>
</center>
@endsection