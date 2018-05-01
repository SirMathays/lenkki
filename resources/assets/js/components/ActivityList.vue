<template>
    <div class="list log">
        <activity-loading v-for="n in 10" :key="n" v-if="loading"></activity-loading>
    	<activity v-if="!loading" v-for="row, index in rows" 
            @show="$emit('show-activity', row.id)"
            :key="row.id" 
            :id="row.id" 
            :showProfile="showProfile"
            :activityName="row.activity_name"
            :initials="row.user.initials" 
            :avatar="row.user.avatar_url" 
            :xp="row.xp"
            :km="row.km" 
            :duration="row.duration"
            :date="row.performed_at_formatted"></activity>
        <h5 v-if="rows.length <= 0 && !loading" class="text-center">Ei aktiviteetteja</h5>
        <ul v-if="pages > 1 && user" class="pagination">
            <li class="page-item" v-bind:class="{disabled: page == 1}"><a class="page-link" @click="page = page > 1 ? page-1 : page">‹</a></li>
            <li v-for="n in pages" class="page-item" v-bind:class="{active: page == n}"><a :id="n" @click="page = n" class="page-link">{{ n }}</a></li>
            <li class="page-item" v-bind:class="{disabled: page == pages}"><a class="page-link" @click="page = page < pages ? page+1 : page">›</a></li>
        </ul>
    </div>
</template>

<script>
    import Activity from './Activity.vue';
    import ActivityLoading from './ActivityLoading.vue';
	
    export default {
    	data: function () {
            return {
                loading: false,
                showProfile: this.user ? false : true,
                rows: [],
                page: 1,
                pages: 0,
            }
        },
    	components: {
            'activity': Activity,
            'activity-loading': ActivityLoading
        },
        props: {
            user: {
                type: Number,
                required: false
            },
            activityType: {
                type: Number,
                required: false
            }
        },
        watch: {
            page: function(val) {
                this.getActivities();
            }
        },
        methods: {
            getActivities() {
                var app = this;
                app.loading = true;
                var getUrl = '/v1/lists/recentActivities';

                if(app.activityType)
                    getUrl = getUrl + '/' + app.activityType;

                if(app.user)
                    getUrl = '/v1/user/activities/' + app.user + '?page=' + app.page;

                axios.get(getUrl)
                    .then(function (resp) {
                        app.rows = resp.data.data;
                        app.pages = resp.data.last_page;
                        app.loading = false;
                    })
                    .catch(function (resp) {
                        app.loading = false;
                        alert("Could not load activities");
                    });
            }
        },
        mounted() {
            this.getActivities();
        }
	}
</script>