@extends('layouts.app')

@section('content')
@if (session('status'))
<div class="container compact">
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
</div>
@endif
<div class="container compact">
    <div class="panel">
        <h3 class="col-md-offset-3 col-md-8">@lang('ui.reset_password')</h3>
        <form class="form-horizontal" method="POST" action="{{ route('password.email') }}">
            {{ csrf_field() }}

            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                <label for="email" class="col-md-3 control-label">@lang('ui.email')</label>

                <div class="col-md-7">
                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                    @if ($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-6 col-md-offset-3">
                    <button type="submit" class="btn btn-primary">
                        @lang('ui.reset_password')
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
