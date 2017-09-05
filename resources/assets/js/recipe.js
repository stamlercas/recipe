require ('./app');

Vue.component('ingredient-list-item', require('./components/IngredientListItem.vue'));
Vue.component('save-icon', require('./components/SaveIcon.vue'));
Vue.component('nutrition-table', require('./components/Table.vue'));

import { ActionBus } from './bus/action-bus.js';

import addItem from './mixins/ingredients.js';

const recipe_app = new Vue({
    el: '#recipe',
    mixins: [addItem],
    data: {
    	recipe: {},
    	users_ingredients: [],
        nutrientColumns: [
            {
                name: 'description',
                alias: 'Description'
            },
            {
                name: 'value',
                alias: 'Value'
            },
            {
                name: 'unit.plural',
                alias: 'Unit'
            }
        ]
    },
    created: function() {
        this.recipe = recipe;
        this.users_ingredients = users_ingredients;

        // filter nutrition estimates to cut down on space
        var nutrition = recipe.nutritionEstimates;
        recipe.nutritionEstimates = [];
        for (var i = 0; i < nutrition.length; i++) {
            if (nutrition[i].value != 0 && (nutrition[i].attribute != "ENERC_KJ" && nutrition[i].attribute != "FAT_KCAL"))
                recipe.nutritionEstimates.push(nutrition[i]);
        }

        ActionBus.$on('list-action', this.fireAction);
    },
    methods: {
    	makeGroceryList: function() {
    		var data = {
                id: this.recipe.id,
                name: this.recipe.name,
                _token: session_token
            }
            this.$http.post(grocery_list_create_url, data);
    	},
        fireAction: function(data) {
            switch(data.action) {
                // adds ingredient to pantry
                case 'add-item':
                    this.addItem(data.data).then((value) => {
                        if (value)
                            this.users_ingredients.unshift(data.data);
                    });
                    break;
                // deletes ingredient from pantry
                case 'delete-item':
                    this.deleteItem(data.data).then((value) => {
                        for (var i = 0; i < this.users_ingredients.length; i++)
                            if (data.data.id == this.users_ingredients[i].id) {
                                console.log(i);
                                this.users_ingredients.splice(i, 1);
                            }
                    });
                    break;
            }
        }
    }
});