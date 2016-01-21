
<form id="change-email-form" action="{{ route('email.change', [$email]) }}" method="POST">
    {{ csrf_field() }}
    {{ method_field('PATCH') }}
    <div class="form-group">
        <label for="email" class="control-label">Change email to</label>
        <input type="email" name="new_email" id="new_email" placeholder="New email" class="form-control" required>
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-warning" data-loading-text="Loading..." autocomplete="off">
            <i class="fa fa-pencil"></i> Change
        </button>
    </div>
</form>
