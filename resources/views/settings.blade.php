@extends('layouts.master')

@section('title')
{{ $user->username }}
@endsection

@section('content')
	<div id="settings">
	<h1>{{ $user->username }} <small><a href="{{ route('user.saved', ['username' => Auth::user()->username]) }}">saved</a></small></h1>
	<br />
		<form class="form-horizontal" action="{{ route('settings.update') }}" method="post">
			{{ csrf_field() }}
		  <div class="form-group">
		    <label for="first_name" class="col-sm-1 control-label">Name</label>
		    <div class="col-sm-5">
		      <input type="text" class="form-control" name="first_name" id="first_name" placeholder="First Name" value="{{ $user->first_name }}">
	     		@if ($errors->has('first_name'))
	                <span class="help-block alert-danger">
	                    <strong>{{ $errors->first('first_name') }}</strong>
	                </span>
	            @endif
		    </div>
		    <br class="visible-sm visible-xs hidden-md hidden-lg" />
		    <div class="col-sm-5">
		      <input type="text" class="form-control" name="last_name" id="last_name" placeholder="Last Name" value="{{ $user->last_name }}">
		      	@if ($errors->has('last_name'))
		            <span class="help-block alert-danger">
		                <strong>{{ $errors->first('last_name') }}</strong>
		            </span>
		        @endif
		    </div>
		  </div>
		  <div class="row">
		  	<div class="col-sm-offset-1">
		  		<h3>Preferences</h3>
		  	</div>
		  </div>
		  <div class="form-group">
		    <label for="allergies" class="col-sm-1 control-label">Allergies</label>
		    <div class="col-sm-10 form-inline">
		    	<allergy-checkbox class="search-checkbox" v-for="allergy in allergies" :item="allergy.longDescription" :name="allergy.id" :checked="hasAllergy(allergy)"></allergy-checkbox>
		    </div>
		  </div>
		  <div class="form-group">
		    <label for="allergies" class="col-sm-1 control-label">Diets</label>
		    <div class="col-sm-10 form-inline">
		    	<diet-radio class="search-checkbox" v-for="diet in diets" :item="diet.longDescription" :name="'diet'" :value="diet.id" :checked="hasDiet(diet)"></diet-radio>
		    </div>
		  </div>
		  <div class="form-group">
		    <div class="col-sm-offset-1 col-sm-3">
		      <button type="submit" class="btn btn-primary btn-block">Save</button>
		    </div>
		  </div>
		</form>
	</div>

	<script>
		var allergies = {!! json_encode($allergies) !!};
		var users_allergies = {!! json_encode($users_allergies) !!};
		var diets = {!! json_encode($diets) !!};
		var users_diets = {!! json_encode($users_diets) !!};
	</script>
	<script src="{{ asset('js/settings.js') }}"></script>
@endsection