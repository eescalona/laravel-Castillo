@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Project Gallery
        </h1>
    </section>
    <div class="content">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row" style="padding-left: 20px">
                    mi gallery xa eliminar
                    <?php $id = 4?>
                    @include('my_files.parts.dropzone')
                    <a href="{!! route('projects.index') !!}" class="btn btn-default">Back</a>
                </div>
            </div>
        </div>
    </div>
@endsection
