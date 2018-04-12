@extends('layouts.app')

@section('content')
<div class="container compact">
    <div class="panel">
        <form class="form-horizontal" method="POST" action="{{ route('register') }}">
            {{ csrf_field() }}
            <h3 class="col-md-offset-3 col-md-7">@lang('ui.register')</h3>
            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                <label for="name" class="col-md-3 control-label">@lang('ui.name')</label>

                <div class="col-md-7">
                    <input 
                        id="name" 
                        type="text" 
                        class="form-control"
                        name="name"
                        value="{{ old('name') }}" required 
                        placeholder="@lang('ui.name')"
                        autofocus>

                    @if ($errors->has('name'))
                        <span class="help-block">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                <label for="email" class="col-md-3 control-label">@lang('ui.email')</label>

                <div class="col-md-7">
                    <input 
                        id="email" 
                        type="email" 
                        class="form-control"
                        name="email"
                        value="{{ old('email') }}" 
                        placeholder="@lang('ui.email')"
                        required>

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
                    <input 
                        id="password" 
                        type="password" 
                        class="form-control"
                        name="password"
                        placeholder="@lang('ui.password')"
                        required>

                    @if ($errors->has('password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group">
                <label for="password-confirm" class="col-md-3 control-label">@lang('ui.confirm_password')</label>

                <div class="col-md-7">
                    <input 
                        id="password-confirm" 
                        type="password" 
                        class="form-control"
                        name="password_confirmation"
                        placeholder="@lang('ui.confirm_password')"
                        required>
                </div>
            </div>

            <div class="form-group{{ $errors->has('codeword') ? ' has-error' : '' }}">
                <label for="codeword" class="col-md-3 control-label">@lang('ui.codeword')</label>

                <div class="col-md-7">
                    <input 
                        id="codeword" 
                        type="text" 
                        class="form-control"
                        name="codeword"
                        placeholder="Miikan toinen nimi" 
                        placeholder="@lang('ui.codeword')"
                        required>

                    @if ($errors->has('codeword'))
                        <span class="help-block">
                            <strong>{{ $errors->first('codeword') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-7 col-md-offset-3">
                    <button type="submit" class="btn btn-primary">
                        @lang('ui.register')
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
