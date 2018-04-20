<template>
	<modal-core v-if="loading == false" v-on:close="awardsChecked">
		<div class="row">
			<h1 class="h2 text-center">Hienoa!</h1>
			<h2 class="h3 text-center">Olet ansainnut mitaleja!</h2>
			<div class="award-locker">
				<span v-for="award, index in awards" class="award shadow" v-bind:class="award.grade_string">
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
	/**/
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

        		axios.get('/v1/user/awardsSeen')
				.then(function (resp) {
					app.$emit('close');
				})
				.catch(function (resp) {
				    alert("Could not load activities");
					app.$emit('close');
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
				app.$emit.close;
			});
        }
    }
</script>