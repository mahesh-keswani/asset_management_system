@extends('pages.index')

@section('content')

<div class="container">
        <div class="form-group"> 

        <form method="post" action="{{ action('AssetController@update',$asset->id) }}">
        
        {{ csrf_field() }}
                

        <label class="form-control">Name</label>
       <input type="text" value="{{ $asset->name }}" class="form-control" name="name">

       <label class="form-control">Description</label>
        <input type="text" name="description" value="{{ $asset->description }}" class="form-control">

        <label class="form-control">Group</label>      
        <input type="text" name="group" class="form-control" value="{{ $asset->group }}">
        
        <label class="form-control">Purchased on</label>      
        <input type="date" name="purchased_on" class="form-control" value="{{ $asset->purchased_on }}">
        
        <label class="form-control">Location</label>
        <input type="text" name="location" class="form-control" value="{{ $asset->location }}">

        <button type="button" data-target="#createLocation" data-toggle="modal" class="btn btn-default">Add Location</button> 

       {{ Form::hidden('_method','PUT') }}
        <br/>

        <input type="submit" value="Update" class="btn btn-primary btn-block"> 
    </div>
 {!! Form::close()!!}
    

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
        
                            <div class="form-group">    
                                <label class="form-control">Name</label>
                               <input type="text" name="name" autocomplete="off" class="form-control">
                            </div>
                            <div class="form-group">
                                <label class="form-control">Country</label>
                                <input type="text" name="country" autocomplete="off" class="form-control">

                            </div>
                            <div class="form-group">
                                <label class="form-control">State</label>
                                <input type="text" class="form-control" name="state">
                                   
                            </div>
                            <div class="form-group">
                                    <label class="form-control">City</label>
                                    <input class="form-control" name="city" type="text">

                            </div>
                            <div class="form-group">
                                    <label class="form-control">Zipcode</label>
                                    <input type="number" name="zipcode" class="form-control">
                            </div>
                           
                           
                                    <div class="form-group">
                                            <label class="form-control">Address</label>
                                            <textarea name="address" id="" cols="30" rows="10" class="form-control"></textarea>
                                        </div>
                                        
                                        <div class="form-group">
                                                <label class="form-control">Phone Number</label>
                                                <input type="number" name="phone" class="form-control">

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

 @endsection