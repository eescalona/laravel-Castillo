<!-- Id Field -->
<div class="form-group col-sm-1">
    {!! Form::label('id', 'Id:') !!}
    {!! $project->id !!}
</div>

<!-- Title Field -->
<div class="form-group col-sm-11">
    {!! Form::label('title', 'Title:') !!}
    {!! $project->title !!}
</div>

<!-- Description Field -->
<div class="form-group col-sm-10">
    {!! Form::label('description', 'Description:') !!}
    {!! $project->description !!}
</div>

<!-- Year Field -->
<div class="form-group col-sm-2">
    {!! Form::label('year', 'Year:') !!}
    {!! $project->year !!}
</div>

<!-- Category Field -->
<div class="form-group col-sm-6">
    {!! Form::label('category_id', 'Category:') !!}
    {!! $project->category->title !!}
</div>

<!-- Style Field -->
<div class="form-group col-sm-6">
    {!! Form::label('style', 'Style:') !!}
    {!! $project->style !!}
</div>

<!-- Price Field -->
<div class="form-group col-sm-6">
    {!! Form::label('price', 'Price:') !!}
    {!! $project->price !!}
</div>

<!-- Address Field -->
<div class="form-group col-sm-6">
    {!! Form::label('address', 'Address:') !!}
    {!! $project->address !!}
</div>

<!-- Image Field -->
<div class="form-group col-sm-12">
    {!! Form::label('image', 'Imagen principal:') !!}
    {!! $project->image->url !!}<br>
    {!! Form::image($project->image->url) !!}
</div>