require ('./app');

Vue.component('ingredient-list-item', require('./components/IngredientListItem.vue'));
Vue.component('modal', require('./components/Modal.vue'));
Vue.component('input-button', require('./components/InputButtonField.vue'));
Vue.component('search-results-table', require('./components/Table.vue'));

import { ActionBus } from './bus/action-bus.js';

import addItem from './mixins/ingredients.js';
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
            { name: 'add-item-grocery-list', icon: 'fa-plus', class: 'add-icon' }  
        ]
    },
    created: function() {
    	this.grocery_list = grocery_list;
    	this.ingredients = ingredients;
        this.users_ingredients = users_ingredients;

        ActionBus.$on('table-action', this.fireAction);
        ActionBus.$on('list-action', this.fireAction);
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
        close: function() {
            if (this.confirmCloseGroceryList()) {
                $('#close-grocery-list').submit();
            }
        },
        fireAction: function(data) {
            switch(data.action) {
                // adds ingredient to this grocery list
                case 'add-item-grocery-list':
                    if (this.addIngredient(this.grocery_list, data.data).then((value) => {
                        if (value) {
                            this.ingredients.push(data.data);
                            this.closeModal();
                        }
                    }));
                    break;
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
            }
        }
    }
});