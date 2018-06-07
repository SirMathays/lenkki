@extends('layouts.app')

@section('content')
<div class="container compact">
    <div class="panel">
    	<form action="{{ action('ActivityController@save') }}" method="POST" class="form-horizontal" enctype="multipart/form-data">
    		{{ csrf_field() }}
            
            <div class="row">
                @if($edit = !empty($activity))
                <input type="hidden" name="activity_id" value="{{ $activity->id }}">
                    <h3 class="col-md-offset-4 col-md-8">@lang('ui.activity.singular', ['id' => $activity->id])</h3>
                @else
                    <h3 class="col-md-offset-4 col-md-8">@lang('ui.activity.new')</h3>
                @endif
            </div>

            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                <label for="name" class="col-md-4 control-label">@lang('ui.activity.name')</label>
                <div class="col-md-6">
                    <input 
                        type="text" 
                        name="name" 
                        class="form-control"
                        value="{{ old('name') ?? $edit ? $activity->name : NULL }}">
                </div>
            </div>

            <div class="form-group{{ $errors->has('type_id') ? ' has-error' : '' }}">
                <label for="type_id" class="col-md-4 control-label">@lang('ui.activity.type_id')</label>

                <div class="col-md-6">
                	<div class="input-group">
    					<select name="type_id" id="type_id" class="form-control">
    						@foreach(App\ActivityType::pluck('name', 'id') as $id => $name)
                            <option value="{{ $id }}"
                            @if(old('type_id') == $id || (!old('type_id') && $edit && $activity->type_id == $id))
                            selected
                            @endif
                            >{{ $name }}</option>
                            @endforeach
    					</select>
                    </div>

                    @if($errors->has('type_id'))
                        <span class="help-block">
                            <strong>{{ $errors->first('type_id') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group{{ $errors->has('performed_at') ? ' has-error' : '' }}">
                <label for="performed_at" class="col-md-4 control-label">@lang('ui.activity.performed_at')</label>

                <div class="col-md-6">
                    <input 
                        type="date"
                        name="performed_at"
                        class="form-control"
                        value="{{ old('performed_at') ?? $activity->performed ?? Carbon\Carbon::now()->format('Y-m-d') }}"
                        max="{{ Carbon\Carbon::now()->format('Y-m-d') }}"
                        required>

                    @if($errors->has('performed_at'))
                        <span class="help-block">
                            <strong>{{ $errors->first('performed_at') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            
            <div class="form-group{{ $errors->has('km') ? ' has-error' : '' }}">
                <label for="km" class="col-md-4 control-label">@lang('ui.activity.km')</label>

                <div class="col-md-6">
                    <div class="input-group">
                        <input 
                            id="km" 
                            type="number" 
                            class="form-control" 
                            name="km" 
                            value="{{ old('km') ?? $edit ? $activity->km : NULL }}" 
                            step=".01" 
                            required 
                            autofocus>
                        <span class="input-group-addon">
                            km
                        </span>
                    </div>

                    @if($errors->has('km'))
                        <span class="help-block">
                            <strong>{{ $errors->first('km') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group{{ $errors->has('duration') ? ' has-error' : '' }}">
                <label for="duration" class="col-md-4 control-label">@lang('ui.activity.duration')</label>

                <div class="col-md-6">
                    <div class="input-group">
                        <input 
                            id="duration" 
                            type="number" 
                            class="form-control" 
                            name="duration" 
                            value="{{ old('duration') ?? $edit ? $activity->duration : NULL }}" 
                            required>
                        <span class="input-group-addon">
                            min
                        </span>
                    </div>

                    @if($errors->has('duration'))
                        <span class="help-block">
                            <strong>{{ $errors->first('duration') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group{{ $errors->has('image') ? ' has-error' : '' }}">
                <label for="image" class="col-md-4 control-label">@lang('ui.image')</label>

                <div class="col-md-6">
                    <label class="btn btn-primary" for="image">
                        <input id="image" type="file" name="image" style="display:none" 
                            onchange="$('#upload-file-info').html(this.files[0].name)">
                            Lataa
                    </label>
                    <span class='label label-info' id="upload-file-info"></span>

                    @if($errors->has('image'))
                        <span class="help-block">
                            <strong>{{ $errors->first('image') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <hr>

            <div class="form-group">
                <div class="col-md-6 col-md-offset-4">
                    <button type="submit" class="btn btn-primary">
                        @lang('ui.save')
                    </button>
                    @if($edit)
                        <button type="submit" class="btn btn-danger" form="delete">
                            @lang('ui.delete')
                        </button>
                    @endif
                </div>
            </div>
    	</form>

        @if($edit)
            <form action="{{ action('ActivityController@delete', $activity->id) }}" method="POST" id="delete" style="display:hidden">
                {{ csrf_field() }}
            </form>
        @endif
    </div>
</div>
@endsection