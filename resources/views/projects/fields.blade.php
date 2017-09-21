<!-- Title Field -->
<div class="form-group col-sm-6">
    {!! Form::label('title', 'Title:') !!}
    {!! Form::text('title', null, ['class' => 'form-control']) !!}
</div>

<!-- Year Field -->
<div class="form-group col-sm-6">
    {!! Form::label('year', 'Year:') !!}
    {!! Form::number('year', 2017, ['class' => 'form-control']) !!}
</div>

<!-- Description Field -->
<div class="form-group col-sm-6">
    {!! Form::label('description', 'Description:') !!}
    {!! Form::textarea('description', null, ['class' => 'form-control']) !!}
</div>

<!-- Price Field -->
<div class="form-group col-sm-6">
    {!! Form::label('price', 'Price:') !!}
    {!! Form::text('price', null, ['class' => 'form-control']) !!}
</div>

<!-- Style Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('style', 'Style:') !!}
    {!! Form::text('style', null, ['class' => 'form-control']) !!}
</div>

<!-- Category Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('category_id', 'Category:') !!}
    {!!Form::select('category_id', array('1' => 'Cocina', '2' => 'Armario'), null) !!}
</div>

<!-- Address Field -->
<div class="form-group col-sm-6">
    {!! Form::label('address', 'Address:') !!}
    {!! Form::text('address', null, ['class' => 'form-control']) !!}
</div>

@if(isset($image))
    <!-- Address Field -->
    <div class="form-group col-sm-12">
        {{ Form::label('image', 'Imagen Principal',['class' => 'control-label']) }}
    </div>
    <div class="form-group col-sm-12">
        {{ Html::image($image->url) }}
    </div>
    <div class="form-group col-sm-12">
        {{ Form::file('image',['class' => 'form-control'])}}
    </div>
@else
    <!-- Address Field -->
    <div class="form-group col-sm-12">
        {{ Form::label('image', 'Imagen Principal ',['class' => 'control-label'])}}
        {{ Form::file('image',['class' => 'form-control'])}}
    </div>
@endif


<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('projects.index') !!}" class="btn btn-default">Cancel</a>
</div>

