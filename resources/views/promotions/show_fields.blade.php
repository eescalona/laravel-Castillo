<!-- Id Field -->
<div class="form-group col-sm-1">
    {!! Form::label('id', 'Id:') !!}
    {!! $promotions->id !!}
</div>

<!-- Title Field -->
<div class="form-group col-sm-11">
    {!! Form::label('title', 'Title:') !!}
    {!! $promotions->title !!}
</div>

<!-- Pdf Field -->
<div class="form-group col-sm-12">
    {!! Form::label('pdf', 'Pdf:') !!}
    {!! $promotions->pdf !!}
</div>

<!-- Image Field -->
<div class="form-group col-sm-12">
    {!! Form::label('image', 'Imagen principal:') !!}
    {!! $promotions->image->url !!}<br>
    {!! Form::image($promotions->image->url) !!}
</div>



