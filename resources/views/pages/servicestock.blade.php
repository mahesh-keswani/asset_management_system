@extends('pages.index')

@section('content')


        <div class="container">
        <form method="POST" action ="{{ action('ServiceController@stockService') }}">
                <div class="form-group">
                    {{ csrf_field() }}
                <input type="number" value="{{ $stock_id }}" name="stock_id" hidden>
                    <label class="form-control">Type</label>
                    <select class="form-control" name="type" required>
                        <option>Repair</option>
                        <option>Standard</option>
                        <option>Warranty</option>
                        <option>Other</option>
                        
                    </select>
                </div>
                <div class="form-group">
                        <label class="form-control">Expected Complete Date</label>
                       <input type="date" class="form-control" name="expected_complete_date" required>
                </div>
               
                
                <div class="form-group">
                        <label class="form-control">Performed by</label>
                        <select class="form-control" name="performed_by" required>
                                <option>Member</option>
                                <option>Vendor</option>
                               
                         </select>
                </div>
                <div class="form-group">
                        <label class="form-control">Cost</label>
                       <input type="number" class="form-control" name="cost" required>
                </div>
                <div class="form-group">
                    <input type="submit" name="submit" value="Add Service" class="btn btn-primary btn-block">
                </div>
                    
            </form>
            

      
@endsection