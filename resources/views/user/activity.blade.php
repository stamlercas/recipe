@extends ('layouts.master')

@section('title')
    {{ Auth::user()->username }} Activity
@endsection

@section('content')
    <div id="activity">
        <h1>My Activity</h1>
        <div>
        	<activity-item :item="item" v-for="item in activity">
            </activity-item>
        </div>
    </div>

    <script>
    	var activity = {!! json_encode($activity) !!};
    </script>
    <script src="{{ asset('js/activity.js') }}"></script>
@endsection