@extends('pages.index')

@section('content')
<center><h3>Related searches are</h3></center>
@if(isset($_POST['q']) || (!empty($asset) || !empty($stock) || !empty($inventory)))
    
<table class="table table-striped">
        <tr>
            <th>Id</th>
            <th>Name</th>
            <th>Location</th>>
            <th>Group</th>
            <th>Purchased On</th>
            <th>Cost Price</th>
        </tr>
        @foreach($asset as $p)
        <tr style="color:black;">
            <th>{{ $p->id }}</th>
            <th>{{$p->name}}</th>
            <th>{{$p->location}}</th>
            <th>{{$p->group}}</th>
            <th>{{ $p->purchased_on }}</th>
            <th>{{ $p->cost_price }} $</th>
        
        </tr>
        @endforeach
        @foreach($stock as $p)
        <tr style="color:black;">
            <th>{{ $p->id }}</th>
            <th>{{$p->name}}</th>
            <th>{{$p->location}}</th>
            <th>{{$p->group}}</th>
            <th>{{ $p->purchased_on }}</th>
            <th>{{ $p->cost_price }} $</th>
        
        </tr>
        @endforeach
  
        @foreach($inventory as $p)
        <tr style="color:black;">
            <th>{{ $p->id }}</th>
            <th>{{$p->name}}</th>
            <th>{{$p->location}}</th>
            <th>{{$p->group}}</th>
            <th>{{ $p->purchased_on }}</th>
            <th>{{ $p->cost_price }} $</th>
        
        </tr>
        @endforeach
  
</table>

@else
    <h4>No Records Found</h4>
@endif


@endsection