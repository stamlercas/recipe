@extends ('layouts.master')

@section('title')
    Search
@endsection

@section('content')
    <div id="search">
        <h1> </h1>
        @if ($errors->any())
        	<div clas="alert alert-danger">
        		<ul class="list-unstyled">
        			@foreach($errors->all() as $error)
        				<li>{{ $error }}</li>
    				@endforeach
        		</ul>
        	</div>
    	@endif
        <form class="frame" style="padding-top:10px;" method="get" action="{{ route('search.results') }}">

	        <div class="row">
	        	<div class="col-md-8 col-md-offset-2">
			        <div class="row">
						<div class="col-md-10 col-md-offset-1">
							<div class="form-group">
							    <input type="keywords" name="query" class="form-control" id="keywords" placeholder="Keywords" value="{{ old('query') }}">
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
						    <diet-radio class="search-checkbox" v-for="diet in diets" :item="diet.longDescription" :name="'diet'" :value="diet.id" :checked="hasDiet(diet)"></diet-radoi>
					  	</div>
				  	</div>
				  	<div class="form-group">
					  	<h3>Cuisines
					  		<span class="pull-right visible-xs" data-target="#cuisine" data-toggle="collapse">
        						<i class="fa fa-caret-square-o-down" aria-hidden="true"></i>
    						</span>
					  	</h3>
		        		<div class="form-inline navbar-collapse collapse" id="cuisine">
						    <cuisine-checkbox class="search-checkbox" v-for="cuisine in cuisines" :item="cuisine.name" :name="cuisine.id" :checked="old[cuisine.id]"></cuisine-checkbox>
					  	</div>
				  	</div>
				  	<div class="form-group">
					  	<h3>Courses
					  		<span class="pull-right visible-xs" data-target="#course" data-toggle="collapse">
        						<i class="fa fa-caret-square-o-down" aria-hidden="true"></i>
    						</span>
					  	</h3>
		        		<div class="form-inline navbar-collapse collapse" id="course">
						    <course-checkbox class="search-checkbox" v-for="course in courses" :item="course.name" :name="course.id" :checked="old[course.id]"></course-checkbox>
					  	</div>
				  	</div>
				  	<div class="form-group">
					  	<h3>Holidays
					  		<span class="pull-right visible-xs" data-target="#holiday" data-toggle="collapse">
        						<i class="fa fa-caret-square-o-down" aria-hidden="true"></i>
    						</span>
					  	</h3>
		        		<div class="form-inline navbar-collapse collapse" id="holiday">
						    <holiday-checkbox class="search-checkbox" v-for="holiday in holidays" :item="holiday.name" :name="holiday.id" :checked="old[holiday.id]"></holiday-checkbox>
					  	</div>
				  	</div>
				  	<div class="form-group">
				  		<h3>Nutrition
				  			<span class="pull-right visible-xs" data-target="#nutrition" data-toggle="collapse">
        						<i class="fa fa-caret-square-o-down" aria-hidden="true"></i>
    						</span>
						</h3>
						<div class="form-inline navbar-collapse collapse" id="nutrition">
							<div v-for="(item, index) in nutrient_inputs">
								<span class="nutrient-close-btn" @click="removeNutrient(index)"><i class="fa fa-2x fa-times"></i></span>
								<nutrient-input :nutrient_attribute="item" :index="index"></nutrient-input>
								<div style="clear:both;"></div>
							</div>
							<div class="row" style="margin-top:15px;">
								<div class="col-md-8">
									<div class="input-group">
										<select class="form-control" v-model="selectedNutrient">
											<option v-for="n in nutrients" :value="n" :disabled="nutrient_inputs.indexOf(n) != -1">@{{ n.description }}</option>
										</select>
										<span class="input-group-btn">
											<a class="btn btn-success" role="button" @click="addNutrient(selectedNutrient)">Add Nutrient</a>
										</span>
									</div>
								</div>
							</div>
						</div>
				  	</div>
			  	</div>
			  	<div class="container-fluid row">
			  		<div class="col-md-4 col-md-offset-6">
			  			<button class="btn btn-primary btn-block" type="submit" @click="showModal = true;">Search</button>
			  		</div>
		  		</div>
		  	</div>
	  	</form>
	  	<modal v-if="showModal">
			<div slot="header"></div>
			<div slot="body">
				<div style="text-align:center;">
					<i class='fa fa-spinner fa-pulse fa-5x fa-fw'></i>
					<br /><br />
					<p>Please Wait...</p>
				</div>
			</div>
			<div slot="footer">
			</div>
		</modal>
    </div>

    <script>
    	var allergies = {!! json_encode($allergies) !!};
    	var users_allergies = {!! json_encode($users_allergies) !!};
    	var diets = {!! json_encode($diets) !!};
    	var users_diets = {!! json_encode($users_diets) !!};
    	var cuisines = {!! json_encode($cuisines) !!};
    	var courses = {!! json_encode($courses) !!};
    	var holidays = {!! json_encode($holidays) !!};
    	var nutrients = {!! json_encode($nutrients) !!};
    	var nutrient_inputs = {!! json_encode(old('nutrients')) !!};
    	var old = {!! json_encode(old()) !!};
    </script>
    <script src="{{ asset('js/search.js') }}"></script>
@endsection