@extends('layouts.master')

@section('title')
	Welcome!
@endsection

@section('content')
	<div class="vertical-center" style="width:100%;">
		
		<div class="container-fluid row" style="color:#eee;">
			<div class="col-sm-offset-3 col-sm-6">
				<div class="row">
					<h1 class="text-center">Rec<i class="fa fa-spoon fa-lg"></i>pr!</h1><br />
					<div class="col-xs-6">
						<a href="{{ route('register') }}" class="btn btn-success btn-block" role="button">Register</a>
			        </div>
			        <div class="col-xs-6">
			        	<a href="{{ route('login') }}" class="btn btn-primary btn-block" role="button">Login</a>
			        </div>
				</div>
			</div>
		</div>
		
	</div>
@endsection