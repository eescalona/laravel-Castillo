<!-- Title Field -->
<div class="form-group col-sm-6">
    {!! Form::label('title', 'Title:') !!}
    {!! Form::text('title', null, ['class' => 'form-control']) !!}
</div>

<!-- Url Field -->
<div class="form-group col-sm-6">
    {!! Form::label('url', 'Url:') !!}
    {!! Form::text('url', null, ['class' => 'form-control']) !!}
</div>
@if(isset($title))
<!-- Image Field -->
<div class="form-group col-sm-12">
    {{Form::label('image', 'Imagen Principal',['class' => 'control-label'])}}
    {{Form::file('image')}}

</div>
@endif
<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('catalogs.index') !!}" class="btn btn-default">Cancel</a>
</div>
