require ('./app');

Vue.component('grocery-list-table', require('./components/Table.vue'));
Vue.component('input-button', require('./components/InputButtonField.vue'));

import { ActionBus } from './bus/action-bus.js';

import confirmCloseGroceryList from './mixins/grocery_list.js';

const grocery_lists_app = new Vue({
    el: '#grocery-lists-app',
    mixins: [confirmCloseGroceryList],
    data: {
    	grocery_lists: {},
	    columns: [
    		{
    			name: 'name',
    			alias: 'Name'
			},
            {
                name: 'created_at',
                alias: 'Date Created'
            }
    	],
    	name: '',
    	creating: false,
        actions: [
            { name: 'view-item', icon: 'fa-external-link', class: '' },
            { name: 'delete-item', icon: 'fa-times', class: 'delete-icon' }
        ]
    },
    created: function() {
    	this.grocery_lists = grocery_lists;

        ActionBus.$on('table-action', this.fireAction);
    },
    methods: {
    	createGroceryList: function(name) {
    		this.creating = true;
    	},
        fireAction: function(data) {
            switch (data.action) {
                case 'view-item':
                    window.location = grocery_list_url + data.data.slug;
                    break;
                case 'delete-item':
                    if (this.confirmCloseGroceryList())
                        ;   //TODO: delete list
            }
        }
    }
});