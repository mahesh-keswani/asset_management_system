@extends('pages.index')

@section('content')


<div style="text-align:right;">
<a href="{{ route('export_excel_asset.excel_asset') }}" class="btn btn-success">Export To Excel</a>
</div>
    <h2><center>Assets</center></h2>
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
        @foreach($asset as $a)
            <tr>
                <th>{{ $a->id }}</th>
                <th>{{ $a->name }}</th>
                <th>{{ $a->description }}</th>
                <th>{{ $a->location }}</th>
                <th>{{ $a->group }}</th>
                <th>{{ $a->vendor }}</th>
                <th>{{ $a->cost }}</th>
            </tr>
        @endforeach
    </table>
@endsection