@extends('layouts.app')

@section('title', '| Add Role')

@section('content')

<div class='col-lg-4 col-lg-offset-4'>

    <h1><i class='fa fa-key'></i> Add Role</h1>
    <hr>
    {{-- @include ('errors.list') --}}

    {{ Form::open(array('url' => 'roles')) }}

    <div class="form-group">
        {{ Form::label('name', 'Name') }}
        {{ Form::text('name', null, array('class' => 'form-control')) }}
    </div>

    <h5><b>Assign Permissions</b></h5>

    <div class='form-group'>
        @foreach ($permissions as $permissionModule)
            <div class="col-md-12">
                {{Form::checkbox('') }}
                {{Form::label($permissionModule['module'], ucfirst($permissionModule['module'])) }}<br>
               
            </div>
            <div class="col-md-12">
                @foreach ($permissionModule['module_functions'] as $permission)
                    <div class="col-md-9">
                        {{Form::label($permission['name'], ucfirst($permission['name'])) }}<br>
                    </div>
                    <div class="col-md-3">
                        {{Form::checkbox('permissions[]',  $permission['id']) }}
                    </div>
                @endforeach
            </div>
        @endforeach
    </div>

    {{ Form::submit('Add', array('class' => 'btn btn-primary')) }}

    {{ Form::close() }}

</div>

@endsection
