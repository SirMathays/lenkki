<template>
	<modal-core v-if="loading == false" v-on:close="$emit('close')">
		<div class="row">
			<img v-if="activity.image_url" v-bind:src="activity.image_url" class="image-banner">
			<h3 class="col-md-12 tidbits">
                <span class="tidbit"><b>{{ activity_type.name }}</b></span>
                <span>{{ activity.performed_at_formatted }}</span>
                <span class="xp pull-right">+{{ activity.xp }} xp</span>
            </h3>
            <div class="col-md-12 form-group">
                <p><b>Suorittaja:</b> {{ user.name }}</a></p>
                <p><b>Pituus:</b> {{ activity.km }}km</p>
                <p><b>Kesto:</b> {{ activity.duration }}min</p>
            </div>
            <div v-if="activity.user_has_rights" class="col-md-12 text-right">
                <a v-bind:href="'/activity/edit/' + activity.id" class="btn btn-primary">
                    <i class="fa fa-pencil"></i> Muokkaa
                </a>
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
                activity: [],
                user: [],
                activity_type: [],
                loading: false
            }
        },
        methods: {
        	// 
        },
        props: {
        	id: {
                type: Number,
                required: true
            }
        },
        mounted() {
        	var app = this;
        	app.loading  = true;

        	axios.get('/v1/activity/' + app.id)
                .then(function (resp) {
        			app.loading  = false;
                    app.activity = resp.data;
                    app.user = resp.data.user;
                    app.activity_type = resp.data.activity_type;
                })
                .catch(function (resp) {
                    alert("Could not load activities");
        			app.$emit.close;
                });
        }
    }
</script>