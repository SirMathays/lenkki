<template>
	<transition name="slide">
		<div class="nav-drawer-container" v-on:click="$emit('close')">
			<nav class="nav-drawer">
				<slot></slot>
			</nav>
		</div>
    </transition>
</template>

<style>
	/* ANIMATION */
	.slide-enter-active,
	.slide-leave-active {
	    transition: .4s
	}

	.slide-enter,
	.slide-leave-to {
	    opacity: 0;
		transform: translateX(-100%);
	}
</style>

<script>
	export default {
		data: function () {
            return {
                // 
            }
        }
	}
</script>