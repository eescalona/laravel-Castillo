<!-- Title Field -->
<div class="form-group col-sm-6">
    {!! Form::label('title', 'Title:') !!}
    {!! Form::text('title', null, ['class' => 'form-control']) !!}
</div>

<!-- Image Field -->
@if(isset($promotion))
    <div class="form-group col-sm-12">
        {!! Form::label('image', 'Imagen principal:') !!}
        {!! $promotion->image->url !!}<br>
        {!! Form::image($promotion->image->url) !!}
    </div>
@else
    <!-- Image Id Field -->
    <div class="form-group col-sm-12">
        {{ Form::label('image', 'Imagen Principal',['class' => 'control-label']) }}
    </div>
    <div class="form-group col-sm-12">
        {{ Form::file('image',['class' => 'form-control'])}}
    </div>
@endif

<!-- Pdf Field -->
@if(isset($promotion))
    <div class="form-group col-sm-12">
        {!! Form::label('pdf', 'Pdf:') !!}
        {!! Form::text('pdf', null, ['class' => 'form-control']) !!}
    </div>
@else
    <!-- Image Id Field -->
    <div class="form-group col-sm-12">
        {{ Form::label('pdf', 'Pdf',['class' => 'control-label']) }}
    </div>
    <div class="form-group col-sm-12">
        {{ Form::file('filePdf',['class' => 'form-control'])}}
    </div>
@endif

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('promotions.index') !!}" class="btn btn-default">Cancel</a>
</div>
