@extends ('layouts.master')

@section('title')
    My Pantry
@endsection

@section('content')
    <div id="inventory">
        <h1>My Pantry</h1>
        <div class="row">
        	<div class="col-md-6">
			  <div class="input-group">
			    <input type="text" class="form-control" id="item" placeholder="Search" v-model="searchfield" v-on:keyup.13="searchIngredients()">
			    <span class="input-group-btn">
			    	<button type="submit" class="btn btn-success" @click="searchIngredients()">
			    		<div v-if="!searching"><i class="fa fa-search"></i> Search</div>
			    		<i v-if="searching" class='fa fa-spinner fa-pulse fa-lg fa-fw'></i>
		    		</button>
	    		</span>
			  </div>
			  <search-results-table :data="searchResults" :columns="resultsColumns" :actions="resultsActions" :show-heading="false"></search-results-table>
		  	</div>
	  		<div class="col-md-4">
	  			<h3 class="visible-sm visible-xs">Inventory</h3>
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
				    <input type="text" class="form-control" v-model="editableItem.item" v-on:keyup.13="editAction('edit')" />
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
    	var inventory_add_url = "{{ route('inventory.add') }}";
    	var inventory_edit_url = "{{ route('inventory.edit') }}";
    	var inventory_search_url = "{{ route('inventory.search') }}";
    	var session_token = "{{ Session::token() }}";
    </script>
    <script src="{{ asset('js/inventory.js') }}"></script>
@endsection