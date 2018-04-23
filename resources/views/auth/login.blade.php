@extends('layouts.app')

@section('content')
<div class="container compact login">
    <form class="form-horizontal" method="POST" action="{{ route('login') }}">
        @csrf
        <h3 class="col-md-offset-2 col-md-8 text-center">@lang('ui.login')</h3>
        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
            <div class="col-md-8 col-md-offset-2">
                <input id="email" type="email" placeholder="@lang('ui.email')" class="form-control" name="email" value="{{ old('email') }}" required autofocus>

                @if ($errors->has('email'))
                    <span class="help-block">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
            <div class="col-md-8 col-md-offset-2">
                <input id="password" type="password" placeholder="@lang('ui.password')" class="form-control" name="password" required>

                @if ($errors->has('password'))
                    <span class="help-block">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-8 col-md-offset-2 text-center">
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> @lang('ui.remember_me')
                    </label>
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-8 col-md-offset-2 text-center">
                <button type="submit" class="btn btn-default">
                    @lang('ui.login')
                </button>
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-8 col-md-offset-2 text-center">
                <a class="btn btn-link btn-link-white" href="{{ route('password.request') }}">
                    @lang('ui.forgot_password')
                </a>
            </div>
        </div>
    </form>
</div>
@endsection
