@extends('layouts.app')

@section('content')
<div class="container">
    <div class="panel transparent">
        <div class="row">
            <div class="col-sm-offset-2 col-sm-8 text-center">
                <div class="profile shadow lg">
                    @if($user->avatar_url)
                        <img src="{{ $user->avatar_url }}" alt="">
                    @else
                        <span class="initials">{{ $user->initials }}</span>
                    @endif
                </div>
                <h3 class="col-md-offset-1 col-md-10" style="margin-top:20px; margin-bottom: 5px">{{ $user->name }}</h3>
                <p class="col-md-offset-1 col-md-10 tidbits">
                    <span class="tidbit">Level {{ $user->level->number }}</span>
                    <span class="tidbit">{{ $user->level->name }}</span>
                </p>
                <div class="row-progress-bar">
                    @php
                        $current = $user->level->xp-$user->level->last_cap;
                        $levelXp = $user->level->next_cap-$user->level->last_cap;
                    @endphp
                    <div class="row-progress" style="width:{{ $total = ($current/$levelXp)*100 }}%">
                        <span class="progress-amount">{{ $user->level->xp }}xp</span>
                    </div>
                    <span class="progress-cap">{{ $user->level->next_cap }}xp</span>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container default">
    <div class="panel">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="text-center">Palkinnot</h3>
                @foreach($user->awardsFormatted() as $sectionTitle => $content)
                <h4 class="text-center">{{ __("ui.awards.$sectionTitle") }}</h4>
                <div class="award-locker">
                @if($content->count())
                @foreach($content as $award)
                <a href="{{ route('history', array_reverse($award->name_parts)) }}?id={{ $user->id }}" class="award button shadow {{ $award->grade_string }}">
                    @foreach($award->name_parts as $namePart)
                    <span>{{ $namePart }}</span>
                    @endforeach
                </a>
                @endforeach
                @else
                <p>@lang('ui.awards.no_awards')</p>
                @endif
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<div class="container default">
    <div class="panel">
        <div class="row">
            <div class="col-md-12">
                <h3 class="text-center">Aktiviteetit</h3>
                <activity-list :user="{{ $user->id }}" v-on:show-activity="showActivity"></activity-list>
            </div>
        </div>
    </div>
</div>
@endsection