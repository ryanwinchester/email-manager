

<form id="unsubscribe-form" action="{{ route('email.unsubscribe', [$email]) }}" method="POST">
    {{ csrf_field() }}
    {{ method_field('PATCH') }}
    <div class="form-group">
        <label>Unsubscribe this user from all lists</label>
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-danger btn-lg" data-loading-text="Loading..." autocomplete="off">
            <i class="fa fa-ban"></i> UNSUBSCRIBE ALL
        </button>
    </div>
</form>
