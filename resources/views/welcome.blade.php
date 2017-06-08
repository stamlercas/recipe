@extends('layouts.master')

@section('title')
	Welcome!
@endsection

@section('content')
	<div class="vertical-center">
		<h1>Welcome to {{ config('app.name') }}!</h1>
		<div class="row">
			<div class="col-md-6">
				<a href="{{ route('register') }}" class="btn btn-outline btn-block" role="button">Register</a>
	        </div>
	        <div class="col-md-6">
	        	<a href="{{ route('login') }}" class="btn btn-primary btn-block" role="button">Login</a>
	        </div>
		</div>
	</div>
@endsection