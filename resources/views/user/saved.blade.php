@extends ('layouts.master')

@section('title')
    {{ Auth::user()->username }} Saved
@endsection

@section('content')
    <div id="saved">
        <h1>Saved Recipes</h1>
        <div>
        	<recipe-media-object class="frame" v-for="recipe in saved_recipes" :recipe="recipe"></recipe-media-object>
        </div>
    </div>

    <script>
    	var saved_recipes = {!! json_encode($saved_recipes) !!};

    	var recipe_url = "{{ route('recipe.get', ['recipe_id' => '']) }}"; 
    	var save_recipe_url = "{{ route('recipe.save') }}";
    	var session_token = "{{ Session::token() }}";
    </script>
    <script src="{{ asset('js/saved.js') }}"></script>
@endsection