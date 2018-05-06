<template>
    <div class="top-list-wrapper">
        <loading-el v-if="loading"></loading-el>
        <div class="links text-center">
            <i class="fa fa-fw fa-arrow-circle-left link" @click="activeTime('minus')"></i>
            <div class="filters">
                <a class="link" id="default" v-if="activeMonth != month || activeYear != year" @click="activeMonth = month, activeYear = year"><i class="fa fa-calendar-o"></i></a>
                <a class="link" id="month" @click="scope = 'month'" v-bind:class="{ active: scope == 'month' }">{{ monthNames[activeMonth] }}</a>
                <a class="link" id="year" @click="scope = 'year'" v-bind:class="{ active: scope == 'year' }">{{ activeYear }}</a>
            </div>
            <i class="fa fa-fw fa-arrow-circle-right link" @click="activeTime('plus')"></i>
        </div>
        
        <div class="list top-list" v-bind:class="{ 'list-loading': loading }">
            <list-row 
                v-for="row, index in rows" 
                :key="row.id" 
                :id="row.id" 
                :initials="row.initials" 
                :avatar="row.avatar_url" 
                :comparison="row.comparison" 
                :score="row.user_score"
                :type="type" />
            <div class="more">
                <a class="link" @click="limit == 3 ? limit = 0 : limit = 3">
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

    .filters > .link {
        position: relative;
    }

    .list {
        transition: .4s;
    }
    .list-loading {
        opacity: 0.2;
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
    import NavMenu from './NavMenu.vue';

    export default {
        data: function () {
            return {
                monthNames: {
                    "1":"Tammikuu", 
                    "2":"Helmikuu", 
                    "3":"Maaliskuu", 
                    "4":"Huhtikuu", 
                    "5":"Toukokuu", 
                    "6":"Kesäkuu", 
                    "7":"Heinäkuu", 
                    "8":"Elokuu", 
                    "9":"Syyskuu", 
                    "10":"Lokakuu", 
                    "11":"Marraskuu", 
                    "12":"Joulukuu"
                },
                loading: false,
                monthSwitch: false,
                rows: [],
                type: 'xp',

                // CARE ABOUT THESE
                scope: 'month',
                activeMonth: this.month,
                activeYear: this.year,
                activeSeason: this.season,
                limit: 3
            }
        },
        props: {
            list: {
                required: true,
                type: String,
            },
            month: {
                required: true,
                type: String,
            },
            year: {
                required: true,
                type: String,
            },
            season: {
                required: false,
                type: String,
            },
            activityType: {
                required: false,
                type: Number,
            }
        },
        components: {
            'list-row': ListRow,
            'loading-el': Loading,
            'nav-menu': NavMenu
        },
        mounted() {
            this.getTopList(this.scope);
        },
        watch: {
            scope: function () {
                this.getTopList(this.scope);
                this.showMonths = false;
            },
            limit: function () {
                this.getTopList(this.scope);
            },
            activeMonth: function () {
                this.getTopList(this.scope);
                this.showMonths = false;
            },
            activeYear: function () {
                this.getTopList(this.scope);
            }
        },
        methods: {
            activeTime(plusMinus) {
                var app = this;
                app.monthSwitch = true;

                if(app.scope != 'year') {
                    if(plusMinus == 'plus') {
                        if(app.activeMonth < 12) {
                            app.activeMonth++;
                        } else {
                            app.activeMonth = 1;
                            app.activeYear++;
                        }
                    } else if(plusMinus == 'minus') {
                        if(app.activeMonth > 1) {
                            app.activeMonth--;
                        } else {
                            app.activeMonth = 12;
                            app.activeYear--;
                        }
                    } 
                } else {
                    if(plusMinus == 'plus') {
                        app.activeYear++;
                    } else if(plusMinus == 'minus') {
                        app.activeYear--;
                    } 
                }
            },
            getTopList(scope) {
                var app = this;
                var activityUrl = "/";
                var dateUrl = '/' + app.activeYear;

                app.loading = true;

                if(app.activityType) {
                    activityUrl = "/"+ app.activityType + "/"
                    app.type = 'km';
                }

                if(scope == 'month') {
                    dateUrl = '/'+app.activeYear+'/'+app.activeMonth;
                }

                axios.get('/v1/lists/' + app.list + activityUrl + app.limit + dateUrl)
                    .then(function (resp) {
                        app.rows = resp.data.users;
                        app.loading = false;
                        app.monthSwitch = false;
                    })
                    .catch(function (resp) {
                        app.loading = false;
                        app.monthSwitch = false;
                        alert("Could not load rows");
                    });
            },
        }
    }
</script>