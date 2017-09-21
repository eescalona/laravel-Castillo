<div class="col-md-12">
    <h1>Upload Multiple Images using dropzone.js and Laravel</h1>
{!! Form::open([ 'route' => [ 'dropzone.store' ], 'files' => true, 'enctype' => 'multipart/form-data', 'class' => 'dropzone', 'id' => 'image-upload' ]) !!}
    {{ csrf_field() }}
    <div>

    </div>
{!! Form::close() !!}
</div>
@section('scripts')

    {{--{!! Html::script('https://code.jquery.com/jquery-2.1.4.min.js') !!}--}}
    {!! Html::script('js/dropzone/min/dropzone.min.js') !!}

    <script type="text/javascript">
        Dropzone.options.imageUpload = {
            maxFilesize         :       1,
            acceptedFiles: ".jpeg,.jpg,.png,.gif",
            addRemoveLinks: true,
            dictRemoveFile: 'Remove',
            autoProcessQueue: true,
            // The setting up of the dropzone
            init:function() {
                this.on("removedfile", function(file) {
                    alert('lo vas a borrar'+file.name);
                    $.ajax({
                        type: 'POST',
                        url: "{{route('dropzone.delete')}}",
                        data: {id: file.name, _token: $('#_token').val()},
                        dataType: 'html',
                        success: function(data){
                            var rep = JSON.parse(data);
                            if(rep.code == 200)
                            {
                                photo_counter--;
                                $("#photoCounter").text( "(" + photo_counter + ")");
                            }

                        },
                        error: function(data){
                            console.log(data);
                        }
                    });
                } );
            }
        }

//        var photo_counter = 0;
//        Dropzone.options.realDropzone = {
//
//            uploadMultiple: false,
//            parallelUploads: 100,
//            maxFilesize: 8,
//            previewsContainer: '#dropzonePreview',
//            previewTemplate: document.querySelector('#preview-template').innerHTML,
//            addRemoveLinks: true,
//            dictRemoveFile: 'Remove',
//            dictFileTooBig: 'Image is bigger than 8MB',
//
//            // The setting up of the dropzone
//            init:function() {
//
//                this.on("removedfile", function(file) {
//
//                    $.ajax({
//                        type: 'POST',
//                        url: 'upload/delete',
//                        data: {id: file.name, _token: $('#csrf-token').val()},
//                        dataType: 'html',
//                        success: function(data){
//                            var rep = JSON.parse(data);
//                            if(rep.code == 200)
//                            {
//                                photo_counter--;
//                                $("#photoCounter").text( "(" + photo_counter + ")");
//                            }
//
//                        }
//                    });
//
//                } );
//            },
//            error: function(file, response) {
//                if($.type(response) === "string")
//                    var message = response; //dropzone sends it's own error messages in string
//                else
//                    var message = response.message;
//                file.previewElement.classList.add("dz-error");
//                _ref = file.previewElement.querySelectorAll("[data-dz-errormessage]");
//                _results = [];
//                for (_i = 0, _len = _ref.length; _i < _len; _i++) {
//                    node = _ref[_i];
//                    _results.push(node.textContent = message);
//                }
//                return _results;
//            },
//            success: function(file,done) {
//                photo_counter++;
//                $("#photoCounter").text( "(" + photo_counter + ")");
//            }
//        }

    </script>
@endsection
@section('css')
    {!! Html::style('js/dropzone/min/dropzone.min.css') !!}
@endsection