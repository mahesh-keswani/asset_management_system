@extends('pages.index')

@section('content')
@if(auth()->user()->role == 'Admin')
    <button data-target="#partialView" data-toggle="modal"  style="padding:5px;" class="btn btn-default">Create Partial View</button>
@endif
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <ul class="nav nav-tabs">
                
                <li class="active">
                    <a href="#assets" data-toggle="tab" style="padding-right:50px;text-align:center;">Assets</a>
                </li>
                <li>
                        <a href="#stocks" data-toggle="tab" style="padding-right:50px;">Asset Stocks</a>
                 </li>
                 <li>
                        <a href="#inventorys" data-toggle="tab" style="padding-right:50px;">Inventorys</a>
                 </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="assets">
                        <br/><br/>
                        <h3 class="well text-center">Assets</h3>
                        
                        <table class="table table-stiped">
                            <tr>
                                <th>Id</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Location</th>
                                <th>Purchased On</th>
                                <th>Cost Price</th>
                                <th>
                                    <a href="{{ url('/dynamicPdfAsset') }}" class="btn btn-info" style="width:150px;display:inline">Print PDF</a><br/><br/>
                                </th>
                                
                                                
  
                            </tr>
                           
                                @foreach($asset as $as)
                                    <tr>
                                        
                                        <th><a href="http://localhost/vesit/public/asset/{{$as->id}}" >{{ $as->id }}</a></th>
                                        <th><a href="http://localhost/vesit/public/asset/{{$as->id}}" >{{ $as->name }}</a></th>
                                        <th><a href="http://localhost/vesit/public/asset/{{$as->id}}" >{{ $as->description }}</a></th>
                                        <th><a href="http://localhost/vesit/public/asset/{{$as->id}}">{{ $as->location }}</a></th>
                                        <th><a href="http://localhost/vesit/public/asset/{{$as->id}}">{{ $as->purchased_on }}</a></th>
                                        <th><a href="http://localhost/vesit/public/asset/{{$as->id}}">{{ $as->cost_price }} $</a></th>
                                    </tr>  
                                @endforeach
                        </table>
                </div>
                <div class="tab-pane" id="stocks">
                        <br/><br/>
                        <h3 class="well text-center">Asset Stocks</h3>
                        <table class="table table-stiped">
                                <tr>
                                    <th>Id</th>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>Location</th>
                                    <th>Purchased On</th>
                                    <th>Cost Price</th>
                                    <th>Low Stock</th>
                                    <th>
                                            <a href="{{ url('/dynamicPdfStock') }}" class="btn btn-info" style="width:150px;display:inline">Print PDF</a><br/><br/>
                                        </th>
                                         
                                </tr>
                                
                               
                                    @foreach($stock as $as)
                                        <tr>
                                            
                                        <th><a href="http://localhost/vesit/public/stock/{{$as->id}}" >{{ $as->id }}</a></th>
                                            <th><a href="http://localhost/vesit/public/stock/{{$as->id}}">{{ $as->name }}</a></th>
                                            <th><a href="http://localhost/vesit/public/stock/{{$as->id}}">{{ $as->description }}</a></th>
                                            <th><a href="http://localhost/vesit/public/stock/{{$as->id}}">{{ $as->location }}</a></th>
                                            <th><a href="http://localhost/vesit/public/stock/{{$as->id}}">{{ $as->purchased_on }}</a></th>
                                            <th><a href="http://localhost/vesit/public/stock/{{$as->id}}">{{ $as->cost_price }} $</a></th>
                                            <th><a href="http://localhost/vesit/public/stock/{{$as->id}}">{{ $as->low_stock }}</a></th>
                                        </tr>
                                    @endforeach
                            </table>
                </div>
                <div class="tab-pane" id="inventorys">
                        <br/><br/>
                        <h3 class="well text-center">Inventorys</h3>
                        <table class="table table-stiped">
                                <tr>
                                    <th>Id</th>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>Location</th>
                                    <th>Purchased On</th>
                                    <th>Cost Price</th>
                                    <th>Low Stock</th>
                                    <th>
                                            <a href="{{ url('/dynamicPdfInventory') }}" class="btn btn-info" style="width:150px;display:inline">Print PDF</a><br/><br/>
                                        </th>
                                       
                                </tr>
                               
                                    @foreach($inventory as $as)
                                        <tr>
                                            
                                        <th><a href="http://localhost/vesit/public/inventory/{{$as->id}}" >{{ $as->id }}</a></th>
                                            <th><a href="http://localhost/vesit/public/inventory/{{$as->id}}">{{ $as->name }}</a></th>
                                            <th><a href="http://localhost/vesit/public/inventory/{{$as->id}}">{{ $as->description }}</a></th>
                                            <th><a href="http://localhost/vesit/public/inventory/{{$as->id}}">{{ $as->location }}</a></th>
                                            <th><a href="http://localhost/vesit/public/inventory/{{$as->id}}">{{ $as->purchased_on }}</a></th>
                                            <th><a href="http://localhost/vesit/public/inventory/{{$as->id}}">{{ $as->cost_price }} $</a></th>
                                            <th><a href="http://localhost/vesit/public/inventory/{{$as->id}}">{{ $as->low_stock }}</a></th>
                                        </tr> 
                                    @endforeach
                            </table>
                </div>
            </div>

            <div class="container">
                    <div class="modal fade" id="partialView">
                        <div class="modal-dialog">
                            <div class="modal-content"  style="padding:10px;width:600px;margin-top:10px;">
                                <div class="modal-header">
                                    <h3 class="modal-title">Create Partial View</h3>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                   
                                </div>
                    
                                <div class="modal-body">
                                     <form method="post"  action="{{ url('/changeView') }}">
                                            {{ csrf_field() }}
                                            <select class="control-label" name="user_name">
                                                @foreach($users as $user)
                                                    <option class="control-label">{{ $user->name }}</option>
                                                @endforeach
                                            </select>
                                            <select class="control-label" name="product_to_hide">
                                                <option class="control-label">Asset</option>
                                                <option class="control-label">Asset Stock</option>
                                                <option class="control-label">Inventory</option>
                                                
                                            </select>
                                            <div class="form-group">
                                                <label class="control-label">Description</label>
                                                <input type="text" class="form-control" name="description" required>
                                                
                                            </div>
                                            <div class="modal-footer">
                                                <input type="submit" value="Add" class="btn btn-primary btn-block" required>
                                            </div>
                                        </form>
                                    
                                    </div>
                                    
                             </div>
                                
                        </div>
                    </div>
                    </div>
@endsection

