@extends('layouts.master')

@section('title')
	Welcome!
@endsection

@section('content')
	<div class="vertical-center" style="width:100%;">
		
		<div class="row">
			<div class="col-sm-offset-3 col-sm-6">
				<div class="row">
					<h1 class="text-center">Welcome to {{ config('app.name') }}!</h1>
					<div class="col-sm-6">
						<a href="{{ route('register') }}" class="btn btn-success btn-block" role="button">Register</a>
			        </div>
			        <div class="col-sm-6">
			        	<a href="{{ route('login') }}" class="btn btn-primary btn-block" role="button">Login</a>
			        </div>
				</div>
			</div>
		</div>
		
	</div>
@endsection