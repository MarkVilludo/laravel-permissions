@extends('layouts.app')

@section('title', '| Create Permission')

@section('content')

 <div class='col-lg-4 col-lg-offset-4'>

                            {{-- @include ('errors.list') --}}
                            
                            {{ Form::open(array('url' => 'permissions')) }}

                            <div class="form-group">
                                {{ Form::label('name', 'Name') }}
                                {{ Form::text('name', '', array('class' => 'form-control')) }}
                            </div>
                            <br>
                            <div class="form-group">
                                {{ Form::label('module', 'Module Name') }}
                                {{ Form::text('module', '', array('class' => 'form-control')) }}
                            </div>
                            <br>
                            <h5><b>Assign Permission to Roles (Note: You may select API or Web ONLY.)</b></h5>
                                <div class="row">
                                    <div class='col-lg-6 form-group'>
                                        <label>(WEB)</label> <br>
                                        @foreach ($rolesWeb as $roleWeb)
                                            {{ Form::checkbox('roles[]',  $roleWeb->id) }}
                                            {{ Form::label($roleWeb->name, ucfirst($roleWeb->name)) }}<br>

                                        @endforeach
                                    </div>
                                    <div class='col-lg-6 form-group'>
                                        <label>(API)</label> <br>
                                        @foreach ($rolesApi as $roleApi)
                                            {{ Form::checkbox('roles[]',  $roleApi->id) }}
                                            {{ Form::label($roleApi->name, ucfirst($roleApi->name)) }}<br>

                                        @endforeach
                                    </div>
                                </div>
                            <br>
                            {{ Form::submit('Add', array('class' => 'btn btn-primary')) }}

                            {{ Form::close() }}

                        </div>
@endsection
