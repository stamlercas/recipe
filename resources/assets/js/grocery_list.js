require ('./app');

Vue.component('ingredient-list-item', require('./components/IngredientListItem.vue'));

const grocery_lists_app = new Vue({
    el: '#grocery-list-app',
    data: {
    	grocery_list: {},
    	ingredients: [],
    	users_ingredients: []
    },
    created: function() {
    	this.grocery_list = grocery_list;
    	this.ingredients = ingredients;
    }
});