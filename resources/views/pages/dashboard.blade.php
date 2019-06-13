@extends('pages.index')

@section('content')
    <div class="row">
        <div class="col-md-3">
            <div class="jumbotron">
                    
                       Total Assets
                       
                      <h3>{{ count($asset) }} </h3>
                    
                </div>
        </div>

        <div class="col-md-3">
                <div class="jumbotron">
                    
                        Total Asset Stocks
                        
                       <h3>{{ count($stock) }} </h3>
                     
                 </div>
            </div>
            <div class="col-md-3">
                    <div class="jumbotron">
                    
                            Total Consumables
                            
                           <h3>{{ count($inventory) }} </h3>
                         
                     </div>
                </div>
                <div class="col-md-3">
                    <div class="btn-group" role="group" aria-label="Basic example">
                        <button data-target="#createAsset" data-toggle="modal" style="padding:20px;" class="btn btn-primary">Add Asset</button>
                        <button data-target="#createStock" data-toggle="modal"  style="padding:20px;" class="btn btn-info">Add Asset Stock</button>
                        <button data-target="#createInventory" data-toggle="modal"  style="padding:20px;" class="btn btn-warning">Add Consumable</button>
                        
                    </div>
                </div>
    </div>
<br/>
<br/>


    <h2>Notifications</h2>
    <table class="table table-striped">
        <tr>
            <th>Serial No</th>
            <th>Messages</th>
            <th>Status</th>
            <th>Created At</th>
        </tr>
        @foreach($notification as $no)
            <tr>
                <th>{{ $no->id }}</th>
                <th>{{ $no->messages }}</th>
                <th>{{ $no->status }}</th>
                <th>{{  $no->created_at }}</th>
            </tr>
        @endforeach
    </table>



                     <div class="container">
                        <div class="modal fade" id="createAsset">
                            <div class="modal-dialog">
                                <div class="modal-content"  style="padding:10px;width:600px;margin-top:10px;">
                                    <div class="modal-header">
                                        <h3 class="modal-title">Add Asset</h3>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                       
                                    </div>
                        
                                    <div class="modal-body">
                                        <form method="post" action="{{ action('AssetController@store') }}">
                                                {{ csrf_field() }}
                                                <div class="form-group">    
                                                    <label class="form-control">Name</label>
                                                <input type="text" name="name" autocomplete="off" class="form-control" required>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-control">Description</label>
                                                    <input type="text" name="description" autocomplete="off" class="form-control" required>

                                                </div>
                                                <div class="form-group">
                                                        <label class="form-control">Quantity</label>
                                                        <input type="number" name="quantity" autocomplete="off" class="form-control" required>
    
                                                    </div>
                                                    
                                                <div class="form-group">
                                                    <label class="form-control">Location</label>
                                                    <select class="form-control" name="location" required>
                                                        @foreach($location as $loc)
                                                            <option>{{ $loc->name }}</option>
                                                        @endforeach
                                                    </select>
                                                    <button type="button" data-target="#createLocation" data-toggle="modal" class="btn btn-default">Add Location</button> 
                                                </div>
                                                <div class="form-group">
                                                        <label class="form-control">Vendor</label>
                                                        <select class="form-control" name="vendor" required>
                                                            @foreach($vendor as $loc)
                                                                <option>{{ $loc->name }}</option>
                                                            @endforeach
                                                        </select>
                                                        <button type="button" data-target="#createVendor" data-toggle="modal" class="btn btn-default">Add Vendor</button> 
                                                    </div>
                                                    

                                                <div class="form-group">
                                                        <label class="form-control">Group</label>
                                                        <select class="form-control" name="group" required>
                                                                @foreach($group as $loc)
                                                                    <option>{{ $loc->name }}</option>
                                                                @endforeach
                                                        </select>                 
                                                  <button type="button" data-target="#createGroup" data-toggle="modal" class="btn btn-default">Create Group</button> 

                                                </div>
                                                
                                                <div class="form-group">
                                                        <label class="form-control">Purchased On</label>
                                                        
                                                        <input type="date" name="purchased_on" class="form-control" required>
                                                </div>
                                            
                                            
                                                        <div class="form-group">
                                                                <label class="form-control">Cost Price(per unit)</label>
                                                                <input type="number" name="cost_price" class="form-control" required>

                                                            </div>
                                                            
                                                            
                                                    
                                                <br/>
                                            
                                                <div class="modal-footer">
                                                    <input type="submit" value="Add" class="btn btn-primary btn-block">
                                                </div>
                                            </form>
                                        </div>
                                       
                                    
                                 </div>
                                    
                            </div>
                        </div>
                        </div>

                        <div class="container">
                                <div class="modal fade" id="createStock">
                                    <div class="modal-dialog">
                                        <div class="modal-content"  style="padding:10px;width:600px;margin-top:10px;">
                                            <div class="modal-header">
                                                <h3 class="modal-title">Add Asset Stock</h3>
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                               
                                            </div>
                                
                                            <div class="modal-body">
                                                <form method="post" action="{{ action('StockController@store') }}">
                                                    {{ csrf_field() }}
                                                        <div class="form-group">    
                                                            <label class="form-control">Name</label>
                                                        <input type="text" name="name" autocomplete="off" class="form-control" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-control">Description</label>
                                                            <input type="text" name="description" autocomplete="off" class="form-control" required>
            
                                                        </div>
                                                        <div class="form-group">
                                                                <label class="form-control">Quantity</label>
                                                                <input type="number" name="quantity" autocomplete="off" class="form-control" required>
            
                                                            </div>
                                                        <div class="form-group">
                                                            <label class="form-control">Location</label>
                                                            <select class="form-control" name="location" required>
                                                                @foreach($location as $loc)
                                                                    <option>{{ $loc->name }}</option>
                                                                @endforeach
                                                            </select>
                                                            <button type="button" data-target="#createLocation" data-toggle="modal" class="btn btn-default">Add Location</button> 
                                                        </div>
                                                        <div class="form-group">
                                                                <label class="form-control">Vendor</label>
                                                                <select class="form-control" name="vendor" required>
                                                                    @foreach($vendor as $loc)
                                                                        <option>{{ $loc->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                                <button type="button" data-target="#createVendor" data-toggle="modal" class="btn btn-default">Add Vendor</button> 
                                                            </div>
                                                        <div class="form-group">
                                                                <label class="form-control">Group</label>
                                                                <select class="form-control" name="group" required>
                                                                        @foreach($group as $loc)
                                                                            <option>{{ $loc->name }}</option>
                                                                        @endforeach
                                                                    </select>                                                
                                                                    <button type="button" data-target="#createGroup" data-toggle="modal" class="btn btn-default">Create Group</button> 
            
                                                        </div>
                                                        <div class="form-group">
                                                                <label class="form-control">Purchased On</label>
                                                                <input type="date" name="purchased_on" class="form-control" required>
                                                            </div>
                                                    
                                                    
                                                                <div class="form-group">
                                                                        <label class="form-control">Cost Price(per unit)</label>
                                                                        <input type="number" name="cost_price" class="form-control" required>
            
                                                                    </div>
                                                                    
                                                                    <div class="form-group">
                                                                            <label class="form-control">Low Stock Value</label>
                                                                            <input type="number" name="low_stock" class="form-control" required>
                
                                                                        </div>
                                                                        
                                                            
                                                        <br/>
                                                    
                                                    
                                                        <div class="modal-footer">
                                                            <input type="submit" value="Add" class="btn btn-primary btn-block">
                                                        </div>
                                                    </form>
                                                </div>
                                               
                                            </div>
                                       
                                            
                                    </div>
                                </div>
                                </div>
        
                                <div class="container">
                                        <div class="modal fade" id="createInventory">
                                            <div class="modal-dialog">
                                                <div class="modal-content"  style="padding:10px;width:600px;margin-top:10px;">
                                                    <div class="modal-header">
                                                        <h3 class="modal-title">Add Inventory</h3>
                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                       
                                                    </div>
                                        
                                                    <div class="modal-body">
                                                        <form method="post" action="{{ action('InventoryController@store') }}">
                                                            {{ csrf_field() }}
                                                                <div class="form-group">    
                                                                    <label class="form-control">Name</label>
                                                                <input type="text" name="name" autocomplete="off" class="form-control" required>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label class="form-control">Description</label>
                                                                    <input type="text" name="description" autocomplete="off" class="form-control" required>
                    
                                                                </div>
                                                                <div class="form-group">
                                                                        <label class="form-control">Quantity</label>
                                                                        <input type="number" name="quantity" autocomplete="off" class="form-control" required>
                    
                                                                    </div>
                                                                <div class="form-group">
                                                                    <label class="form-control">Location</label>
                                                                    <select class="form-control" name="location" required>
                                                                        @foreach($location as $loc)
                                                                            <option>{{ $loc->name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                    <button type="button" data-target="#createLocation" data-toggle="modal" class="btn btn-default">Add Location</button> 
                                                                </div>

                                                                <div class="form-group">
                                                                        <label class="form-control">Vendor</label>
                                                                        <select class="form-control" name="vendor" required>
                                                                            @foreach($vendor as $loc)
                                                                                <option>{{ $loc->name }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                        <button type="button" data-target="#createVendor" data-toggle="modal" class="btn btn-default">Add Vendor</button> 
                                                                    </div>
                                                                <div class="form-group">
                                                                        <label class="form-control">Group</label>
                                                                        <select class="form-control" name="group" required>
                                                                                @foreach($group as $loc)
                                                                                    <option>{{ $loc->name }}</option>
                                                                                @endforeach
                                                                            </select>                                                <button type="button" data-target="#createGroup" data-toggle="modal" class="btn btn-default">Create Group</button> 
                    
                                                                </div>
                                                                <div class="form-group">
                                                                        <label class="form-control">Purchased On</label>
                                                                        <input type="date" name="purchased_on" class="form-control" required>
                                                                    </div>
                                                            
                                                            
                                                                        <div class="form-group">
                                                                                <label class="form-control">Cost Price(per unit)</label>
                                                                                <input type="number" name="cost_price" class="form-control"  required>
                    
                                                                            </div>
                                                                            
                                                                            <div class="form-group">
                                                                                    <label class="form-control">Low Stock Value</label>
                                                                                    <input type="number" name="low_stock" class="form-control" required>
                        
                                                                                </div>
                                                                                
                                                                    
                                                                <br/>
                                                                <div class="modal-footer">
                                                                    <input type="submit" value="Add" class="btn btn-primary btn-block">
                                                                </div>
                                                            </form>
                                                            
                                                        
                                                        </div>
                                                        
                                                 </div>
                                                    
                                            </div>
                                        </div>
                                        </div>
                


                                        <div class="container">
                                                <div class="modal fade" id="createLocation">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content"  style="padding:10px;width:600px;margin-top:10px;">
                                                            <div class="modal-header">
                                                                <h3 class="modal-title">Add Location</h3>
                                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                               
                                                            </div>
                                                
                                                            <div class="modal-body">
                                                                <form method="post" action="{{ action('LocationController@store') }}" accept-charset="UTF-8">
                                                                    {{ csrf_field() }}
                                                                    <div class="form-group">    
                                                                        <label class="form-control">Name</label>
                                                                       <input type="text" name="name" autocomplete="off" class="form-control" required>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="form-control">Country</label>
                                                                        <input type="text" name="country" autocomplete="off" class="form-control" required>
                        
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="form-control">State</label>
                                                                        <input type="text" class="form-control" name="state" required>
                                                                           
                                                                    </div>
                                                                    <div class="form-group">
                                                                            <label class="form-control">City</label>
                                                                            <input class="form-control" name="city" type="text" required>
                        
                                                                    </div>
                                                                    <div class="form-group">
                                                                            <label class="form-control">Zipcode</label>
                                                                            <input type="number" name="zipcode" class="form-control" required>
                                                                    </div>
                                                                   
                                                                   
                                                                            <div class="form-group">
                                                                                    <label class="form-control">Address</label>
                                                                                    <textarea name="address" id="" cols="30" rows="10" class="form-control" required></textarea>
                                                                                </div>
                                                                                
                                                                                <div class="form-group">
                                                                                        <label class="form-control">Phone Number</label>
                                                                                        <input type="number" name="phone" class="form-control" required>
                            
                                                                                    </div>
                                                                                
                                                                                    
                                                                        
                                                                    <br/>
                                                                
                                                                    <div class="modal-footer">
                                                                            <input type="submit" value="Add" class="btn btn-primary btn-block">
                                                                    </div>
                                                                </form>
                                                            
                                                            </div>
                                                            
                                                         </div>
                                                            
                                                    </div>
                                                </div>
                                                </div>

                                                <div class="container">
                                                        <div class="modal fade" id="createGroup">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content"  style="padding:10px;width:600px;margin-top:10px;">
                                                                    <div class="modal-header">
                                                                        <h3 class="modal-title">Add Group</h3>
                                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                       
                                                                    </div>
                                                        
                                                                    <div class="modal-body">
                                                                         <form method="post"  action="{{ action('GroupController@store') }}" accept-charset="UTF-8">
                                                                                {{ csrf_field() }}
                                                                                <div class="form-group">    
                                                                                    <label class="form-control">Name</label>
                                                                                <input type="text" name="name" autocomplete="off" class="form-control" required>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <label class="form-control">Description</label>
                                                                                    <input type="text" name="description" autocomplete="off" class="form-control" required>
                                    
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <label class="form-control">Depriciation Rate</label>
                                                                                    <input type="number" class="form-control" name="depreciation_rate" required>
                                                                                    
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

                                
                                                        <div class="container">
                                                                <div class="modal fade" id="createVendor">
                                                                    <div class="modal-dialog">
                                                                        <div class="modal-content"  style="padding:10px;width:600px;margin-top:10px;">
                                                                            <div class="modal-header">
                                                                                <h3 class="modal-title">Add Vendor</h3>
                                                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                               
                                                                            </div>
                                                                
                                                                            <div class="modal-body">
                                                                                 <form method="post"  action="{{ action('VendorController@store') }}" accept-charset="UTF-8">
                                                                                        {{ csrf_field() }}
                                                                                        <div class="form-group">    
                                                                                            <label class="form-control">Name</label>
                                                                                        <input type="text" name="name" autocomplete="off" class="form-control" required>
                                                                                        </div>
                                                                                        <div class="form-group">
                                                                                            <label class="form-control">Website</label>
                                                                                            <input type="text" name="website" autocomplete="off" class="form-control" required>
                                            
                                                                                        </div>
                                                                                        <div class="form-group">
                                                                                            <label class="form-control">Address</label>
                                                                                            <input type="text" class="form-control" name="address" required>
                                                                                            
                                                                                        </div>
                                                                                        <div class="form-group">
                                                                                                <label class="form-control">Phone</label>
                                                                                                <input type="number" class="form-control" name="phone" required>
                                                                                                
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
<div class="container">
        <div class="modal fade" id="purchaseOrder">
            <div class="modal-dialog">
                <div class="modal-content"  style="padding:10px;width:600px;margin-top:10px;">
                    <div class="modal-header">
                        <h3 class="modal-title">Purchase Order</h3>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        
                    </div>
        
                    <div class="modal-body">
                            <form method="post"  action="{{ action('PurchaseController@store') }}" accept-charset="UTF-8">
                                {{ csrf_field() }}
                                <div class="form-group">    
                                    <label class="form-control">Current Date</label>
                                    <label class="form-control" name="current_date">{{ date('Y-m-d @ H:i:s') }}</label>
                                </div>
                                <div class="form-group">
                                    <label class="form-control">Delivery Date</label>
                                    <input type="date" name="delivery_date" autocomplete="off" class="form-control" required>

                                </div>
                                <div class="form-group">
                                    <label class="form-control">Vendor</label>
                                    <select name="vendor" class="form-control">
                                        @foreach($vendor as $v)
                                            <option>{{ $v->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                        <label class="form-control">Approver</label>
                                        <select name="approver" class="form-control">
                                            @foreach($userAdmins as $v)
                                                <option>{{ $v->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <label class="control-label">Add Items</label>
                                    <div class="form-group">
                                            <label class="form-control">Assets</label>
                                            <select  multiple  name="purchase_asset" class="form-control">
                                                @foreach($asset as $v)
                                                    <option>{{ $v->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                                <label class="form-control">Asset Stock</label>
                                                <select  multiple  name="purchase_stock" class="form-control">
                                                    @foreach($stock as $v)
                                                        <option>{{ $v->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                    <label class="form-control">Inventory</label>
                                                    <select multiple name="purchase_inventory" class="form-control">
                                                        @foreach($inventory as $v)
                                                            <option>{{ $v->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                {{-- <div class="form-group">
                                                        <button data-target="#createNewItem" name="add_new_item" data-toggle="modal" class="btn btn-primary">Add New Items</button>
                                                </div> --}}
                                                <div class="form-group">
                                                    <label class="control-label">Description</label>
                                                    <textarea name="description" class="form-control"></textarea>
                                                </div>
                                            <div class="form-group">
                                                <label class="control-label">Payment Terms</label>
                                                <input type="text" name="payment_terms" class="form-control">
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
       


<div class="container">
    <div class="modal fade" id="createNewItem">
        <div class="modal-dialog">
            <div class="modal-content"  style="padding:10px;width:600px;margin-top:10px;">
                <div class="modal-header">
                    <h3 class="modal-title">Add Item</h3>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>

                </div>

            <div class="modal-body">
                <form method="post" action="{{ action('PurchaseController@store') }}">
        {{ csrf_field() }}
        <div class="form-group">
                <label class="form-control">Item Type</label>
                <select class="form-control" name="item_type" required>
                    
                        <option>Asset</option>
                        <option>Stock</option>
                        <option>Inventory</option>
                    
                </select>
            </div>
        <div class="form-group">    
            <label class="form-control">Name</label>
        <input type="text" name="name" autocomplete="off" class="form-control" required>
        </div>
        <div class="form-group">
            <label class="form-control">Description</label>
            <input type="text" name="description" autocomplete="off" class="form-control" required>

        </div>
        <div class="form-group">
                <label class="form-control">Quantity</label>
                <input type="number" name="quantity" autocomplete="off" class="form-control" required>

            </div>
            
        <div class="form-group">
            <label class="form-control">Location</label>
            <select class="form-control" name="location" required>
                @foreach($location as $loc)
                    <option>{{ $loc->name }}</option>
                @endforeach
            </select>
            <button type="button" data-target="#createLocation" data-toggle="modal" class="btn btn-default">Add Location</button> 
        </div>
        <div class="form-group">
                <label class="form-control">Vendor</label>
                <select class="form-control" name="vendor" required>
                    @foreach($vendor as $loc)
                        <option>{{ $loc->name }}</option>
                    @endforeach
                </select>
                <button type="button" data-target="#createVendor" data-toggle="modal" class="btn btn-default">Add Vendor</button> 
            </div>
            

        <div class="form-group">
                <label class="form-control">Group</label>
                <select class="form-control" name="group" required>
                        @foreach($group as $loc)
                            <option>{{ $loc->name }}</option>
                        @endforeach
                </select>                 
            <button type="button" data-target="#createGroup" data-toggle="modal" class="btn btn-default">Create Group</button> 

        </div>
        
        <div class="form-group">
                <label class="form-control">Purchased On</label>
                
                <input type="date" name="purchased_on" class="form-control" required>
        </div>


                <div class="form-group">
                        <label class="form-control">Cost Price(per unit)</label>
                        <input type="number" name="cost_price" class="form-control" required>

                    </div>
                    
                    
            
        <br/>

        <div class="modal-footer">
            <input type="submit" value="Add" class="btn btn-primary btn-block">
        </div>
    </form>
</div>


</div>
                                
@endsection