@extends ('layouts.master')

@section('title')
    Home
@endsection

@section('content')
    <div id="search">
        <h1>Search</h1>
        <div class="row">
			<div class="col-md-6 col-md-offset-3">
				<div class="form-group">
				    <input type="keywords" class="form-control" id="keywords" placeholder="Keywords">
			  	</div>
			</div>
		</div>
        <div class="row">
        	<div class="col-md-8 col-md-offset-2">
        		<h3>Allergies</h3>
        		<div>
				    <allergy-checkbox v-for="allergy in allergies" :item="allergy"></allergy-checkbox>
			  	</div>
		  </div>
	  	</div>
    </div>

    <script src="{{ asset('js/search.js') }}"></script>
@endsection