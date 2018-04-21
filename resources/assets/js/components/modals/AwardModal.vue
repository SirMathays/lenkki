<template>
	<modal-core v-if="loading == false" v-on:close="awardsChecked">
		<div class="row">
			<transition name="explosion">
				<img src="/img/explode.png" alt="explode" class="explode">
			</transition>
			<h1 class="h2 text-center">Hienoa!</h1>
			<h2 v-if="awards.length > 1" class="h3 text-center">Olet ansainnut mitaleja!</h2>
			<h2 v-if="awards.length < 2" class="h3 text-center">Olet ansainnut mitalin!</h2>
			<div class="award-locker">
				<span v-for="award, index in awards" class="award large shadow" v-bind:class="award.grade_string">
	                <span v-for="name_part, index in award.name_parts">{{ name_part }}</span>
	            </span>
            </div>

            <div class="text-center" @click="awardsChecked">
	            <button class="btn btn-primary">
	            	OK
	            </button>
            </div>
		</div>
	</modal-core>
</template>

<style>
	.h2 {
		color: #f36821;
		font-weight: bold;
		margin-top: 0;
	}

	.h3 {
		margin-top: 15px;
		color: #b84d0a;
	}

	/* ANIMATION */
	.explosion-enter  {
		opacity: 0;
	}

	.explosion-enter {
		-webkit-transform: scale(0.6);
		transform: scale(0.6);
	}
</style>

<script>
    import ModalCore from './ModalCore.vue';

    export default {
        components: {
            'modal-core': ModalCore
        },
        data: function () {
            return {
                awards: [],
                loading: false
            }
        },
        methods: {
        	awardsChecked() {
        		var app = this;
				app.$emit('close');

        		axios.get('/v1/user/awardsSeen')
				.then(function (resp) {
					// 
				})
				.catch(function (resp) {
				    alert("Could not load activities");
				});
        	}
        },
        props: {
        	// 
        },
        mounted() {
        	var app = this;
			app.loading  = true;

			axios.get('/v1/user/unseenAwards')
			.then(function (resp) {
				app.loading  = false;
			    app.awards = resp.data;
			})
			.catch(function (resp) {
			    alert("Could not load activities");
				app.$emit('close');
			});
        }
    }
</script>