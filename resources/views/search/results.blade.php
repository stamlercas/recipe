@extends('layouts.master')

@section('title')
Results
@endsection

@section('content')
	<h1>Search Results</h1>
	<div id="results">
		<div class="list-group">
		  <div v-for="result in results" class="list-group-item">
		    <div class="list-group-item-heading">
		    	<div class="container-fluid">
		    		<div class="row">
		    			<div class="col-xs-6 col-sm-6 col-md-8">
	    			<img :src="result.imageUrlsBySize[90]" :alt="result.recipeName" class="img img-responsive list-img" />
						<h5 class="list-title">
							<a href="#">@{{ result.recipeName }}</a>
						</h5>
						<div style="clear:both;"></div>
						<ul v-for="ingredient in result.ingredients">
							<li>@{{ ingredient }}</li>
						</ul>
  						</div>
  						<!--
  						<div class="col-xs-5 col-sm-5 col-md-8">
  					<a href="#">
  						@{{ result.recipeName }}
					</a>
  						</div>
						-->
						<div class="col-xs-4 col-sm-4 col-md-2">
	      			<small>Time: @{{ timeInMinutes(result.totalTimeInSeconds) }} min</small>
	      			<br />
	      			<span>
	      				<progress-bar v-for="(value, key) in result.flavors" :name="key" :value="value"></progress-bar>
	      			</span>
	      			<div v-for="(value, key) in result.attributes">
		      			<strong>@{{ key }}:</strong>
		      			<ul class="list-group" v-for="v in value">
		      				<li class="list-group-item">@{{ v }}</li>
		      			</ul>
	      			</div>
	      				</div>
	      			</div>
		    	</div>
	    	</div>
		    <p class="mb-1">Donec id elit non mi porta gravida at eget metus. Maecenas sed diam eget risus varius blandit.</p>
		    <small>Donec id elit non mi porta.</small>
		  </div>
	  	</div>
  	</div>

  	<script>
  		var search_results = {!! json_encode($results) !!};
  		console.log(search_results.matches);
  	</script>
  	<script src="{{ asset('js/results.js') }}"></script>
@endsection('content')