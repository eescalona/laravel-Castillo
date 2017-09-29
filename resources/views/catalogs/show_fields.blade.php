<!-- Id Field -->
<div class="form-group col-sm-1">
    {!! Form::label('id', 'Id:') !!}
    {!! $catalog->id !!}
</div>

<!-- Title Field -->
<div class="form-group col-sm-11">
    {!! Form::label('title', 'Title:') !!}
    {!! $catalog->title !!}
</div>

<!-- Url Field -->
<div class="form-group">
    {!! Form::label('url', 'Url:') !!}
    {!! $catalog->url !!}
</div>

<!-- Image Field -->
<div class="form-group">
    {!! Form::label('image', 'Imagen principal:') !!}
    {!! $catalog->image->url !!}<br>
    {!! Form::image($catalog->image->url) !!}
</div>