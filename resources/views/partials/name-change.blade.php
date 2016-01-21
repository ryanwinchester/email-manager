


<form id="change-name-form" action="{{ route('name.change', [$email]) }}" method="POST">
    {{ csrf_field() }}
    {{ method_field('PATCH') }}
    <div class="form-group">
        <input type="text" name="first_name" id="first_name" placeholder="First name" class="form-control" required>
    </div>
    <div class="form-group">
        <input type="text" name="last_name" id="last_name" placeholder="Last name" class="form-control" required>
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-warning" data-loading-text="Loading..." autocomplete="off">
            <i class="fa fa-pencil"></i> Change name
        </button>
    </div>
</form>
