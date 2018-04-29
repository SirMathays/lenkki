@extends('layouts.app')

@section('content')

<div class="container">
    <div class="panel transparent">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <top-list :list="'activity-top-list'" :activity-type="{{ $typeId }}"></top-list>
            </div>
        </div>
    </div>
</div>
@endsection
