@extends('layouts.app')

@section('title', '| Edit Permission')

@section('content')
<!-- //Main content page. -->
<div class='col-lg-4 col-lg-offset-4'>

    {{-- @include ('errors.list') --}}

    {{ Form::model($permission, array('route' => array('permissions.update', $permission->id), 'method' => 'PUT')) }}

    <div class="form-group">
        {{ Form::label('name', 'Permission Name') }}
        {{ Form::text('name', null, array('class' => 'form-control')) }}
    </div>
    <div class="form-group">
        {{ Form::label('name', 'Module Name') }}
        {{ Form::text('module', null, array('class' => 'form-control')) }}
    </div>
    <br>
    {{ Form::submit('Edit', array('class' => 'btn btn-primary')) }}

    {{ Form::close() }}

</div>
<!-- End main content page -->

@endsection
