<template>
	<div class="media">
	  <div class="media-left">
	    <a :href="recipe_url + '/' + recipe.id">
	      <img class="media-object" :src="recipe.images.hostedSmallUrl" :alt="recipe.name" />
	    </a>
	  </div>
	  <div class="media-body">
	    <h4 class="media-heading"><a :href="recipe_url + '/' + recipe.id">{{ recipe.name }}</a>
	    	<save-icon :recipe_id="recipe.id" :saved="recipe.saved"></save-icon>
	    </h4>
	  </div>
	</div>
</template>

<script>
Vue.component('save-icon', require('./SaveIcon.vue'));

export default {
	props: [
    	'recipe'
	],
	computed: {
		recipe_url: function () {
			return recipe_url;
		}
	}
}
</script>