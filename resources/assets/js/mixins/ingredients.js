export default {
	methods: {
		addItem: function(ingredient) {
    		var data = {
    			id: ingredient.id,
    			_token: session_token
    		};
    		return this.$http.post(inventory_add_url, data).then((response) => {
                if (response.body.success)
    		      return response.body.ingredient;
                return false;
    		});
    	},
    	deleteItem: function(ingredient) {
    		return this.$http.get(inventory_delete_url + ingredient.id).then((response) => {
                return response.body.success;
    		});
    	},
        searchIngredients: function(query) {        //TODO: MAKE WORK
            if (query === '' || query === null) {
                return false;
            }
            var data = {
                query: query,
                _token: session_token
            };
            return this.$http.post(inventory_search_url, data).then((response) => {
                return response.body;
            });
        }
	}
};