<?php
?>
@extends('layouts.auth')
@section('title', 'Восстановление пароля')
@section('content')
    <x-forms.auth-forms title="Восстановление пароля" action="{{route('password.reset.handle')}}" method="POST">
        @csrf
        <input type="hidden" name="token" value="{{$token}}"/>
        <x-forms.text-input
            name="email"
            type="email"
            placeholder="E-mail"
            value="{{old('email')}}"
            required="true"
        ></x-forms.text-input>

        @error('email')
        <x-forms.error>
            {{$message}}
        </x-forms.error>
        @enderror

        <x-forms.text-input
            name="password"
            type="password"
            placeholder="Пароль"
            required="true"
        ></x-forms.text-input>

        @error('password')
        <x-forms.error>
            {{$message}}
        </x-forms.error>
        @enderror

        <x-forms.text-input
            name="password_confirmation"
            type="password"
            placeholder="Повторите пароль"
            required="true"
        ></x-forms.text-input>

        @error('password_confirmation')
        <x-forms.error>
            {{$message}}
        </x-forms.error>
        @enderror

        <x-slot:socialAuth>
        </x-slot:socialAuth>

        <x-slot:buttons>
        </x-slot:buttons>

        <x-forms.primary-batton>
            Обновить пароль
        </x-forms.primary-batton>

    </x-forms.auth-forms>

@endsection
