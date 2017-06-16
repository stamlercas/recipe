<template>
      	<li :class="hasIngredient != false ? 'strong' : ''">
      		<i v-if="!hasIngredient" 
      		class="action-icon fa fa-plus"
      		:class="inDB ? '' : 'disabled-action'"
      		@click="fireAction({ action: 'add-item', data: ingredient })">
      			&nbsp;
  			</i>
  			{{ ingredient.description }}
      		<span v-if="hasIngredient != false" class="list-action pull-right bg-danger">
	      		Don't have this?
	      		<i class="fa fa-times"></i>
      		</span>
  		</li>
</template>

<script>
import { ActionBus } from '../bus/action-bus.js';
export default {
	props: [
    	'ingredient',
    	'users_ingredients'
	],
	methods: {
		fireAction: function(action) {
			if (this.inDB)
				ActionBus.$emit("list-action", action);
		}
	},
	computed: {
		hasIngredient: function() {
			for (var i = 0; i < this.users_ingredients.length; i++)
				if (this.ingredient.description === this.users_ingredients[i].description)
					return this.users_ingredients[i];
			return false;
		},
		inDB: function() {
			if (this.ingredient.id == null)
				return false;
			return true;
		}
	}
}
</script>