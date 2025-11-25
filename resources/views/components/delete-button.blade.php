<form action="{{ $href }}" method="POST" class="d-inline-block"
id="delete-form-{{ $id }}">
 @csrf 
    @method('DELETE')
<button type="button" class="btn btn-danger btn-sm" onclick= "confirmdelete('{{ $id }}')">
 <i class="fe fe-trash" ></i>  
 </button>
</form>