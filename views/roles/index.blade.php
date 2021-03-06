@extends('layouts.app')

@section('title', '| Roles')

@section('content')
<div class="pull-right" style="padding-right: 120px">
    <a href="{{ route('users.index') }}" class="btn btn-default">Users</a>
    <a href="{{ route('permissions.webIndex') }}" class="btn btn-default">Web Permissions</a>
    <a href="{{ route('permissions.apiIndex') }}" class="btn btn-default">Api Permissions</a>
</div>
<div class="col-lg-10 col-lg-offset-1">
    <h1><i class="fa fa-key"></i> {{$title}} </h1>
   
    <hr>
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Role</th>
                    <th>Permissions</th>
                    <th>Operation</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($roles as $role)
                <tr>

                    <td>{{ $role->name }}</td>

                    <td>{{  $role->permissions()->pluck('name')->implode(' ') }}</td>{{-- Retrieve array of permissions associated to a role and convert to string --}}
                    <td>
                    <a href="{{ URL::to('roles/'.$role->id.'/edit') }}" class="btn btn-info pull-left" style="margin-right: 3px;">Edit</a>

                    {!! Form::open(['method' => 'DELETE', 'route' => ['roles.destroy', $role->id] ]) !!}
                    {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                    {!! Form::close() !!}

                    </td>
                </tr>
                @endforeach
            </tbody>

        </table>
    </div>

    <a href="{{ URL::to('roles/createRoleApi') }}" class="btn btn-success">Add Api Role</a>
    <a href="{{ URL::to('roles/createRoleWeb') }}" class="btn btn-success">Add Web Role</a>

</div>

@endsection
