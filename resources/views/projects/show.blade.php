@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Project
        </h1>
    </section>
    <div class="content">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row" style="padding-left: 20px">
                    <a href="{!! route('projects.index') !!}" class="btn btn-default">Back</a>
                    @include('projects.show_fields')
                    <form action="" method="post" enctype="multipart/form-data">
                        <input type="file" name="file" />
                    </form>
                    <form action="/file-upload" class="dropzone" id="my-awesome-dropzone">
                        <div class="dz-preview dz-file-preview">
                            <div class="dz-details">
                                <div class="dz-filename"><span data-dz-name></span></div>
                                <div class="dz-size" data-dz-size></div>
                                <img data-dz-thumbnail />
                            </div>
                            <div class="dz-progress"><span class="dz-upload" data-dz-uploadprogress></span></div>
                            <div class="dz-success-mark"><span>✔</span></div>
                            <div class="dz-error-mark"><span>✘</span></div>
                            <div class="dz-error-message"><span data-dz-errormessage></span></div>
                        </div>
                    </form>

                    @section('scripts')
                        {!! Html::script('js/dropzone/min/dropzone.min.js') !!}
                    @endsection

                    @section('css')
                        {!! Html::style('js/dropzone/min/dropzone.min.css') !!}
                    @endsection

                </div>
            </div>
        </div>
    </div>
@endsection
