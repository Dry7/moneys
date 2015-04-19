@extends('layouts.scaffold')

@section('main')

<h1>Login</h1>

<p>{{ link_to_route('login.register', 'Регистрация') }}</p>

{{ Form::open(array('route' => 'login.index')) }}
    <ul>
        <li>
            {{ Form::label('email', 'Логин:') }}
            {{ Form::text('email') }}
        </li>

        <li>
            {{ Form::label('password', 'Пароль:') }}
            {{ Form::password('password') }}
        </li>

        <li>
            {{ Form::submit('Войти', array('class' => 'btn btn-info')) }}
        </li>
    </ul>
{{ Form::close() }}

@stop