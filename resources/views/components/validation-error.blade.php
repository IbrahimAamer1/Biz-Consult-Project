@if ($errors->has($field))
<div class="alert alert-danger">
  {{ $errors->first($field) }}
</div>
@endif