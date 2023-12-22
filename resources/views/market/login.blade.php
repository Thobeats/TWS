@extends('layout.market_auth')

@section('title', 'Login')

@section('form')
    <form action="{{ route('login') }}" method="POST" class='p-4 border rounded mb-2'>
        @csrf
        <div class="d-flex my-4">

        </div>
        <div class="form-group">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" value="{{ old('email') }} @error('email') {{ $message }} @enderror" required class="form-control @error('email') is-invalid text-danger @enderror">
        </div>
        <div class="form-group">
            <label for="password" class="form-label">Password</label>
            <input type="password" name="password" required class="form-control @error('password') is-invalid text-danger @enderror" data-toggle="password">
            @error('password')
                <p class='py-2 text-danger'>{{$message}}</p>
            @enderror
        </div>

        <div class="form-group text-center mt-5">
            <button type="submit" class="btn home-btn-outline w-100 stext-110">Login</button>
        </div>
    </form>
    <div>
        Don't have an account?
        <a href="/register" class='btn home-btn-outline'>
            <i class="zmdi zmdi-account-add"></i>
            Sign Up
        </a>
    </div>
@endsection
