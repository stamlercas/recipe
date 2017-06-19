require ('./app');

Vue.component('pantry-table', require('./components/Table.vue'));
Vue.component('edit-modal', require('./components/Modal.vue'));
Vue.component('search-results-table', require('./components/Table.vue'));

// Import the EventBus.
import { ActionBus } from './bus/action-bus.js';

import addItem from './mixins/ingredients.js';
import deleteItem from './mixins/ingredients.js';

const homepage = new Vue({
    el: '#inventory',
    mixins: [addItem, deleteItem],
    data: {
    	inventory: [
    	],
        searchResults: [],
    	userID: String,
    	search: '',
    	searchfield: '',
        searching: false,
        adding: false,
        editableItem: {},
        showEditModal: false,
    	columns: [
    		{
    			name: 'description',
    			alias: 'Name'
			},
			{
				name: 'created_at',
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
    	//this.inventory = [{ item: 'carrots' }];
    	this.inventory = inventory;

    	ActionBus.$on('table-action', this.fireAction);
        ActionBus.$on('edit-action', this.editAction);
    },
    methods: {
        editAction: function(data) {
            switch(data) {
                case 'edit':
                    if (this.editableItem.item === '')
                        return;
                    var data = {
                        id: this.editableItem.id,
                        item: this.editableItem.item,
                        _token: session_token
                    }
                    this.$http.post(inventory_edit_url, data).then((response) => {
                                    for (var i = 0; i < inventory.length; i++) {
                                        console.log(inventory[i]);
                                        if (inventory[i].id == response.body.item.id)
                                            inventory[i].item = response.body.item.item;
                                    }
                                    this.showEditModal = false;
                                });
                    break;
                case 'close':
                    this.showEditModal = false;
                    break;
            }
        },
    	fireAction: function(data) {
    		switch(data.action) {
    			case 'delete-item':
    				if (confirm("Are you sure you want to delete this item?")) {
    					this.deleteItem(data.data).then((value) => {
                            if (value)
                                this.inventory.splice(inventory.indexOf(data.data), 1);
                        });
	        		}
    				break;
				case 'edit-item':
                    this.editableItem = JSON.parse(JSON.stringify(data.data));  // cloning object to make sure references aren't shared
                    this.showEditModal = true;
					break;
                case 'add-item':
                    this.adding = true;

                    //search for duplicate
                    for (var i = 0; i < this.inventory.length; i++)
                        if (data.data.id == this.inventory[i].id) {
                            alert("You already have " + data.data.description + " in your pantry.");
                            this.adding = false;
                            return;
                        }
                this.addItem(data.data).then( function(value) {
                    if (value)
                        this.inventory.unshift(data.data);
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
            this.$http.post(inventory_search_url, data).then((response) => {
                            console.log(response.body);
                            if (response.body.success) {
                                this.searchResults = response.body.results;
                            }
                            this.searching = false;
                        });
        }
    }
});