@extends('layouts.app')

@section('content')

<div class="container">
    <div class="panel transparent">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
            	<h1 class="text-center" style="margin-top: 0;margin-bottom: 25px;">{{ $type->name }}</h1>
                <top-list :list="'activity-top-list'" :activity-type="{{ $typeId }}"></top-list>
            </div>
        </div>
    </div>
</div>
@endsection
