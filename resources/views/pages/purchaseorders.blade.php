@extends('pages.index')

@section('content')
 

    <br/>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a href="#allMembers" data-toggle="tab" style="padding-right:50px;">All Purchase Orders</a>
                    </li>
                    <li>
                            <a href="#active" data-toggle="tab" style="padding-right:50px;">Approved Purchasess</a>
                     </li>
                     <li>
                            <a href="#inactive" data-toggle="tab" style="padding-right:50px;">Pending Purchases</a>
                     </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="allMembers">
                            <br/><br/>
                            <h3 class="well text-center">All Purchase Orders</h3>
    
                            <table class="table table-striped" style="border-radius:20px;font-family:Georgia, 'Times New Roman', Times, serif">
                                <tr>
                                    <th><h3>Id</h3></th>
                                    <th><h3>Items</h3></th>
                                    <th><h3>Approved By</h3></th>
                                    <th><h3>Vendor</h3></th>
                                    <th><h3>Delivery Date</h3></th>
                                    <th><h3>Payment Terms</h3></th>
                                    <th><h3>Status</h3></th>
                                </tr>
                                @foreach($purchase as $user)
                                    <tr>
                                        <th>{{ $user->id }}</th>
                                        <th>{{ $user->items }}</th>
                                        <th>{{ $user->approver }}</th>
                                        <th>{{ $user->vendor }}</th>
                                        <th>{{ $user->delivery_date }}</th>
                                        <th>{{ $user->payment_terms }}</th>
                                        @if(auth()->user()->role == 'Admin')
                                            @if($user->status == 0)
                                                <th> <a href="http://localhost/vesit/public/confirm/{{$user->id}}"  class='btn btn-warning' >{{$user->status}}</a></th>
                                            @else
                                                <th><a href="#" class="btn btn-success">{{ $user->status }}</a></th>
                                            @endif
                                        @else  
                                            <td>You are not authorized to confirm orders</td>
                                         @endif
                          
                                                 
                                
                                    </tr>
                                @endforeach
                            </table>
                    </div>


@endsection 