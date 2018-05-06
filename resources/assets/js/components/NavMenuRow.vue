<template>
	<li>
        <a :href="url">{{ name }}</a>
    </li>
</template>

<script>
	export default {
		props: {
			name: {
				required: true,
				type: String
			},
			url: {
				required: true,
				type: String
			}
		},
		mounted() {
			// 
		}
	}
</script>