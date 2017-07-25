<template>
  <i class="fa pull-right save-icon" :class="(saved) ? 'fa-heart' : 'fa-heart-o'"
  	@click="save()"></i>
</template>

<script>
export default {
	props: [
    	'saved',
    	'recipe_id'
	],
	methods: {
		save: function() {
			var data = {
				id: this.recipe_id,
				_token: session_token
			};
			this.$http.post(save_recipe_url, data).then((response) => {
				if (response.body.success) {
					this.saved = response.body.saved;	// send back a saved variable
														// will be true if recipe was saved
														// will be false if recipe was unsaved
				}
			});
		}
	}
}
</script>