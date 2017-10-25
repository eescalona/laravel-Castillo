@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Promotions
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($promotions, ['route' => ['promotions.update', $promotions->id], 'method' => 'patch']) !!}

                        @include('promotions.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection