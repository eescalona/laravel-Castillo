<!-- Id Field -->
<div class="form-group col-sm-1">
    {!! Form::label('id', 'Id:') !!}
    {!! $blog->id !!}
</div>

<!-- Title Field -->
<div class="form-group col-sm-11">
    {!! Form::label('title', 'Title:') !!}
    {!! $blog->title !!}
</div>

<!-- Description Field -->
<div class="form-group col-sm-12">
    {!! Form::label('description', 'Description:') !!}
    <p>{!! $blog->description !!}</p>
</div>

<!-- Tags Field -->
<div class="form-group col-sm-6">
    {!! Form::label('tags', 'Tags:') !!}
    {!! $blog->tags !!}
</div>

<!-- Url Field -->
<div class="form-group  col-sm-6">
    {!! Form::label('url', 'Url:') !!}
    {!! $blog->url !!}
</div>

<!-- Image Id Field -->
<div class="form-group  col-sm-12">
    {!! Form::label('image', 'Imagen principal:') !!}
    {!! $blog->image->url !!}<br>
    {!! Form::image($blog->image->url) !!}
</div>


