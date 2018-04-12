<template>
    <div class="list log">
    	<activity v-for="row, index in rows" 
            :key="row.id" 
            :id="row.id" 
            :showProfile="showProfile"
            :type="row.type"
            :initials="row.user.initials" 
            :avatar="row.user.avatar_url" 
            :score="row.score"
            :km="row.km" 
            :duration="row.duration"
            :date="row.date"></activity>
            <h5 v-if="rows.length <= 0" class="text-center">Ei aktiviteetteja</h5>
    </div>
</template>

<script>
    import Activity from './Activity.vue';
	
    export default {
    	data: function () {
            return {
                loading: false,
                showProfile: this.user ? false : true,
                rows: []
            }
        },
    	components: {
            'activity': Activity
        },
        props: {
            user: {
                type: Number,
                required: false
            }
        },
        mounted() {
            var app = this;
            app.loading = true;
            var getUrl = '/v1/lists/recentActivities';

            if(app.user)
                getUrl = '/v1/user/activities/' + app.user;

        	axios.get(getUrl)
                .then(function (resp) {
                    app.rows = resp.data;
                    app.loading = false;
                })
                .catch(function (resp) {
                    app.loading = false;
                    alert("Could not load activities");
                });
        }
	}
</script>