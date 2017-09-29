@extends('layouts.app')

@section('css')
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="/vendor/jasekz/laradrop/css/styles.css" rel="stylesheet" type="text/css">
@endsection

@section('content')
    <div class="laradrop" laradrop-csrf-token="{{ csrf_token() }}"></div>

    {{--<div class="laradrop"--}}
         {{--laradrop-file-source="{{ route('yourRoute.index') }}"--}}
         {{--laradrop-upload-handler="{{ route('yourRoute.store') }}"--}}
         {{--laradrop-file-delete-handler="{{ route('yourRoute.destroy', 0) }}"--}}
         {{--laradrop-file-move-handler="{{ route('yourRoute.move') }}"--}}
         {{--laradrop-file-create-handler="{{ route('yourRoute.create') }}"--}}
         {{--laradrop-containers="{{ route('yourRoute.containers') }}"--}}
         {{--laradrop-csrf-token="{{ csrf_token() }}">--}}
    {{--</div>--}}
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


