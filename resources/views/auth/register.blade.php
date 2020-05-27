@extends('layout')

@section('mtitle')
    Register
@endsection

@section('content')
    <form action="{{ route('register') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" required value="{{ old('name') }}"  
                class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}">

            @if($errors->has('name'))
                <span class="invalid-feedback">
                    <strong>
                        {{ $errors->first('name') }}
                    </strong>
                </span>
            @endif
        </div>

        <div class="form-group">
            <label for="email">E-mail</label>
            <input type="email" name="email" value="{{ old('email') }}" 
                class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}">
            
            @if($errors->has('email'))
                <span class="invalid-feedback">
                    <strong>
                        {{ $errors->first('email') }}
                    </strong>
                </span>
            @endif
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" value="" 
                class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}">
            
            @if($errors->has('password'))
                <span class="invalid-feedback">
                    <strong>
                        {{ $errors->first('password') }}
                    </strong>
                </span>
            @endif
        </div>

        <div class="form-group">
            <label for="password_confirmation">Confirm Password</label>
            <input type="password" name="password_confirmation" value="" 
                required class="form-control">
        </div>

        <button type="submit" class="btn btn-primary btn-block">Register</button>
    </form>
@endsection