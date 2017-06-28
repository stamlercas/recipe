require ('./app');

Vue.component('ingredient-list-item', require('./components/IngredientListItem.vue'));

const recipe_app = new Vue({
    el: '#recipe',
    data: {
    	recipe: {},
    	users_ingredients: []
    },
    created: function() {
        this.recipe = recipe;
        this.users_ingredients = users_ingredients;
    },
    methods: {
    	makeGroceryList: function() {
    		var data = {
                id: this.recipe.id,
                name: this.recipe.name,
                _token: session_token
            }
            this.$http.post(grocery_list_create_url, data);
    	}
    }
});