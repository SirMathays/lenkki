<template>
    <div class="top-list-wrapper">
        <loading-el v-if="loading"></loading-el>
        <div class="links text-center">
            <a class="link" id="monthly" @click="topListMonthly(3)" v-bind:class="{ active: active == 'monthly' }">{{ monthNames[date.getMonth()] + 'kuu' }}</a>
            <a class="link" id="yearly" @click="topListYearly(3)" v-bind:class="{ active: active == 'yearly' }">{{ date.getFullYear() }}</a>
        </div>
        
        <div class="list top-list" v-bind:class="{ 'list-loading': loading }">
            <list-row v-for="row, index in rows" :key="row.id" :id="row.id" :initials="row.initials" :avatar="row.avatar" :comparison="row.comparison" :score="row.score"></list-row>
            <div class="more">
                <a @click="active == 'monthly' ? topListMonthly(showAll ? 3 : 0) : topListYearly(showAll ? 3 : 0)">
                    <i class="fa fa-chevron-down" v-bind:class="{ 'fa-rotate-180': showAll  }"></i>
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
        /*transform: translateX(-25px);*/
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
                loading: false,
                showAll: false,
                active: 'monthly',
                monthNames: ["Tammi", "Helmi", "Maalis", "Huhti", "Touko", "Kesä", "Heinä", "Elo", "Syys", "Loka", "Marras", "Joulu"],
                date: new Date(),
                rows: []
            }
        },
        components: {
            'list-row': ListRow,
            'loading-el': Loading
        },
        mounted() {
            this.topListMonthly(3);
        },
        methods: {
            topListMonthly(limit = 0) {
                var app = this;
                app.loading = true;
                
                if(limit > 0)
                    app.showAll = false;
                else
                    app.showAll = true;

                axios.get('/v1/lists/topListMonthly/' + limit)
                    .then(function (resp) {
                        app.active = 'monthly';
                        app.rows = resp.data;
                        app.loading = false;
                    })
                    .catch(function (resp) {
                        app.loading = false;
                        alert("Could not load rows");
                    });
            },
            topListYearly(limit = 0) {
                var app = this;
                app.loading = true;

                if(limit > 0)
                    app.showAll = false;
                else
                    app.showAll = true;

                axios.get('/v1/lists/topListYearly/' + limit)
                    .then(function (resp) {
                        app.active = 'yearly';
                        app.rows = resp.data;
                        app.loading = false;
                    })
                    .catch(function (resp) {
                        app.loading = false;
                        alert("Could not load rows");
                    });
            }
        }
    }
</script>