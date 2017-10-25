<!-- Title Field -->
<div class="form-group col-sm-12">
    {!! Form::label('title', 'Title:') !!}
    {!! Form::text('title', null, ['class' => 'form-control']) !!}
</div>

<!-- Url Field -->
<div class="form-group col-sm-12">
    {!! Form::label('url', 'Url:') !!}
    {!! Form::text('url', null, ['class' => 'form-control']) !!}
</div>

<!-- Image Field -->
@if(isset($catalog))
    <div class="form-group col-sm-12">
        {!! Form::label('image', 'Imagen principal:') !!}
        {!! $catalog->image->url !!}<br>
        {!! Form::image($catalog->image->url) !!}
    </div>
@else
    <!-- Image Field -->
    <div class="form-group col-sm-12">
        {{ Form::label('image', 'Imagen Principal',['class' => 'control-label']) }}
    </div>
    <div class="form-group col-sm-12">
        {{ Form::file('image',['class' => 'form-control'])}}
    </div>
@endif

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('catalogs.index') !!}" class="btn btn-default">Cancel</a>
</div>
