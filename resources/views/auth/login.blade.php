@extends('layouts.app')

@section('content')
<div class="container compact">
    <div class="panel">
        <form class="form-horizontal" method="POST" action="{{ route('login') }}">
            {{ csrf_field() }}
            <h3 class="col-md-offset-3 col-md-8">@lang('ui.login')</h3>
            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                <label for="email" class="col-md-3 control-label">@lang('ui.email')</label>

                <div class="col-md-7">
                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>

                    @if ($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                <label for="password" class="col-md-3 control-label">@lang('ui.password')</label>

                <div class="col-md-7">
                    <input id="password" type="password" class="form-control" name="password" required>

                    @if ($errors->has('password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-7 col-md-offset-3">
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> @lang('ui.remember_me')
                        </label>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-9 col-md-offset-3">
                    <button type="submit" class="btn btn-primary">
                        @lang('ui.login')
                    </button>

                    <a class="btn btn-link" href="{{ route('password.request') }}">
                        @lang('ui.forgot_password')
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
