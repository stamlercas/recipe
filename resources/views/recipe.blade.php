@extends('layouts.master')

@section('title')
@{{ recipe.name }}
@endsection

@section('content')

<div id="recipe">
	<div class="row">
		<div class="col-md-4" style=";margin-top:22px;">
			<img :src="recipe.images.hostedLargeUrl" class="img img-respsonsive" :alt="recipe.name + ' image'" />
		</div>
		<div class="col-md-6">
			<h1 style="margin-bottom:0;">@{{ recipe.name }}</h1>
			<div>
				Provided by 
				<a :href="recipe.sourceSiteUrl" target="_blank">
					@{{ recipe.source.sourceDisplayName }}
				</a>
			</div>
		</div>
	</div>
	<h2>Ingredients</h2>
	<div class="row" style="margin-bottom:10px;">
		<div class="col-sm-4" style="padding:5px;" v-for="ingredient in recipe.ingredientLines">@{{ ingredient }}</div>
	</div>
	<div v-if="recipe.ingredients.length > 0">
		<h4>You still need:</h4>
		<ul class="list-unstyled" v-for="ingredient in recipe.ingredients">
			<ingredient-list-item :ingredient="ingredient" :users_ingredients="users_ingredients" :show-when-have="false"></ingredient-list-item>
	</div>
	<div class="row">
		<div class="col-md-3">
			<a role="button" class="btn btn-primary btn-block" :href="recipe.source.sourceRecipeUrl" target="_blank">
				Directions
			</a>
		</div>
		<div class="col-md-3">
			@if ($grocery_list == null)
				<form action="{{ route('grocery_list.create') }}" method="post">
				{{ csrf_field() }}
				<input hidden name="id" value="{{ $recipe->id }}" />
				<input hidden name="name" value="{{ $recipe->name }}" />
				<button class="btn btn-primary btn-block" value="Submit" @click="makeGroceryList()">Make Grocery List</button>
				</form>
			@else
				<a class="btn btn-primary btn-block" href="{{ route('grocery_list.get', 
					['username' => Auth::user()->username, 'grocery_list_slug' => $grocery_list->slug]) }}" role="button">View Grocery List</a>
			@endif
		</div>
		<div class="col-md-3">
			<button class="btn btn-success btn-block" value="Submit">I Made It!</button>
		</div>
	</div>
</div>

<script>
	var recipe = {!! json_encode($recipe) !!};
	var users_ingredients = {!! json_encode($users_ingredients) !!};
</script>
<script src="{{ asset('js/recipe.js') }}"></script>

@endsection