<?php
?>
@extends('layouts.auth')
@section('title', 'Забыли пароль?')
@section('content')
    <x-forms.auth-forms title="Забыли пароль?" action="{{route('forgot.handle')}}" method="POST">
        @csrf
        <x-forms.text-input
            name="email"
            type="email"
            placeholder="E-mail"
            required="true"
        ></x-forms.text-input>

        @error('email')
        <x-forms.error>
            {{$message}}
        </x-forms.error>
        @enderror

        <x-forms.primary-batton>
            Отправить
        </x-forms.primary-batton>

        <x-slot:socialAuth>

        </x-slot:socialAuth>

        <x-slot:buttons>
            <div class="space-y-3 mt-5">

                <div class="text-xxs md:text-xs"><a href="{{route ('login')}}" class="text-white hover:text-white/70 font-bold">Войти в аккаунт</a></div>
            </div>
        </x-slot:buttons>
    </x-forms.auth-forms>

@endsection
