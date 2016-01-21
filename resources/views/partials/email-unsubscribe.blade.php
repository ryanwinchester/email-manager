

<form id="unsubscribe-form" action="{{ route('email.unsubscribe', [$email]) }}" method="POST">
    {{ csrf_field() }}
    {{ method_field('PATCH') }}
    <div class="form-group">
        <input type="email" value="{{ $email }}" disabled class="form-control disabled">
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-danger" data-loading-text="Loading..." autocomplete="off">
            <i class="fa fa-ban"></i> UNSUBSCRIBE ALL
        </button>
    </div>
</form>
