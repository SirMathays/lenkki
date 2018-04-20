<template>
	<transition name="modal">
	    <div class="modal-mask">
			<div class="modal-container panel">
				<div class="modal-body">
					<a class="modal-close-button" @click="$emit('close')">
						<i class="fa fa-times"></i>
					</a>
					<slot></slot>
				</div>
			</div>
	    </div>
	</transition>
</template>

<style>
	/* ANIMATION */
	.modal-enter, .modal-leave-active  {
		opacity: 0;
	}

	.modal-enter .modal-container,
	.modal-leave-active .modal-container {
		-webkit-transform: scale(1.1);
		transform: scale(1.1);
	}
</style>

<script>
	// 
</script>