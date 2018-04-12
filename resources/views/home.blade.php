@extends('layouts.app')

@section('content')

<div class="container">
    <div class="panel transparent">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <top-list></top-list>
            </div>
        </div>
    </div>
</div>

<div class="container default">
    <div class="panel">
        <div class="row">
            <div class="col-md-12">
                <h3 class="text-center">Viimeisimmät päivitykset</h3>
                <activity-list></activity-list>
            </div>
        </div>
    </div>
</div>
@endsection
