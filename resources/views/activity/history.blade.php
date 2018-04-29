@extends('layouts.app')

@section('content')

<div class="container">
	<div class="panel">
		<h3 class="text-center">Tuloshistoria</h3>
		<form action="{{ action('ActivityController@historyFilter') }}" method="POST" class="col-sm-12 text-center form-inline">
			{{ csrf_field() }}
			<div class="form-group">
				<select name="year" class="form-control">
					@foreach($years as $yearOption)
					<option value="{{ $yearOption->year }}" {{ $year == $yearOption->year ? 'selected' : NULL }}>{{ $yearOption->year }}</option>
					@endforeach
				</select>
			</div>
			<div class="form-group">
				<select name="month" class="form-control">
					<option value="" {{ !$month ? 'selected' : NULL }}>-</option>
					@foreach([
						'1' => 'tammikuu',
						'2' => 'helmikuu',
						'3' => 'maaliskuu',
						'4' => 'huhtikuu',
						'5' => 'toukokuu',
						'6' => 'kesäkuu',
						'7' => 'heinäkuu',
						'8' => 'elokuu',
						'9' => 'syyskuu',
						'10' => 'lokakuu',
						'11' => 'marraskuu',
						'12' => 'joulukuu'] as $monthOption => $monthName)
					<option value="{{ $monthOption }}" {{ $month == $monthOption ? 'selected' : NULL }}>{{ $monthName }}</option>
					@endforeach
				</select>
			</div>
			<div class="form-group">
				<button type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>
			</div>
		</form>
		<table class="table table-responsive">
				<tr>
					<th>Sija</th>
					<th>Nimi</th>
					<th>Pisteet</th>
					<th>Mitali</th>
				</tr>
			@foreach($data as $user)
				<tr id="{{ $user->id }}" class="{{ Request::input('id') == $user->id ? 'info' : NULL }}">
					<td><b>{{ $loop->index+1 }}</b></td>
					<td>
						<a href="{{ route('profile', $user->id) }}">{{ $user->name }}</a>
					</td>
					<td>{{ $user->user_score }}</td>
					<td>
						@php
							$award = App\Award::userAndName($user->id, implode('-', [$month, $year]))->first();
						@endphp
						@if($award)
						<div class="award small shadow {{ $award->grade_string }}"></div>
		                @endif
					</td>
				</tr>
			@endforeach
		</table>
	</div>
</div>

@endsection