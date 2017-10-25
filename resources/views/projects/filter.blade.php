<div class="form-group col-sm-4">
<a href="{{ route('projects.filter','cocinas') }}" class="btn btn-default" >Cocinas</a>
<a href="{{ route('projects.filter','armarios') }}" class="btn btn-default">Armarios</a>
<a href="{{ route('projects.index') }}" class="btn btn-default">Todos</a>
</div>
{{ $projects->links() }}
