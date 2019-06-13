@extends('pages.index')

@section('content')

    <table class="table table-striped">.
        <tr>
            <th>Expected Complete Date</th>
            <th>Performed by</th>
            <th>Type</th>
            <th>Cost</th>
        </tr>
        <tr>
        @foreach ($services as $item)
            <tr>
                
                <th>{{ $item->expected_complete_date }}</th>
                <th>{{ $item->performed_by }}</th>
                <th>{{ $item->type }}</th>
                <th>{{ $item->cost }} $</th>
            </tr>
        @endforeach

@endsection