@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            My File
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($myFile, ['route' => ['myFiles.update', $myFile->id], 'method' => 'patch']) !!}

                        @include('my_files.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection