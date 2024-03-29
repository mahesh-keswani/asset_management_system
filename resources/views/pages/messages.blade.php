@if(count($errors) > 0)
    @foreach($errors->all() as $error)
        <div class="alert alert-danger fade-out">
            <button type="button" class="close" data-dismiss="alert">&times;</button>

            {{ $error }}
        </div>
    @endforeach
@endif

@if(session('success'))
    <div class="alert alert-success fade-out">
        <button type="button" class="close" data-dismiss="alert">&times;</button>

        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger v">
        <button type="button" class="close" data-dismiss="alert">&times;</button>

        {{ session('error') }}
    </div>
@endif
