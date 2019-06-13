@extends('pages.index')

@section('content')


        <div class="container">
        <form method="POST" action ="{{ action('RetireController@assetRetire') }}">
                <div class="form-group">
                    {{ csrf_field() }}
                <input type="number" value="{{ $asset_id }}" name="asset_id" hidden>
                    <label class="form-control">Retire Date</label>
                    <input type="date" name="retire_date" class="form-control" required>
                </div>
                <div class="form-group">
                        <label class="form-control">Reason</label>
                       <input type="text" class="form-control" name="reason" required>
                </div>
               
                <div class="form-group">
                        <label class="form-control">Total Salvage</label>
                       <input type="number" class="form-control" name="salvage" required>
                </div>
               
                
                <div class="form-group">
                        <label class="form-control">Comments</label>
                        <input type="text" name="comments" class="form-control" required>
                </div>
                
                <div class="form-group">
                    <input type="submit" name="submit" value="Retire" class="btn btn-primary btn-block">
                </div>
                    
            </form>
            

      
@endsection