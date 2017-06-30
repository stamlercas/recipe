require ('./app');

Vue.component('ingredient-list-item', require('./components/IngredientListItem.vue'));

import { ActionBus } from './bus/action-bus.js';

import addItem from './mixins/ingredients.js';
import deleteItem from './mixins/ingredients.js';

const recipe_made = new Vue({
    el: '#recipe-made',
    mixins: [addItem, deleteItem],
    data: {
        ingredients: [],
        users_ingredients: []
    },
    created: function() {
        this.ingredients = ingredients.matches;
        this.users_ingredients = users_ingredients;

        ActionBus.$on('list-action', this.fireAction);
    },
    methods: {
        fireAction: function(data) {
            switch(data.action) {
                case 'add-item':
                    this.addItem(data.data).then((value) => {
                        if (value)
                            this.users_ingredients.unshift(data.data);
                    });
                    break;
                case 'delete-item':
                    this.deleteItem(data.data).then((value) => {
                        for (var i = 0; i < this.users_ingredients.length; i++)
                            if (data.data.id == this.users_ingredients[i].id) {
                                console.log(i);
                                this.users_ingredients.splice(i, 1);
                            }
                    });
            }
        }
    }
});