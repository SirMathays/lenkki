<template>
    <div class="top-list-wrapper">
        <loading-el v-if="loading"></loading-el>
        <div class="links text-center">
            <a class="link" id="monthly" @click="active = 'monthly'" v-bind:class="{ active: active == 'monthly' }">{{ monthNames[date.getMonth()] + 'kuu' }}</a>
            <a class="link" id="yearly" @click="active = 'yearly'" v-bind:class="{ active: active == 'yearly' }">{{ date.getFullYear() }}</a>
        </div>
        
        <div class="list top-list" v-bind:class="{ 'list-loading': loading }">
            <list-row 
                v-for="row, index in rows" 
                :key="row.id" 
                :id="row.id" 
                :initials="row.initials" 
                :avatar="row.avatar_url" 
                :comparison="row.comparison" 
                :score="row.user_score"></list-row>
            <div class="more">
                <a @click="limit == 3 ? limit = 0 : limit = 3">
                    <i class="fa fa-chevron-down" v-bind:class="{ 'fa-rotate-180': limit == 0  }"></i>
                </a>
            </div>
        </div>
    </div>
</template>

<style>
    .top-list-wrapper {
        position: relative;
    }

    i {
        transition: .2s;
    }

    .list {
        transition: .4s;
    }
    .list-loading {
        opacity: 0;
    }
    .more {
        font-size: 2em;
        text-align: center;
        margin-top: 25px;
    }
</style>

<script>
    import ListRow from './ListRow.vue';
    import Loading from './Loading.vue';

    export default {
        data: function () {
            return {
                monthNames: ["Tammi", "Helmi", "Maalis", "Huhti", "Touko", "Kesä", "Heinä", "Elo", "Syys", "Loka", "Marras", "Joulu"],
                date: new Date(),
                loading: false,
                rows: [],

                // CARE ABOUT THESE
                active: 'monthly',
                limit: 3
            }
        },
        props: {
            list: {
                required: true,
                type: String,
            },
            activityType: {
                required: false,
                type: Number,
            }
        },
        components: {
            'list-row': ListRow,
            'loading-el': Loading
        },
        mounted() {
            this.getTopList(this.active, this.limit);
        },
        watch: {
            active: function () {
                this.getTopList(this.active, this.limit);
            },
            limit: function () {
                this.getTopList(this.active, this.limit);
            }
        },
        methods: {
            getTopList(type, limit) {
                var app = this;
                app.loading = true;

                var activityUrl = "/";
                if(app.activityType) {
                    activityUrl = "/"+ app.activityType + "/"
                }

                var dateUrl = '/';
                var month = app.date.getMonth()+1;
                var year = app.date.getFullYear();

                if(type == 'monthly') {
                    dateUrl = '/'+year+'/'+month;
                } else if(type == 'yearly') {
                    dateUrl = '/'+year;
                }

                axios.get('/v1/lists/' + app.list + activityUrl + app.limit + dateUrl)
                    .then(function (resp) {
                        app.rows = resp.data.users;
                        app.loading = false;
                    })
                    .catch(function (resp) {
                        app.loading = false;
                        alert("Could not load rows");
                    });
            },
        }
    }
</script>