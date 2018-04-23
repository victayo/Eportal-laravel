@if(!isset($name))
    @php($name = '')
@endif
<form action="{{ $action }}" method="POST">
    {{ csrf_field() }}
    <div class="form-group">
        <label>Name</label>
        <input type="text" class="form-control" name="name" value="{{ $name }}" required>
    </div>
    <button type="submit" class="btn btn-primary">OK</button>
</form>