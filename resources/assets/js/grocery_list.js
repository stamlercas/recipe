require ('./app');

Vue.component('ingredient-list-item', require('./components/IngredientListItem.vue'));
Vue.component('modal', require('./components/Modal.vue'));
Vue.component('input-button', require('./components/InputButtonField.vue'));
Vue.component('search-results-table', require('./components/Table.vue'));

import { ActionBus } from './bus/action-bus.js';

import searchIngredients from './mixins/ingredients.js';
import addIngredient from './mixins/grocery_list.js';

const grocery_lists_app = new Vue({
    el: '#grocery-list-app',
    mixins: [searchIngredients, addIngredient],
    data: {
    	grocery_list: {},
    	ingredients: [],
    	users_ingredients: [],
        showModal: false,
        searching: false,
        searchResults: [],
        resultsColumns: [
            {
                name: 'description',
                alias: 'Name'
            }
        ],
        resultsActions: [
            { name: 'add-item', icon: 'fa-plus', class: 'add-icon' }  
        ]
    },
    created: function() {
    	this.grocery_list = grocery_list;
    	this.ingredients = ingredients;
        this.users_ingredients = users_ingredients;

        ActionBus.$on('table-action', this.fireAction);
    },
    methods: {
        closeModal: function() {
            this.showModal = false;
            this.searchResults = [];
        },
        search: function(field) {
            if (field === '' || field === null)
            {
                this.searching = false;
                this.searchResults = [];
                return;
            }
            this.searching = true;
            this.searchIngredients(field).then((data) => {
                if (data.success)
                    this.searchResults = data.results;
                else
                    this.searchResults = [];
                this.searching = false;
            });
        },
        fireAction: function(data) {
            switch(data.action) {
                case 'add-item':
                    if (this.addIngredient(this.grocery_list, data.data).then((value) => {
                        if (value) {
                            this.ingredients.push(data.data);
                            this.closeModal();
                        }
                    }));
                    break;
            }
        }
    }
});