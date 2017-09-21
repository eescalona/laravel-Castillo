<!-- Id Field -->
<div class="form-group">
    {!! Form::label('id', 'Id:') !!}
    {!! $project->id !!}
</div>

<!-- Title Field -->
<div class="form-group">
    {!! Form::label('title', 'Title:') !!}
    {!! $project->title !!}
</div>

<!-- Description Field -->
<div class="form-group">
    {!! Form::label('description', 'Description:') !!}
    {!! $project->description !!}
</div>

<!-- Year Field -->
<div class="form-group">
    {!! Form::label('year', 'Year:') !!}
    {!! $project->year !!}
</div>

<!-- Category Field -->
<div class="form-group">
    {!! Form::label('category_id', 'Category:') !!}
    {!! $project->category->title !!}
</div>

<!-- Style Field -->
<div class="form-group">
    {!! Form::label('style', 'Style:') !!}
    {!! $project->style !!}
</div>

<!-- Price Field -->
<div class="form-group">
    {!! Form::label('price', 'Price:') !!}
    {!! $project->price !!}
</div>

<!-- Address Field -->
<div class="form-group">
    {!! Form::label('address', 'Address:') !!}
    {!! $project->address !!}
</div>

<!-- Image Field -->
<div class="form-group">
    {!! Form::label('image', 'Imagen principal:') !!}
    {!! $project->image->url !!}<br>
    {!! Form::image($project->image->url) !!}
</div>