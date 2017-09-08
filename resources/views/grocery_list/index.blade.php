@extends('layouts.master')

@section('title')
Grocery Lists
@endsection

@section('content')
	<div id ="grocery-lists-app">
		<h1>Grocery Lists</h1>
		<div class="row">
			<div class="col-md-6">
				<form id='create-grocery-list-form' action="{{ route('grocery_list.create') }}" method="post">
					{{ csrf_field() }}
					<input-button 
						:name="'name'"
						:action="'Create'" 
						:icon="'fa-plus'"
						:callback-function="createGroceryList"
						:doing-work="creating">
					</input-button>
					@if ($errors->has('name'))
                        <span class="help-block">
                            <strong class="text-danger">{{ $errors->first('name') }}</strong>
                        </span>
                    @endif
				</form>
			</div>
		</div>
		<grocery-list-table class="frame"
			:data="grocery_lists" 
			:columns="columns"
			:actions="actions">
		</grocery-list-table>
		<h3 v-if="grocery_lists.length == 0" class="text-center">
			You don't seem to have any grocery lists open.
		</h3>
	</div>
	<script>
		var grocery_lists = {!! json_encode($grocery_lists) !!};

		var grocery_list_url = "{{ route('grocery_list.get', ['username' => Auth::user()->username, 'grocery_list_slug' => '']) }}" + "/";

		var session_token = "{{ Session::token() }}";
	</script>
	<script src="{{ asset('js/grocery_lists.js') }}"></script>
@endsection