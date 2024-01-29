@extends('auth.authApp')
@section('title')
PADSI | LOGIN
@endsection
@section('content')
<div class="login">
    <div class="logo">
        <img src="{{ asset('images/Logo.png')}}" class="img-fluid" alt="">
    </div>
    <form method="POST" action="{{route('login')}}" class="form form-control">
        @csrf
        <div class="col-lg-12 login-title">
            ADMIN PANEL
        </div>
        @if(Session::has('error'))
        <div class="alert alert-danger" role="alert" style="text-align: center">
            {{Session::get('error')}}
        </div>
        @endif
        <!-- Username Address -->
        <div class="form-outline mb-4">
            <label class="form-label" for="username">Username</label>
            <input class="form-control" id="username" type="text" name="username" placeholder="Masukkan username atau email" required autofocus>
        </div>

        <!-- Password -->
        <div class="form-outline mb-4">
            <label for="password">Password</label>
            <input id="password" class="form-control" type="password" name="password" placeholder="Masukkan password" required autocomplete="current-password"> 
        </div>

        <!-- Remember Me -->
        <div class="row mb-1">
            <div class="col d-flex justify-content-center">
                <div class="form-check">
                    <input id="remember_me" type="checkbox" class="form-check-input" name="remember">
                    <label for="remember_me" class="form-check-label">{{ __('Remember me') }}</label>
                </div>
            </div>
        </div>
        <div class="d-flex align-items-center justify-content-center mt-4">
            <button class="btn btn-success" style="margin-left: 1rem; ">Login</button>
        </div>
    </form>
</div>

<style>
    .login{
        display: flex;
        flex-direction:column;
        justify-content: center;
        align-items: center;
        height: 100vh;
        background: rgb(245, 245, 245)
    }
    .login-title {
        margin-bottom: 10px;
        text-align: center;
        font-size: 30px;
        letter-spacing: 2px;
        font-weight: bold;
        color: black;
    }
    .form{
        padding: 2rem;
        max-width: 30rem;
        display: flex;flex-direction: column;
    }
    .logo{
        max-width: 20rem;
        /* margin-bottom: 5px */
    }
    .img-fluid {
        max-width: 100%;
        height: auto;
    }
    @media only screen and (max-width: 450px){
        .form{
            max-width: 25rem;
        }
    }
</style>
@endsection