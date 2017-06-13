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
        				<h3>Allergies
        					<span class="pull-right visible-xs" data-target="#allergy" data-toggle="collapse">
        						<i class="fa fa-caret-square-o-down" aria-hidden="true"></i>
    						</span>
    					</h3>
		        		<div class="form-inline navbar-collapse collapse" id="allergy">
						    <allergy-checkbox class="search-checkbox" v-for="allergy in allergies" :item="allergy.longDescription" :name="allergy.id" :checked="hasAllergy(allergy)"></allergy-checkbox>
					  	</div>
				  	</div>
				  	<div>
					  	<h3>Diets
					  		<span class="pull-right visible-xs" data-target="#diet" data-toggle="collapse">
        						<i class="fa fa-caret-square-o-down" aria-hidden="true"></i>
    						</span>
						</h3>
		        		<div class="form-inline navbar-collapse collapse" id="diet">
						    <diet-checkbox class="search-checkbox" v-for="diet in diets" :item="diet.longDescription" :name="diet.id" :checked="hasDiet(diet)"></diet-checkbox>
					  	</div>
				  	</div>
				  	<div class="form-group">
					  	<h3>Cuisines
					  		<span class="pull-right visible-xs" data-target="#cuisine" data-toggle="collapse">
        						<i class="fa fa-caret-square-o-down" aria-hidden="true"></i>
    						</span>
					  	</h3>
		        		<div class="form-inline navbar-collapse collapse" id="cuisine">
						    <cuisine-checkbox class="search-checkbox" v-for="cuisine in cuisines" :item="cuisine.name" :name="cuisine.id"></cuisine-checkbox>
					  	</div>
				  	</div>
				  	<div class="form-group">
					  	<h3>Courses
					  		<span class="pull-right visible-xs" data-target="#course" data-toggle="collapse">
        						<i class="fa fa-caret-square-o-down" aria-hidden="true"></i>
    						</span>
					  	</h3>
		        		<div class="form-inline navbar-collapse collapse" id="course">
						    <course-checkbox class="search-checkbox" v-for="course in courses" :item="course.name" :name="course.id"></course-checkbox>
					  	</div>
				  	</div>
				  	<div class="form-group">
					  	<h3>Holidays
					  		<span class="pull-right visible-xs" data-target="#holiday" data-toggle="collapse">
        						<i class="fa fa-caret-square-o-down" aria-hidden="true"></i>
    						</span>
					  	</h3>
		        		<div class="form-inline navbar-collapse collapse" id="holiday">
						    <holiday-checkbox class="search-checkbox" v-for="holiday in holidays" :item="holiday.name" :item="holiday.id"></holiday-checkbox>
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
    	var diets = {!! json_encode($diets) !!};
    	var users_diets = {!! json_encode($users_diets) !!};
    	var cuisines = {!! json_encode($cuisines) !!};
    	var courses = {!! json_encode($courses) !!};
    	var holidays = {!! json_encode($holidays) !!};
    </script>
    <script src="{{ asset('js/search.js') }}"></script>
@endsection