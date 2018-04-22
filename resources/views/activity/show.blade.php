@extends('layouts.app')

@section('content')
<div class="container compact">
    <div class="panel">
        <div class="row">
            @if($activity->image)
                <img src="{{ $activity->image_url }}" class="image-banner">
            @endif
            <h3 class="col-md-offset-1 col-md-10 tidbits">
                <span class="tidbit"><b>{{ $activity->activityType->name }}</b></span>
                <span>{{ $activity->performed_at->format('j.n.Y') }}</span>
                <span class="xp pull-right">+{{ $activity->xp }} xp</span>
            </h3>
            <div class="col-md-offset-1 col-md-10">
                <p><b>Suorittaja:</b> <a href="{{ route('profile', $activity->user->id) }}">{{ $activity->user->name }}</a></p>
                <p><b>@lang('ui.activity.km'):</b> {{ $activity->km }}km</p>
                <p><b>@lang('ui.activity.duration'):</b> {{ $activity->duration }}min</p>
            </div>
            @if($activity->userHasRights())
            <div class="col-md-offset-1 col-md-10 text-right">
                <div class="form-group">
                    <a href="{{ route('editActivity', $activity->id) }}" class="btn btn-primary">
                        <i class="fa fa-pencil"></i> @lang('ui.edit')
                    </a>
                    <button type="submit" class="btn btn-danger" form="delete">
                        <i class="fa fa-trash"></i> @lang('ui.delete')
                    </button>
                    <form action="{{ action('ActivityController@delete') }}" method="POST" id="delete" style="display:hidden">
                        {{ csrf_field() }}
                        <input type="hidden" name="id" value="{{ $activity->id }}">
                    </form>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection