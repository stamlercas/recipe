require ('./app');

Vue.component('progress-bar', require('./components/ProgressBar.vue'));
Vue.component('ingredient-list-item', require('./components/IngredientListItem.vue'));

import { ActionBus } from './bus/action-bus.js';

const results = new Vue({
    el: '#results',
    data: {
    	results: [
        ],
        users_ingredients: []
    },
    created: function() {
        this.results = search_results.matches;
        this.users_ingredients = users_ingredients;

        ActionBus.$on('list-action', this.fireAction);
    },
    methods: {
        timeInMinutes: function(seconds) {
            return seconds / 60;
        },
        fireAction: function(action) {
            switch(action.action) {
                case 'add-item':
                    this.addItem(action.data);
                    break;
            }
        },
        addItem: function(ingredient) {
            var data = {
                id: ingredient.id,
                _token: session_token
            };
            console.log(ingredient);
            this.$http.post(inventory_add_url, data).then((response) => {
                            console.log(response.body);
                            if (response.body.success) {
                                this.users_ingredients.unshift(response.body.ingredient);
                            }
                        });
        },

    }
});