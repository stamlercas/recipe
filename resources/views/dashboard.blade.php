@extends ('layouts.master')

@section('title')
    Dashboard
@endsection

@section('content')
    <div>
        <h1>Welcome Back, {{ Auth::user()->first_name }}!</h1>
        <div>
    		<!-- BLOCKS GO HERE -->
    		<!-- EXAMPLES:
    			Trending
    			Cuisine of the day (ex:  There most popular cuisine is Mexican on Wednesday.  On Wednesday, display Taco Wednesday and a link to mexican dishes.  Or a link to past mexican dishes made or viewed on Wednesday.)
    			Recommendations (based on past searches, makes, and views; display recommendations on what to make.)
    			"You viewed this recently.  Did you make it?"
			-->
        </div>
    </div>
    <script src="{{ asset('js/app.js') }}"></script>
@endsection