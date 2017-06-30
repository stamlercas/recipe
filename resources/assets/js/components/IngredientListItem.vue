<template>
      	<li :class="hasIngredient != false ? 'strong' : ''" v-if="show">
      		<i v-if="!hasIngredient" 
      		class="action-icon fa fa-plus"
      		:class="inDB ? '' : 'disabled-action'"
      		@click="fireAction({ action: 'add-item', data: ingredient })">
      			&nbsp;
  			</i>
  			{{ ingredient.description }}
      		<span v-if="hasIngredient != false" class="list-action pull-right bg-danger"
      		@click="fireAction({ action: 'delete-item', data: ingredient })">
	      		<span class="hidden-xs">Don't have this?</span>
	      		<i class="fa fa-times"></i>
      		</span>
  		</li>
</template>

<script>
import { ActionBus } from '../bus/action-bus.js';
export default {
	props: [
    	'ingredient',
    	'users_ingredients',
    	'showWhenHave'
	],
	data: function(){
		return {
			show: true
		};
	},
	created: function() {
		if (this.showWhenHave == false)
			if (this.hasIngredient)
				this.show = false;
		console.log("showWhenHave: " + this.showWhenHave);
		console.log("hasIngredient: " + this.hasIngredient);
		console.log(this.show);
	},
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
					return true;
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