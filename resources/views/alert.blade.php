@if (session()->has('success'))
    <div class="container">
        <div class="alert alert-success">
            {{ session()->get('success') }}
        </div>
    </div>
@endif
@if (session()->has('erorr'))
    <div class="container">
        <div class="alert alert-erorr">
            {{ session()->get('erorr') }}
        </div>
    </div>
@endif
