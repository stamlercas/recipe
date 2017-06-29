<template>
<div class="input-group">
    <input type="text" class="form-control" id="item" v-model="field" :placeholder="action" :name="name" v-on:keyup.13="callbackFunction(field)">
    <span class="input-group-btn">
    	<button type="submit" class="btn btn-success" @click="callbackFunction(field)">
    		<div v-if="!doingWork">
    			<i v-if="icon != null" :class="icon" class="fa"></i> {{ action }}
			</div>
    		<i v-if="doingWork" class='fa fa-spinner fa-pulse fa-lg fa-fw'></i>
		</button>
	</span>
</div>
</template>

<script>
export default {
	props: [
		'action',
		'icon',
		'callbackFunction',
		'doingWork'
	],
	data: function() {
		return {
			field: ''
		};
	}
}
</script>