<template>
	<transition name="fade" mode="out-in">
	    <ul class="dropdown-menu">
	    	<slot></slot>
	    </ul>
    </transition>
</template>

<style>
	.dropdown-menu {
		display: block;
	}

	/* ANIMATION */
	.fade-enter-active,
	.fade-leave-active {
	    transition: .2s
	}

	.fade-enter,
	.fade-leave-to {
	    transform: translateY(-5px);
	    opacity: 0;
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