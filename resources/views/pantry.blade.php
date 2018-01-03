@extends ('layouts.master')

@section('title')
    My Pantry
@endsection

@section('content')
    <div id="pantry">
        <h1>{{Auth::user()->username}}'s Pantry</h1>
        <div class="row">
        	<div class="col-md-5 col-md-offset-1">
        		<div class="frame">
	        	  <h3>Add Ingredients</h3>
				  <div class="input-group">
				    <input type="text" class="form-control" id="item" placeholder="Search" v-model="searchfield" v-on:keyup.13="searchIngredients()">
				    <span class="input-group-btn">
				    	<button type="submit" class="btn btn-success" @click="searchIngredients()">
				    		<div v-if="!searching"><i class="fa fa-search"></i> Search</div>
				    		<i v-if="searching" class='fa fa-spinner fa-pulse fa-lg fa-fw'></i>
			    		</button>
		    		</span>
				  </div>
				  <search-results-table 
				  		:data="searchResults" 
				  		:columns="resultsColumns" 
				  		:actions="resultsActions" 
				  		:show-heading="false">
		  			</search-results-table>
			  	</div>
		  	</div>
	  		<div class="col-md-5">
	  			<div class="frame">
		  			<h3>
						<div class="row">
						    <div class="col-md-6">
						        Pantry
						    </div>
						    <div class="col-md-6 pull-right">
						        <div class="input-group"><input type="text" id="item" placeholder="Search" class="form-control" v-model="pantrySearchField"> <span class="input-group-btn"><button type="submit" class="btn btn-success"><div><i class="fa fa-search"></i></div> <!----></button></span></div>
						    </div>
						</div>
					</h3>
		  			<pantry-table 
		  				:data="pantry" 
	  					:columns="columns" 
	  					:filter-key="pantrySearchField" 
	  					:actions="actions"
	  					:paginate="true">
		  			</pantry-table>
	  			</div>
	  		</div>
  		</div>
    </div>


    <script>
    	var pantry = {!! json_encode($pantry) !!};
    	var pantry_delete_url = "{{ route('pantry.delete', ['pantry_id' => ''])  }}" + "/";
    	var pantry_add_url = "{{ route('pantry.add') }}";
    	var pantry_edit_url = "{{ route('pantry.edit') }}";
    	var pantry_search_url = "{{ route('pantry.search') }}";
    	var session_token = "{{ Session::token() }}";
    </script>
    <script src="{{ asset('js/pantry.js') }}"></script>
@endsection