@extends('layouts.app')

@section('css')
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="/vendor/jasekz/laradrop/css/styles.css" rel="stylesheet" type="text/css">
@endsection

@section('content')
    <section class="content-header">

        <h1>
            Project Gallery <a href="{!! route('projects.index') !!}" class="btn btn-default">Back</a>
        </h1>

    </section>
    <div class="content">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row" style="padding-left: 20px">
                    <div class="laradrop"
                         laradrop-upload-handler="{{ route('yourRoute.store') }}"
                         laradrop-file-create-handler="{{ route('yourRoute.create') }}"
                         {{--laradrop-containers="{{ route('yourRoute.containers') }}"--}}
                         {{--laradrop-file-delete-handler="{{ route('yourRoute.destroy', 0) }}"--}}
                         laradrop-csrf-token="{{ csrf_token() }}">

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.min.js" ></script>
    <script src="/vendor/jasekz/laradrop/js/enyo.dropzone.js"></script>
    <script src="/vendor/jasekz/laradrop/js/laradrop.js"></script>
    <script>
        jQuery(document).ready(function(){
            // Simplest:
            jQuery('.laradrop').laradrop();
            // With custom params:
//            jQuery('.laradrop-custom').laradrop({
//                breadCrumbRootText: 'My Root', // optional
//                actionConfirmationText: 'Sure about that?', // optional
//                onInsertCallback: function (obj){ // optional
//                    // if you need to bind the select button, implement here
//                    alert('Thumb src: '+obj.src+'. File ID: '+obj.id+'.  Please implement onInsertCallback().');
//                },
//                onErrorCallback: function(msg){ // optional
//                    // if you need an error status indicator, implement here
//                    alert('An error occured: '+msg);
//                },
//                onSuccessCallback: function(serverRes){ // optional
//                    // if you need a success status indicator, implement here
//                }
//            });
        });
    </script>
@endsection