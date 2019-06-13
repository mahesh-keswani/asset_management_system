@extends('pages.index')

@section('content')
 

    <br/>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a href="#allMembers" data-toggle="tab" style="padding-right:50px;">All Members</a>
                    </li>
                    <li>
                            <a href="#active" data-toggle="tab" style="padding-right:50px;">Active Member</a>
                     </li>
                     <li>
                            <a href="#inactive" data-toggle="tab" style="padding-right:50px;">InActive Member</a>
                     </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="allMembers">
                            <br/><br/>
                            <h3 class="well text-center">All Members</h3>
    
                            <table class="table table-striped" style="border-radius:20px;font-family:'Courier New', Courier, monospace">
                                <tr>
                                    <th><h3>Name</h3></th>
                                    <th><h3>Added on</h3></th>
                                    <th><h3>Role</h3></th>
                                    <th>State</th>
                                    
                                </tr>
                                @foreach($users as $user)
                                    <tr>
                                        <th>{{ $user->name }}</th>
                                        <th>{{ $user->created_at }}</th>
                                        <th>{{ $user->role }}</th>
                                        @if($user->role == 'Admin')
                                        <td><input type="button"  name="state" class="btn btn-success" value="Active" disabled>
                                    @else
                                      
                                            @if($user->state=="Active")
                                                <td> <a href="http://localhost/vesit/public/state/{{$user->id}}"  class='btn btn-success' >{{$user->state}}</a></td>
                                            @else  
                                                <td> <a href="http://localhost/vesit/public/state/{{$user->id}}"  class='btn btn-warning' >{{$user->state}}</a></td>
                                            @endif
                          
                                                 
                                    @endif
                                    </tr>
                                @endforeach
                            </table>
                    </div>


 <div class="tab-pane" id="active">
        <br/><br/>
        <h3 class="well text-center">Active Members</h3>

        <table class="table table-striped" style="border-radius:20px;font-family:'Courier New', Courier, monospace">
            <tr>
                <th><h3>Name</h3></th>
                <th><h3>Added on</h3></th>
                <th><h3>Role</h3></th>
                <th>State</th>
                
            </tr>
            @foreach($users as $user)
                @if($user->state == 'Active')    
            <tr>
                    <th>{{ $user->name }}</th>
                    <th>{{ $user->created_at }}</th>
                    <th>{{ $user->role }}</th>
                    @if($user->role == 'Admin')
                    <td><input type="button"  name="state" class="btn btn-success" value="Active" disabled>
                @else
                  
                        @if($user->state=="Active")
                            <td> <a href="http://localhost/vesit/public/state/{{$user->id}}"  class='btn btn-success' >{{$user->state}}</a></td>
                        @else  
                            <td> <a href="http://localhost/vesit/public/state/{{$user->id}}"  class='btn btn-warning' >{{$user->state}}</a></td>
                        @endif
      
                             
                @endif
                </tr>
                @endif
            @endforeach
        </table>
</div>
<div class="tab-pane" id="inactive">
        <br/><br/>
        <h3 class="well text-center">InActive Members</h3>

        <table class="table table-striped" style="border-radius:20px;font-family:'Courier New', Courier, monospace">
            <tr>
                <th><h3>Name</h3></th>
                <th><h3>Added on</h3></th>
                <th><h3>Role</h3></th>
                <th>State</th>
                
            </tr>
            @foreach($users as $user)
                @if($user->state == 'Inactive')    
            <tr>
                    <th>{{ $user->name }}</th>
                    <th>{{ $user->created_at }}</th>
                    <th>{{ $user->role }}</th>
                    @if($user->role == 'Admin')
                    <td><input type="button"  name="state" class="btn btn-success" value="Active" disabled>
                @else
                  
                        @if($user->state=="Active")
                            <td> <a href="http://localhost/vesit/public/state/{{$user->id}}"  class='btn btn-success' >{{$user->state}}</a></td>
                        @else  
                            <td> <a href="http://localhost/vesit/public/state/{{$user->id}}"  class='btn btn-warning' >{{$user->state}}</a></td>
                        @endif
      
                             
                @endif
                </tr>
                @endif
            @endforeach
        </table>
</div>
@endsection 