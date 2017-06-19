export default {
	methods: {
		addItem: function(ingredient) {
    		var data = {
    			id: ingredient.id,
    			_token: session_token
    		};
    		return this.$http.post(inventory_add_url, data).then((response) => {
    			return response.body.success;
    		});
    	},
    	deleteItem: function(ingredient) {
    		return this.$http.get(inventory_delete_url + ingredient.id).then((response) => {
                return response.body.success;
    		});
    	}
	}
};