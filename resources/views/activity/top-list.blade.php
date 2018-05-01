@extends('layouts.app')

@section('content')

<div class="container">
    <div class="panel transparent">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
            	<h1 class="text-center" style="margin-top: 0;margin-bottom: 25px;">{{ $type->name }}</h1>
                <top-list 
                    :month="'{{ $month }}'" 
                    :year="'{{ $year }}'" 
                    :list="'activity-top-list'" 
                    :activity-type="{{ $typeId }}"></top-list>
            </div>
        </div>
    </div>
</div>

<div class="container default">
    <div class="panel">
        <div class="row">
            <div class="col-md-12">
                <h3 class="text-center">Viimeisimmät päivitykset</h3>
                <activity-list :activity-type="{{ $typeId }}" v-on:show-activity="showActivity"></activity-list>
            </div>
        </div>
    </div>
</div>
@endsection
