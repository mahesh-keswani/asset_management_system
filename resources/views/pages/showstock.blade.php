@extends('pages.index')

@section('content')



<div class="row">
        <div class="col-md-9">
         <div class="jumbotron">
        <h3>Id</h3>
        <h4>{{$stock->id}}</h4>
        <hr>
        

        <h3>Name</h3>
        <h4>{{$stock->name}}</h4>

        <hr>

        <h3>Description</h3>
        <h4>{{$stock->description}}</h4>

        <hr>

        <h3>Purchased On</h3>
        <h4>{{$stock->purchased_on}}</h4>

        <hr>

        <h3>Location</h3>
        <h4>{{$stock->location}}</h4>

        <hr>
        <h3>Vendor</h3>
        <h4>{{$stock->vendor}}</h4>
        <hr>
        

        <h3>Purchased On</h3>
        <h4>{{$stock->purchased_on}}</h4>
        
        <hr>

        <h3>Low Stock Quantity</h3>
        <h4>{{$stock->low_stock}}</h4>
        
        <hr>

        <h3>Quantity</h3>
        <h4>{{$stock->quantity}}</h4>
        <hr>
        <h3>Available</h3>
        <h4>{{$stock->available}}</h4>
        <hr>
            
        <h3>Cost Price</h3>
        <h4>{{$stock->cost_price}}</h4>
        <hr>
         @if(!empty($d_rate))
                <h3>Depreciation Rate</h3>
                <h4>{{$d_rate}} $</h4>
                <hr>
        @endif

        {{-- <h3>Depreciation Rate</h3>
        <h4>{{$d_rate}}</h4>
        <hr> --}}
        
        
        @if(!empty($d_rate))
                <h3 class="label-control">The item has been retired</h3>
        @else
                <div class="btn-group" role="group" aria-label="Basic example">
                        
                        <a href="http://localhost/vesit/public/stock/{{$stock->id}}/edit" class="btn btn-primary pull-right">Edit</a>
                        
                        @if(auth()->user()->role == 'Admin')
                                <a href="http://localhost/vesit/public/service_stock/{{$stock->id}}" class="btn btn-info pull-right">Service</a>
                                <a href="http://localhost/vesit/public/retire_stock/{{$stock->id}}" class="btn btn-warning pull-right">Retire</a>
                                <button data-target="#sell" data-toggle="modal" class="btn btn-success">Sell</button>

                                <div class="container">
                                        <div class="modal fade" id="sell">
                                            <div class="modal-dialog">
                                                <div class="modal-content"  style="padding:10px;width:600px;margin-top:10px;">
                                                    <div class="modal-header">
                                                        <h3 class="modal-title">Sell To Customer</h3>
                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                       
                                                    </div>
                                        
                                                    <div class="modal-body">
                                                         <form method="post"  action="" accept-charset="UTF-8">
                                                                {{ csrf_field() }}
                                                                <input type="number" name="id" value="{{ $stock->id }}" hidden>
                                                                <div class="form-group">    
                                                                    <label class="form-control">Name</label>
                                                                <input type="text" name="name" autocomplete="off" class="form-control" required>
                                                                </div>
                                                                
                                                                <div class="form-group">    
                                                                        <label class="form-control">Price</label>
                                                                    <input type="number" name="price" autocomplete="off" class="form-control" required>
                                                                    </div>
                                                                    <div class="form-group">    
                                                                            <label class="form-control">Quantity</label>
                                                                        <input type="number" name="quantity" autocomplete="off" class="form-control" required>
                                                                        </div>
                                                                        
                                                                        
                                                                        <div class="modal-footer">
                                                                                <input type="submit" value = "Sell" class="btn btn-primary">
                                                                                </div>
                                                                        
                                                                        </div>
                                                            </form>
                                                        
                                                        </div>

                                                        
                                            
                                                    
                                            </div>
                                        </div>
                                        </div>
                
                        @else
                                <small>Staff can only <code><b>Edit</b></code> it</small>
                        @endif
                </div>
                </div>
        </div>
        
        <div class="col-md-3" style="background-color:crimson;height:350px;border-radius:8px;">
                        <center>  
                            @if($stock['available'] <= 0)
                
                                <a href="http://localhost/vesit/public/checkout/{{$stock->id}}" class="btn btn-info" style="width:150px;margin-top:30px;border-radius:15px;" disabled>Checkout</a><br/><br/>
                            @else
                
                                <a href="http://localhost/vesit/public/checkout_stock/{{$stock->id}}" class="btn btn-info" style="width:150px;margin-top:30px;border-radius:15px;">Checkout</a><br/><br/>
                
                                <a href="http://localhost/vesit/public/reservation/_stock{{$stock->id}}" class="btn btn-primary" style="width:150px;">Make Reservation</a><br/><br/>
                                
                       

                                @if($stock->quantity > $stock->available)
                                    @if(!empty($user_id))
                                        <a href="http://localhost/vesit/public/checkinStock/{{ $stock->id }}/{{$user_id}}" class="btn btn-info" style="width:150px;margin-top:30px;border-radius:15px;">Check in</a>
                                        <br><br/><h6>Checked out by user with id {{ $user_id }}</h6> 
                                    @else
                                        <br/><br/><h6>Reserved By someone</h6>
                                    @endif   
                                @endif
                            @endif
                            </center>
                </div>
        @endif
</div>



@endsection