@extends('layouts.app')

@section('content')
<div class="container compact">
    <div class="panel">
        <form action="{{ action('ActivityController@stravaSubscription') }}" method="POST">
            {{ csrf_field() }}
            <button type="submit">save</button>
        </form>
        <form action="{{ action('UserController@save') }}" method="POST" class="form-horizontal" enctype="multipart/form-data">
    		{{ csrf_field() }}

            <input type="hidden" name="id" value="{{ $user->id }}">
            <div class="row">
                <h3 class="col-md-offset-4 col-md-8">@lang('ui.user.edit')</h3>
            </div>
            
    		<div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                <label for="name" class="col-md-4 control-label">@lang('ui.name')</label>

                <div class="col-md-6">
                    <input 
                        type="text"
                        name="name"
                        class="form-control"
                        value="{{ old('name') ?? $user->name }}"
                        required>

                    @if($errors->has('name'))
                        <span class="help-block">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                <label for="email" class="col-md-4 control-label">@lang('ui.email')</label>

                <div class="col-md-6">
                    <input 
                        type="email"
                        name="email"
                        class="form-control"
                        value="{{ old('email') ?? $user->email }}"
                        required>

                    @if($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group{{ $errors->has('avatar') ? ' has-error' : '' }}">
                <label for="avatar" class="col-md-4 control-label">@lang('ui.avatar')</label>

                <div class="col-md-6">
                    <label class="btn btn-primary" for="avatar">
                        <input id="avatar" type="file" name="avatar" style="display:none" 
                            onchange="$('#upload-file-info').html(this.files[0].name)">
                            <i class="fa fa-upload"></i> Lataa
                    </label>
                    <span class='label label-info' id="upload-file-info"></span>

                    @if($errors->has('avatar'))
                        <span class="help-block">
                            <strong>{{ $errors->first('avatar') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-6 col-md-offset-4">
                    <hr>
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-save"></i> @lang('ui.save')
                    </button>
                </div>
            </div>
        	
        </form>
    </div>
</div>
@endsection