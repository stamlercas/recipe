require ('./app');

Vue.component('pantry-table', require('./components/Table.vue'));

// Import the EventBus.
import { ActionBus } from './bus/action-bus.js';

const homepage = new Vue({
    el: '#inventory',
    data: {
    	inventory: [
    	],
    	userID: String,
    	search: '',
    	addfield: '',
    	columns: [
    		'item'
    	],
    	actions: [
    		{ name: 'edit-item', icon: 'fa-pencil-square-o', class: '' },
    		{ name: 'delete-item', icon: 'fa-times', class: '' }
    	]
    },
    created: function() {
    	//this.inventory = [{ item: 'carrots' }];
    	this.inventory = inventory;

    	ActionBus.$on('table-action', this.fireAction);
    },
    methods: {
    	addItem: function() {
    		this.$http.post(inventory_create_url, ).then((response) => {
		        			console.log(response);
		        		});
    	},
    	fireAction: function(data) {
    		switch(data.action) {
    			case 'delete-item':
    				if (confirm("Are you sure you want to delete this item?")) {
    					this.$http.get(inventory_delete_url + data.data.id).then((response) => {
		        			console.log(response);
		        		});
	        		}
    				break;
				case 'edit-item':
					//TODO:
					break;
    		}
    	}
    }
});