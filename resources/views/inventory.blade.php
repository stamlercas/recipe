@extends ('layouts.master')

@section('title')
    Home
@endsection

@section('content')
    <div id="inventory">
        <h1>My Pantry</h1>
        <div class="row">
        	<div class="col-md-6">
			  <div class="input-group">
			    <input type="email" class="form-control" id="item" placeholder="Add Item" v-model="addfield">
			    <span class="input-group-btn">
			    	<button type="submit" class="btn btn-success" @click="addItem()">
			    		<i class="fa fa-plus-circle"></i> Add
		    		</button>
	    		</span>
			  </div>
		  </div>
	  	</div>
	  	<div class="row">
	  		<div class="col-sm-4">
	  			<h3>Inventory</h3>
	  			<pantry-table :data="inventory" :columns="columns" :filter-key="search" :actions="actions">
	  		</div>
	  	</div>
    </div>


    <script>
    	var inventory = {{ json_encode($inventory) }};
    	var inventory_delete_url = "{{ route('inventory.delete', ['inventory_id' => ''])  }}" + "/";
    	var inventory_create_url = "{{ route('inventory.create') }}";
    </script>
    <script src="{{ asset('js/inventory.js') }}"></script>
@endsection