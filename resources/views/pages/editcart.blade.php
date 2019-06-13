@extends('pages.index')

@section('content')

<div class="container">
        <div class="form-group"> 

        <form method="post" action="{{ action('CartController@update',$cart->id) }}">
            {{ csrf_field() }}
        <label class="form-control">Add item</label>
        <select name="item" class="form-control">
            @foreach($asset as $a)
                <option>{{ $a }}</option>
            @endforeach
            @foreach($stock as $s)
                <option>{{ $s }}
            @endforeach
            @foreach($inventory as $s)
                <option>{{ $s }}
            @endforeach
            
        </select> 

        <label class="form-control">Quanity</label>
         <input type="text" name="quantity"  class="form-control">

         
            <input type="date" name="from_date" value={{ $cart->from_date }} class="form-control" hidden>
            <input type="date" name="to_date" value={{ $cart->to_date }} class="form-control" hidden>
         
         {{ Form::hidden('_method','PUT') }}
         <br/>
 
         <input type="submit" value="Update" class="btn btn-primary btn-block"> 
     </div>
  {!! Form::close()!!}
</div>
@endsection
 