@extends('pages.index')

@section('content')

<button data-target="#createCart" data-toggle="modal"  class="btn btn-primary">Create Cart</button>

@if(count($cart) == 0)
<h3 class="control-label">No carts created</h3>
@else 
<table class="table table-striped">
    <tr>
        <th>Id</th>
        <th>Name</th>
        <th>Items</th>
        <th>NoOfItems</th>
        <th></th>
        <th></th>
       
    </tr>
    @foreach($cart as $c)
        <tr>
            <th>{{ $c->id }}</th>
            <th>{{ $c->name }}</th>
            <th>{{ $c->items }}</th>
            <th>{{ $c->quantity }}</th>
            <th><a href="http://localhost/vesit/public/cart/{{$c->id}}/edit" class="btn btn-primary">Add More Items</th>

                <th>
                @if(auth()->user()->role == 'Admin')
                    {!!Form::open(['action' => ['CartController@destroy',$c->id],'method'=>'post','class'=>'pull-right'])!!}
                        {{Form::hidden('_method','DELETE')}}
                        {{Form::submit('Delete',['class'=>'btn btn-danger'])}}
                    {!!Form::close()!!}
                
                
                @endif
            </th>
        </tr>
    @endforeach
</table>
@endif

<div class="container">
    <div class="modal fade" id="createCart">
        <div class="modal-dialog">
            <div class="modal-content"  style="padding:10px;width:600px;margin-top:10px;">
                <div class="modal-header">
                    <h3 class="modal-title">Add Item</h3>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    
                </div>
                            

        <div class="modal-body">
            <form method="post" action="{{ action('CartController@store') }}">
                {{ csrf_field() }}
                <div class="form-group>">
                    <label class="control-label">Name</label>
                    <input type="text" name="name" class="form-control">
                </div>

                <div class="form-group">
                    <label class="control-label">Add Item</label>
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
                </div>

                <label class="control-label">Quantity</label>
                <div class="form-group">
                    <input type="number" class="form-control" name="quantity" min="0" max="20" required>
                </div>

                <div id="enterdate" class="form-group">
                        <label class="control-label">From Date</label>
                        <input type="date" name="from_date" class="form-control">
                        
                        <label class="control-label">To Date</label>
                        <input type="date" name="to_date" class="form-control">
                </div>
                        
                <div class="modal-footer">
                    <input type="submit" class="btn btn-success pull-right" value="Create Cart">
                </div>
                </form>
             </div>
               
           
              </div>
        </div>
    </div>
</div>
</div>

<script>
    var today = new Date().toISOString().split('T')[0];
    document.getElementsByName("from_date").setAttribute('min',today);

</script>

@endsection