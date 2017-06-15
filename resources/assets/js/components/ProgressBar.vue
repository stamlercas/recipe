<template>
	<span>
		<small>{{ this.name }}</small>
	  	<div class="progress" style="height:5px;margin-bottom:0;">
		  <div class="progress-bar" role="progressbar" :class="progressBarClass"
		  aria-valuemin="0" aria-valuemax="100" :style="'width:' + percentage + '%;'">
		  </div>
		</div>
	</span>
</template>

<script>
export default {
	props: [
    	'name',
    	'value',
	],
	computed: {
		progressBarClass: function() {
			if (this.percentage > 80)
				return 'progress-bar-danger';
			else if (this.percentage > 60)
				return 'progress-bar-warning';
			else
				return 'progress-bar-success';
		},
		percentage: function() {
			return this.value * 100;
		}
	}
}
</script>