@extends('layouts.master')

@section('title')
Results
@endsection

@section('content')
	<div id="results">
		<h1>
			Search Results
			<button class="btn-default btn pull-right" type="submit" @click="results = sort(results, 'percentageOfIngredients')">Update</button>
		</h1>
		<div class="list-group">
		  <div v-for="result in results" class="list-group-item">
		    <div class="list-group-item-heading">
		    	<div class="container-fluid">
		    		<div class="row">
		    			<div class="col-sm-6 col-md-8">
		    			<a :href="'{{ route('recipe.get', ['inventory_id' => ''])  }}/' + result.id">
	    			<img :src="result.imageUrlsBySize[90]" :alt="result.recipeName" class="img img-responsive list-img" />
	    				</a>
						<h5 class="list-title">
							<a :href="'{{ route('recipe.get', ['inventory_id' => ''])  }}/' + result.id">@{{ result.recipeName }}</a>
							<save-icon :recipe_id="result.id" :saved="result.saved"></save-icon>
						</h5>
						<div style="clear:both;"></div>
						<div class="ingredient-list">
							<strong>Ingredients:</strong>
							<ul class="list-unstyled">
								<ingredient-list-item v-for="ingredient in result.ingredients" :ingredient="ingredient" :users_ingredients="users_ingredients"></ingredient-list-item>
							</ul>
						</div>
  						</div>
  						<!--
  						<div class="col-xs-5 col-sm-5 col-md-8">
  					<a href="#">
  						@{{ result.recipeName }}
					</a>
  						</div>
						-->
						<div class="col-sm-4 col-md-2">
					<div>You have @{{ (percentageOfIngredients(result)  * 100).toFixed(0) }}% ingredients</div>
	      			<small>Time: @{{ timeInMinutes(result.totalTimeInSeconds) }} min</small>
	      			<br />
	      			<span>
	      				<progress-bar v-for="(value, key) in result.flavors" :name="key" :value="value"></progress-bar>
	      			</span>
	      			<div class="attributes" v-for="(value, key) in result.attributes">
		      			<strong>@{{ key }}:</strong>
		      			<ul class="list-unstyled">
		      				<li v-for="v in value">@{{ v }}</li>
		      			</ul>
	      			</div>
	      				</div>
	      			</div>
		    	</div>
	    	</div>
	    	<!--
		    <p class="mb-1">Donec id elit non mi porta gravida at eget metus. Maecenas sed diam eget risus varius blandit.</p>
		    <small>Donec id elit non mi porta.</small>
		    -->
		  </div>
	  	</div>
  	</div>

  	<script>
  		var search_results = {!! json_encode($results) !!};
  		var users_ingredients = {!! json_encode($users_ingredients) !!};
  		var inventory_add_url = "{{ route('inventory.add') }}";
  		var inventory_delete_url = "{{ route('inventory.delete', ['inventory_id' => ''])  }}" + "/";
  		var save_recipe_url = "{{ route('recipe.save') }}";
  		var session_token = "{{ Session::token() }}";
  	</script>
  	<script src="{{ asset('js/results.js') }}"></script>
@endsection('content')