<template>
	<div class="profile" v-bind:class="{ 'shadow button': link }">
		<a v-if="link" v-bind:href="/user/ + id"></a>
        <span v-if="!avatar" class="initials">{{ initials }}</span>
        <img v-if="avatar" :src="avatar">
    </div>
</template>

<script>
    export default {
        props: {
        	link: {
        		type: Boolean,
        		required: true
        	},
            id: {
                type: Number,
                required: true
            },
            initials: {
                type: String,
                required: true
            },
            avatar: {
                required: false,
                type: String,
                default: null
            }
        },
        mounted() {
            // 
        }
	}
</script>