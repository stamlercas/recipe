@extends('layouts.master')

@section('title')
Grocery Lists
@endsection

@section('content')
	<div id ="grocery-lists-app">
		<h1>Grocery Lists</h1>
		<div class="row">
			<div class="col-md-6">
				<form action="{{ route('grocery_list.create') }}" method="post">
					{{ csrf_field() }}
					<input-button 
						:name="'name'"
						:action="'Create'" 
						:icon="'fa-plus'"
						:callback-function="createGroceryList" 
						:field="name" 
						:doing-work="creating">
					</input-button>
					@if ($errors->has('name'))
                        <span class="help-block">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                    @endif
				</form>
			</div>
		</div>
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