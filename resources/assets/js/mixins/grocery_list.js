export default {
	methods: {
		addIngredient: function(grocery_list, ingredient) {
    		var data = {
    			ingredient_id: ingredient.id,
    			_token: session_token
    		};
    		return this.$http.post(grocery_list_add_url, data).then((response) => {
    			return response.body.success;
    		});
    	},
        confirmCloseGroceryList: function() {
            return confirm("Are you sure you want to close this list.  " + 
                "Once you close, you will not have access to it anymore.");
        },
        closeGroceryList: function(slug) {
            var data = {
                _token: session_token
            };
            return this.$http.post(grocery_list_url + slug + "/close", data).then((response) => {
                return response.body.success;
            });
        }
    }
}