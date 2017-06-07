@extends('layouts.master')

@section('title')
	Welcome!
@endsection

@section('content')
	<div>
		<h1>Welcome to this app!</h1>
		<div class="row">
			<div class="col-md-6">
	            <h3>Sign Up</h3>
	            <form action="{{ route('register') }}" method="post">
	            	{{ csrf_field() }}
	                <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
	                    <label for="email">Your Email</label>
	                    <input class='form-control' type="email" name='email' id='email' value="{{ Request::old('email') }}" required />
	                    @if ($errors->has('email'))
                            <span class="help-block">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
	                </div>
	                <div class="form-group {{ $errors->has('username') ? 'has-error' : '' }}">
	                    <label for="username">Your Username</label>
	                    <input class='form-control' type="username" name='username' id='username' value="{{ Request::old('username') }}" required />
	                    @if ($errors->has('username'))
                            <span class="help-block">
                                <strong>{{ $errors->first('username') }}</strong>
                            </span>
                        @endif
	                </div>
	                <div class="form-group {{ $errors->has('first_name') ? 'has-error' : '' }}">
	                    <label for="first_name">Your First Name</label>
	                    <input class='form-control' type="text" name='first_name' id='first_name' value="{{ Request::old('first_name') }}" required />
	                    @if ($errors->has('first_name'))
                            <span class="help-block">
                                <strong>{{ $errors->first('first_name') }}</strong>
                            </span>
                        @endif
	                </div>
	                <div class="form- {{ $errors->has('last_name') ? 'has-error' : '' }}">
	                    <label for="last_name">Your Last Name</label>
	                    <input class='form-control' type="text" name='last_name' id='last_name' value="{{ Request::old('last_name') }}" required />
	                    @if ($errors->has('last_name'))
                            <span class="help-block">
                                <strong>{{ $errors->first('last_name') }}</strong>
                            </span>
                        @endif
	                </div>
	                <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
	                    <label for="password">Password</label>
	                    <input class='form-control' type='password' name='password' id='password' required />
	                    @if ($errors->has('password'))
                            <span class="help-block">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
	                </div>
	                <div class="form-group {{ $errors->has('password_confirmation') ? 'has-error' : '' }}">
                        <label for="password-confirm" >Confirm Password</label>
                        <input class="form-control" type="password" name="password_confirmation" id="password-confirm" required>
                    </div>
	                <button type='submit' class='btn btn-primary btn-block'>Submit</button>
	                <input type='hidden' name='_token' value="{{ Session::token() }}"/>
	            </form>
	        </div>
	        <div class="col-md-6">
	            <h3>Sign In</h3>
	            <form action="{{ route('login') }}" method="post">
	                <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
	                    <label for="email">Your Email</label>
	                    <input class='form-control' type="email" name='email' id='email' required />
	                </div>
	                <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
	                    <label for="password">Password</label>
	                    <input class='form-control' type='password' name='password' id='password' required />
	                </div>
	                <button type='submit' class='btn btn-primary btn-block'>Login</button>
	            </form>
	        </div>
		</div>
	</div>
@endsection