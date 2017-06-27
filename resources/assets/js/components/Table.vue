<template>
	<div class="table-responsive">
        <table class="table table-striped">
            <thead v-if="showHeading != false">
                <tr>
                    <th v-for="column in columns" @click="sortBy(column.name)" :class="tableHeading(column.name)" 
                    	:title="column.alias">{{ column.alias }}</th>
                    <th v-if="actions != null"></th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(row, index) in sortedTable" v-if="inbound(index)">
                    <td v-for="column in columns">{{ row[column.name] }}</td>
                    <td v-if="actions != null">
                    	<i class="action-icon fa fa-lg" style="padding-right:5px;" v-for="action in actions" :class="action.icon" @click="fireAction({action: action.name, data: row})"></i>
                    </td>
                </tr>
          	</tbody>
      	</table>
      	<paginate v-if="paginate" :page-count="pages" :container-class="'pagination'" :click-handler="paginateCallBack"></paginate>
    </div>
</template>

<script>

import { ActionBus } from '../bus/action-bus.js';

import Paginate from 'vuejs-paginate';
Vue.component('paginate', Paginate);

export default {
		props: [
			'data',
			'columns',
			'filterKey',
			'actions',
			'showHeading',
			'paginate',	// if true show pages
		],
		data () {
			var sortOrders = {}
			this.columns.forEach(function (key) {
			  sortOrders[key.name] = 1
			});
			return {
			  sortKey: '',
			  sortOrders: sortOrders,
			  pageLength: 10,
			  page: 1
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
			},
			pages: function() {
				return this.sortedTable.length / this.pageLength;
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
			},
			paginateCallBack: function(page) {
				if (this.paginate)
					this.page = page;
			},
			inbound: function(index) {
				if (!this.paginate)
					return true;
				// find bounds of page and check index
				else if ( index >= (this.page - 1) * this.pageLength 
					&& index <= ((this.page) * this.pageLength) - 1 )
					return true;
				return false;
			}
		}
	}
</script>