<template>
	<div style="padding:10px" class="form-inline">
		<input type="hidden" :name="'nutrients[' + index + '][description]'" :value="nutrient_attribute.description" />
		<input type="hidden" :name="'nutrients[' + index + '][id]'" :value="nutrient_attribute.id" />
		<div class="form-group">
			<label>{{ nutrient_attribute.description }}</label>
		</div>
		<div class="form-group">
			<span>Min</span>
			<input type="number" :name="'nutrients[' + index + '][min]'" :value="nutrient_attribute.min" />
		</div>
		<div class="form-group">
			<span>Max</span>
			<input type="number" :name="'nutrients[' + index + '][max]'" :value="nutrient_attribute.max" />
		</div>
	</div>
</template>

<script>
export default {
	props: [
    	'nutrient_attribute',
    	'index'
	]
}
</script>