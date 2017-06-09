<template>
	<div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th v-for="column in columns" @click="sortBy(column.name)" :class="tableHeading(column.name)" 
                    	:title="column.alias">{{ column.alias }}</th>
                    <th v-if="actions != null"></th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="row in sortedTable">
                    <td v-for="column in columns">{{ row[column.name] }}</td>
                    <td v-if="actions != null">
                    	<i class="fa fa-lg" style="padding-right:5px;" v-for="action in actions" :class="action.icon" @click="fireAction({action: action.name, data: row})"></i>
                    </td>
                </tr>
          	</tbody>
      	</table>
    </div>
</template>

<script>

import { ActionBus } from '../bus/action-bus.js';

export default {
		props: [
			'data',
			'columns',
			'filterKey',
			'actions'
		],
		data () {
			var sortOrders = {}
			this.columns.forEach(function (key) {
			  sortOrders[key.name] = 1
			});
			return {
			  sortKey: '',
			  sortOrders: sortOrders
			};
		},
		computed: {
			sortedTable: function () {
			  var sortKey = this.sortKey;
			  var filterKey = this.filterKey && this.filterKey.toLowerCase();
			  var order = this.sortOrders[sortKey] || 1;
			  var data = this.data;
			  if (filterKey) {
			    data = data.filter(function (row) {
			      return Object.keys(row).some(function (key) {
			        return String(row[key]).toLowerCase().indexOf(filterKey) > -1
			      });
			    });
			  }
			  if (sortKey) {
			    data = data.slice().sort(function (a, b) {
			      a = a[sortKey];
			      b = b[sortKey];
			      return (a === b ? 0 : a > b ? 1 : -1) * order
			    });
			  }
			  return data;
			}
		},
		methods: {
			sortBy: function (key) {
			  this.sortKey = key;
			  this.sortOrders[key] = this.sortOrders[key] * -1;
			},
			tableHeading: function(key) {
				return (this.sortKey == key) ? 'active' : '';
			},
			fireAction: function(action) {
				ActionBus.$emit("table-action", action);
			},
			getValue: function(row, index) {
				/*
				console.log(key);
				for (var i = 0; i < this.columns.length; i++)
					if (this.columns[i].name == key)
						return row[key];
						*/
			}
		}
	}
</script>