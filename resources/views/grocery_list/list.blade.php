@extends('layouts.master')

@section('title')
	
@endsection

@section('content')
	<div id="grocery-list-app">
		<h1 class="text-center">@{{ grocery_list.name }}</h1>
	</div>

	<script>
		var grocery_list = {!! json_encode($grocery_list) !!};
		var ingredients = {!! json_encode($ingredients) !!};
	</script>
	<script src="{{ asset('js/grocery_list.js') }}"></script>
@endsection