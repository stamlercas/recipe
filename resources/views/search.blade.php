@extends ('layouts.master')

@section('title')
    Search
@endsection

@section('content')
    <div id="search">
        <h1>Search</h1>
        <form>
	        <div class="row">
	        	<div class="col-md-8 col-md-offset-2">
			        <div class="row">
						<div class="col-md-10 col-md-offset-1">
							<div class="form-group">
							    <input type="keywords" class="form-control" id="keywords" placeholder="Keywords">
						  	</div>
						</div>
					</div>
		        	<div>
		        		<h3>Allergies</h3>
		        		<div class="form-inline">
						    <allergy-checkbox class="search-checkbox" v-for="allergy in allergies" :item="allergy.allergy" :checked="hasAllergy(allergy)"></allergy-checkbox>
					  	</div>
				  	</div>
				  	<div>
					  	<h3>Diets</h3>
		        		<div class="form-inline">
						    <diet-checkbox class="search-checkbox" v-for="diet in diets" :item="diet"></diet-checkbox>
					  	</div>
				  	</div>
				  	<div class="form-group">
					  	<h3>Cuisines</h3>
		        		<div class="form-inline">
						    <cuisine-checkbox class="search-checkbox" v-for="cuisine in cuisines" :item="cuisine"></cuisine-checkbox>
					  	</div>
				  	</div>
				  	<div class="form-group">
					  	<h3>Courses</h3>
		        		<div class="form-inline">
						    <course-checkbox class="search-checkbox" v-for="course in courses" :item="course"></course-checkbox>
					  	</div>
				  	</div>
				  	<div class="form-group">
					  	<h3>Holidays</h3>
		        		<div class="form-inline">
						    <holiday-checkbox class="search-checkbox" v-for="holiday in holidays" :item="holiday"></holiday-checkbox>
					  	</div>
				  	</div>
			  	</div>
			  	<div class="row">
			  		<div class="col-md-4 col-md-offset-6">
			  			<button class="btn btn-primary btn-block" type="submit">Search</button>
			  		</div>
		  		</div>
		  	</div>
	  	</form>
    </div>

    <script>
    	var allergies = {!! json_encode($allergies) !!};
    	var users_allergies = {!! json_encode($users_allergies) !!};
    </script>
    <script src="{{ asset('js/search.js') }}"></script>
@endsection