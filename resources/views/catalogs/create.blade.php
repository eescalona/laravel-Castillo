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
                    {!! Form::open(['route' => 'catalogs.store','files' => true]) !!}

                        @include('catalogs.fields')

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
