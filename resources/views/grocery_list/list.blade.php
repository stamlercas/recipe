@extends('layouts.master')

@section('title')
	
@endsection

@section('content')
	<div id="grocery-list-app">
		<div class="row">
			<div class="col-md-offset-3 col-md-6" style="padding:15px;">
				<div class="frame">
					<h1 class="text-center">@{{ grocery_list.name }}</h1>
					<div class="pull-right">You have @{{ ingredients.length }} item<span v-if="ingredients.length != 1">s</span> in your grocery list.
					</div>
					<div style="clear:both;"></div>
					<ul class="list-unstyled">
						<ingredient-list-item v-for="ingredient in ingredients" :ingredient="ingredient" :users_ingredients="users_ingredients"></ingredient-list-item>
					</ul>
					<div class="text-center" v-if="ingredients.length == 0">
						<h3>You don't have any items in your grocery list.  Why don't you try adding some?</h3>
					</div>
					<div class="text-center">
						<button class="btn-primary btn" type="submit" @click="showModal = true"><i class="fa fa-plus"></i> Add Item</button>
					</div>
					<br />
					<div class="text-center">
						<a v-if="grocery_list.recipe_id != null" class="btn btn-primary btn-block" href="{{ route('recipe.get', ['recipe_id' => $grocery_list->recipe_id ]) }}" role="button">View Recipe</a>
						<button class="btn btn-danger btn-block" type="submit" @click="close()">Close List</button>
						<form id="close-grocery-list" method="post" action="{{ route('grocery_list.close', ['username' => Auth::user()->username, 'grocery_list_slug' => $grocery_list->slug]) }}">
							{{ csrf_field() }}
						</form>
					</div>
				</div>
			</div>
		</div>
		<modal v-if="showModal">
			<h3 slot="header">Add Item</h3>
			<div slot="body">
				<input-button
					:action="'Search'" 
					:icon="'fa-search'"
					:callback-function="search"
					:doing-work="searching">
				</input-button>
				<search-results-table 
			  		:data="searchResults" 
			  		:columns="resultsColumns" 
			  		:actions="resultsActions" 
			  		:show-heading="false">
	  			</search-results-table>
				
			</div>
			<div slot="footer">
				<button class="btn-danger btn" type="submit" @click="closeModal()">Close</button>
			</div>
		</modal>
	</div>

	<script>
		var grocery_list = {!! json_encode($grocery_list) !!};
		var ingredients = {!! json_encode($ingredients) !!};
		var users_ingredients = {!! json_encode($users_ingredients) !!};

		var inventory_search_url = "{{ route('inventory.search') }}";
		var grocery_list_add_url = "{{ route('grocery_list.add', ['username' => Auth::user()->username, 'grocery_list_slug' => $grocery_list->slug]) }}";
		var inventory_add_url = "{{ route('inventory.add') }}";
		var inventory_delete_url = "{{ route('inventory.delete', ['inventory_id' => '']) }}" + "/";

		var session_token = "{{ Session::token() }}";
	</script>
	<script src="{{ asset('js/grocery_list.js') }}"></script>
@endsection