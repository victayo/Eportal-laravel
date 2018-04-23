@if(!isset($name))
    @php($name = '')
@endif
<form action="{{ $action }}" method="POST" class="form-horizontal form-label-left">
    {{ csrf_field() }}
    <div class="form-group">
        <label class="control-label">Name</label>
        <input type="text" class="form-control" name="name" value="{{ $name }}" required>
    </div>
    <button type="submit" class="btn btn-primary">OK</button>
</form>