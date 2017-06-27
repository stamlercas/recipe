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
    }
});