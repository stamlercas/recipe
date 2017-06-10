require ('./app');

Vue.component('pantry-table', require('./components/Table.vue'));
Vue.component('edit-modal', require('./components/Modal.vue'));

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
        adding: false,
        editableItem: {},
        showEditModal: false,
    	columns: [
    		{
    			name: 'item',
    			alias: 'Name'
			},
			{
				name: 'created_at',
				alias: 'Date Added'
			}
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
        ActionBus.$on('edit-action', this.editAction);
    },
    methods: {
    	addItem: function() {
            this.adding = true;
            if (this.addfield === '' || this.addfield === null) {
                this.adding = false;
                return;
            }
    		var data = {
    			item: this.addfield,
    			_token: session_token
    		}
    		this.$http.post(inventory_create_url, data).then((response) => {
                            console.log(response.body);
		        			if (response.body.success) {
    				            inventory.unshift(response.body.item);
                                this.addfield = '';
		        			}
                            this.adding = false;
		        		});
    	},
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
    					this.$http.get(inventory_delete_url + data.data.id).then((response) => {
		        			console.log(response);
                            inventory.splice(inventory.indexOf(data.data), 1);
		        		});
	        		}
    				break;
				case 'edit-item':
                    this.editableItem = JSON.parse(JSON.stringify(data.data));  // cloning object to make sure references aren't shared
                    this.showEditModal = true;
					break;
    		}
    	}
    }
});