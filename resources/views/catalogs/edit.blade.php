@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Catalog
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($catalog, ['route' => ['catalogs.update', $catalog->id], 'method' => 'patch']) !!}

                        @include('catalogs.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection