require ('./app');

Vue.component('grocery-list-table', require('./components/Table.vue'));

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
        actions: [
            /* { name: 'edit-item', icon: 'fa-pencil-square-o', class: 'edit-icon' }, */
            { name: 'delete-item', icon: 'fa-times', class: 'delete-icon' }
        ]
    },
    created: function() {
    	this.grocery_lists = grocery_lists;
    }
});