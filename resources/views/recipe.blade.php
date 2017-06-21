@extends('layouts.master')

@section('title')
{{ recipe.name }}
@endsection

@section('content')

<script>
	var recipe = {{ json_encode($recipe) }};
</script>



@endsection