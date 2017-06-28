@extends('layouts.master')

@section('title')
Grocery Lists
@endsection

@section('content')
	<div id ="grocery-lists-app">
		<h1>Grocery Lists</h1>
		<grocery-list-table 
			:data="grocery_lists" 
			:columns="columns"
			:actions="actions">
		</grocery-list-table>
	</div>
	<script>
		var grocery_lists = {!! json_encode($grocery_lists) !!};
	</script>
	<script src="{{ asset('js/grocery_lists.js') }}"></script>
@endsection