@extends('layouts.app')

@section('title', '| Edit Role')

@section('content')

<div class='col-lg-4 col-lg-offset-4'>
    <h1><i class='fa fa-key'></i> Edit Role: {{$role->name}}</h1>
    <hr>
    {{-- @include ('errors.list')
 --}}
    {{ Form::model($role, array('route' => array('roles.update', $role->id), 'method' => 'PUT')) }}

    <div class="form-group">
        {{ Form::label('name', 'Role Name') }}
        {{ Form::text('name', null, array('class' => 'form-control')) }}
    </div>

    <h5><b>Assign Permissions</b></h5>
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
                    {{Form::checkbox('permissions[]',  $permission['id'], $role->permissions) }}
                </div>
            @endforeach
        </div>
    @endforeach
    <br>
    {{ Form::submit('Edit', array('class' => 'btn btn-primary')) }}

    {{ Form::close() }}    
</div>

@endsection
