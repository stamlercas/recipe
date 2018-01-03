@extends('layouts.master')

@section('title')

@endsection

@section('content')
<div id="recipe-made">
	<div class="row">
		<div class="col-md-offset-3 col-md-6">
			<h3>Would you like to make any changes to the ingredients used?</h3>
			<ul class="list-unstyled" v-for="ingredient in ingredients">
				<ingredient-list-item :ingredient="ingredient" :users_ingredients="users_ingredients"></ingredient-list-item>
			</ul>
			<a href="{{ route('home') }}" role="button" class="btn btn-success btn-block">Finish</a>
		</div>
	</div>
</div>

<script>
	var ingredients = {!! json_encode($ingredients) !!};
	var users_ingredients = {!! json_encode($users_ingredients) !!};

	var pantry_add_url = "{{ route('pantry.add') }}";
	var pantry_delete_url = "{{ route('pantry.delete', ['pantry_id' => '']) }}" + "/";
</script>
<script src="{{ asset('js/recipe_made.js') }}"></script>
@endsection
