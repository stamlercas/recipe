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
			    <input type="email" class="form-control" id="item" placeholder="Add Item" v-model="addfield" v-on:keyup.13="addItem()">
			    <span class="input-group-btn">
			    	<button type="submit" class="btn btn-success" @click="addItem()">
			    		<div v-if="!adding"><i class="fa fa-plus-circle"></i> Add</div>
			    		<i v-if="adding" class='fa fa-spinner fa-pulse fa-lg fa-fw'></i>
		    		</button>
	    		</span>
			  </div>
		  </div>
	  	</div>
	  	<div class="row">
	  		<div class="col-md-4">
	  			<h3>Inventory</h3>
	  			<pantry-table :data="inventory" :columns="columns" :filter-key="search" :actions="actions"></pantry-table>
	  		</div>
	  	</div>
  		<edit-modal v-if="showEditModal" @close="showEditModal = false">
		    <!--
		      you can use custom content here to overwrite
		      default content
	    	-->
	    	<h3 slot="header">Edit</h3>
	    	<div slot="body">
	    		<div class="input-group">
				    <input type="email" class="form-control" v-model="editableItem.item" v-on:keyup.13="editAction('edit')" />
			  	</div>
	    	</div>
	    	<div slot="footer">
	    		<button class="btn btn-primary" @click="editAction('edit')">
                	Save
              	</button>
              	<button class="btn btn-outline" @click="editAction('close')">
                	Close
              	</button>
	    	</div>
	  	</edit-modal>
    </div>


    <script>
    	var inventory = {!! json_encode($inventory) !!};
    	var inventory_delete_url = "{{ route('inventory.delete', ['inventory_id' => ''])  }}" + "/";
    	var inventory_create_url = "{{ route('inventory.create') }}";
    	var inventory_edit_url = "{{ route('inventory.edit') }}";
    	var session_token = "{{ Session::token() }}";
    </script>
    <script src="{{ asset('js/inventory.js') }}"></script>
@endsection