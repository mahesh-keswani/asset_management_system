<!doctype html>
<html lang="en">
  <head>
    
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">


    <title>Pricing</title>
  </head>
  <body>

    {{-- @if(auth()->user()->role == 'Staff')
      <a href="{{ url('http://localhost/vesit/public/asset') }}" class="btn btn-primary">Register</a>
  @else 
      <a href="{{ url('http://localhost/vesit/public/payment_process') }}" class="btn btn-primary">Begin Payment Process</a>
  @endif --}}

    <div class = "container-fluid">
    <div class  ="jumbotron bg-light text-center" style =“margin:15px padding:15px">
    <h1>CHOOSE THE RIGHT PRICE FOR YOUR BUSINESS</h1>
    <p class="lead">No strings attached! Upgrade, downgrade or cancel at any time.</p>  
    </div>
    </div>

    <div class="container-flud"style="margin-left:10px">
      <div class="row">
        <div class="col-sm-4">
          <div class="card" style="width:400px">
            <div class="card-header bg-default text-center">
              <p class="lead">6-Months</p>
            </div>
          <div class="card-body text-center">
            <h5 class="card-title">Rs.6,000</h5>
            <ul class="card-text list-group"></ul>
            <li class="list-group-item">Unlimited Users</li>
            <li class="list-group-item">Standard Support</li>
            <li class="list-group-item">Premium Features </li>
          </ul>
            <a href="{{url('/pay')}}" class="btn btn-primary" style="margin-top:18px"">Continue</a>
          </div>
        </div>
    </div>
       

        <div class="col-sm-4">
          <div class="card" style="width:400px">
          <div class="card-header bg-default text-center">
          <p class="lead">1-Month</p>
          </div>
          <div class="card-body text-center">
          <h5 class="card-title">Rs.1,000</h5>
          <ul class="card-text list-group"></ul>
            <li class="list-group-item">Unlimited Users</li>
            <li class="list-group-item">Standard Support</li>
            <li class="list-group-item">Premium Features </li>
          </ul>

          <a href="{{url('/pay')}}" class="btn btn-primary" style="margin-top:18px"">Continue</a>
          </div>
          </div>
        </div>
                
      
      <div class="col-sm-4">
        <div class="card" style="width:400px">
          <div class="card-header bg-default text-center">
          <p class="lead">1-Year</p>
          </div>
          <div class="card-body text-center">
          <h5 class="card-title">Rs.10,000</h5>
          <ul class="card-text list-group"></ul>
            <li class="list-group-item">Unlimited Users</li>
            <li class="list-group-item">Standard Support</li>
            <li class="list-group-item">Premium Features </li>
          </ul>
        <a href="{{url('/pay')}}" class="btn btn-primary" style="margin-top:18px">Continue</a>
          </div>
        </div>
      </div>
    </div>          
  </div>

  <hr>

  <div class = "container-fluid">
  <div class  ="jumbotron bg-light text-center" style =“margin:15px padding:15px">
   <p class="lead">Get Your 30-day Free Trial Now</p> 
   <a href="#!" class="btn btn-outline-dark" style="margin-top:18px">Register</a>
  </div>
  </div>

  <hr>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>