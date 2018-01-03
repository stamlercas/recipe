<template>
	<div>
		<strong>
			<i class="fa text-info" :class="icon"></i>&nbsp;
			<a class="text-info" :href="recipe_url + '/' + item.id">{{ item.name }}</a> {{ action }}
		</strong>
		 on {{ new Date(item.pivot.created_at).toLocaleString('en-us', { month: '2-digit', day: 'numeric', year: 'numeric'}) }}
	</div>
</template>

<script>
Vue.component('save-icon', require('./SaveIcon.vue'));

export default {
	props: [
    	'item'
	],
	computed: {
		icon: function () {
			switch (this.item.table) {
				case 'recipes_made':
					return 'fa-check text-success';
				case 'recipes_saved':
					return 'fa-heart text-danger';
				case 'recipe_views':
					return 'fa-eye text-info';
			}
		},
		action: function() {
			switch (this.item.table) {
				case 'recipes_made':
					return 'made';
				case 'recipes_saved':
					return 'saved';
				case 'recipe_views':
					return 'viewed';
			}
		},
		recipe_url: function() {
			return recipe_url;
		}
	}
}
</script>