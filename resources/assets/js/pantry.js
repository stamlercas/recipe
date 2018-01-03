require ('./app');

Vue.component('pantry-table', require('./components/Table.vue'));
Vue.component('edit-modal', require('./components/Modal.vue'));
Vue.component('search-results-table', require('./components/Table.vue'));
// Import the EventBus.
import { ActionBus } from './bus/action-bus.js';

import addItem from './mixins/ingredients.js';
import deleteItem from './mixins/ingredients.js';

const homepage = new Vue({
    el: '#pantry',
    mixins: [addItem, deleteItem],
    data: {
    	pantry: [
    	],
        searchResults: [],
    	userID: String,
    	search: '',
    	searchfield: '',
        pantrySearchField: '',
        searching: false,
        adding: false,
        showEditModal: false,
    	columns: [
    		{
    			name: 'description',
    			alias: 'Name'
			},
			{
				name: 'pivot.created_at',
				alias: 'Date Added'
			}
    	],
        actions: [
            /* { name: 'edit-item', icon: 'fa-pencil-square-o', class: 'edit-icon' }, */
            { name: 'delete-item', icon: 'fa-times', class: 'delete-icon' }
        ],
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
    	this.pantry = pantry;

    	ActionBus.$on('table-action', this.fireAction);
        ActionBus.$on('edit-action', this.editAction);
    },
    methods: {
    	fireAction: function(data) {
    		switch(data.action) {
    			case 'delete-item':
    				if (confirm("Are you sure you want to delete this item?")) {
    					this.deleteItem(data.data).then((value) => {
                            if (value)
                                this.pantry.splice(pantry.indexOf(data.data), 1);
                        });
	        		}
    				break;
                case 'add-item':
                    this.adding = true;

                    //search for duplicate
                    for (var i = 0; i < this.pantry.length; i++)
                        if (data.data.id == this.pantry[i].id) {
                            alert("You already have " + data.data.description + " in your pantry.");
                            this.adding = false;
                            return;
                        }
                this.addItem(data.data).then( function(value) {
                    console.log(value);
                    if (value !== false) {
                        console.log(value);
                        this.pantry.unshift(value);
                    }
                });
                this.adding = false;
    		}
    	},
        searchIngredients: function() {
            this.searching = true;

            if (this.searchfield === '' || this.searchfield === null) {
                this.searchResults = [];
                this.searching = false;
                return;
            }
            var data = {
                query: this.searchfield,
                _token: session_token
            };
            this.$http.post(pantry_search_url, data).then((response) => {
                            console.log(response.body);
                            if (response.body.success) {
                                this.searchResults = response.body.results;
                            }
                            this.searching = false;
                        });
        }
    }
});