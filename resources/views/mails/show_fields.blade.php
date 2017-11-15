<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Name:') !!}
    {!! $mail->name !!}
</div>

<!-- Created At Field -->
<div class="form-group col-sm-6">
    {!! Form::label('created_at', 'Fecha:') !!}
    {!! $mail->created_at !!}
</div>

<!-- Mail Field -->
<div class="form-group col-sm-6">
    {!! Form::label('mail', 'Mail:') !!}
    {!! $mail->mail !!}
</div>

<!-- Phone Field -->
<div class="form-group col-sm-6">
    {!! Form::label('phone', 'Phone:') !!}
    {!! $mail->phone !!}
</div>

<!-- Subject Field -->
<div class="form-group col-sm-12">
    {!! Form::label('subject', 'Asunto') !!}
    <p>{!! $mail->subject !!}</p>
</div>

<!-- Body Field -->
<div class="form-group col-sm-12">
    {!! Form::label('body', 'Mensaje') !!}
    <p>{!! $mail->body !!}</p>
</div>




