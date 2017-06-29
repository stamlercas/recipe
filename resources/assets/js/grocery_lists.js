require ('./app');

Vue.component('grocery-list-table', require('./components/Table.vue'));
Vue.component('input-button', require('./components/InputButtonField.vue'));

const grocery_lists_app = new Vue({
    el: '#grocery-lists-app',
    data: {
    	grocery_lists: {},
	    columns: [
    		{
    			name: 'name',
    			alias: 'Name'
			}
    	],
    	name: '',
    	creating: false,
        actions: [
            { name: 'view-item', icon: 'fa-pencil-square-o', class: '' },
            { name: 'delete-item', icon: 'fa-times', class: 'delete-icon' }
        ]
    },
    created: function() {
    	this.grocery_lists = grocery_lists;
    },
    methods: {
    	createGroceryList: function(name) {
    		this.creating = true;
    	}
    }
});