@extends('pages.index')

@section('content')
<a href="{{ url('dynamicPdfAsset/pdf') }}" class="btn btn-danger pull-right">convert To PDF</a>
    
    <h3><center>Assets</center></h3>
    <table class="table table-striped">
        <tr>
            <th>Id</th>
            <th>Name</th>
            <th>Description</th>
            <th>Location</th>
            <th>Group</th>
            <th>Vendor</th>
            <th>Cost</th>
        </tr>
        @foreach($assets as $asset)
            <tr>
                <th>{{ $asset->id }}</th>
                <th>{{ $asset->name }}</th>
                <th>{{ $asset->description }}</th>
                <th>{{ $asset->location }}</th>
                <th>{{ $asset->group }}</th>
                <th>{{ $asset->vendor }}</th>
                <th>{{ $asset->cost_price }}
        @endforeach
    </table>

@endsection