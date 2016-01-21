

<form id="email-form" action="{{ route('email') }}" method="POST" class="navbar-form navbar-left" role="search">
    {{ csrf_field() }}
    <div class="form-group">
        <input type="email" name="email" id="email" placeholder="Email" class="form-control" value="{{ $email or old('email') }}" required>
    </div>
    <button type="submit" class="btn btn-default" data-loading-text="Searching..." autocomplete="off">
        <i class="fa fa-search"></i> Search
    </button>
</form>
