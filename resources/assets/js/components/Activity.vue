<template>
    <a v-on:click="$emit('show')" class="list-row button">
        <div class="row-child">
            <user-avatar v-if="showProfile == true" :link="false" :key="id" :id="id" :initials="initials" :avatar="avatar"></user-avatar>
            <span class="text-muted"><b>{{ activityName }}</b><br><small>{{ km }}km/{{ duration }}min</small></span>
        </div>
        <span class="amount xp">+{{ xp }} xp</span>
        <span class="date text-muted">{{ date }}</span>
    </a>
</template>

<style>
    .row-child {
        display: flex;
        align-items: center;
    }

    .row-child > *+* {
        margin-left: 25px;
    }
</style>

<script>
    import UserAvatar from './UserAvatar.vue';

    export default {
        data: function () {
            return {
                // 
            }
        },
        props: {
            showProfile: {
                required: false,
                default: 'true'
            },
            id: {
                type: Number,
                required: true
            },
            initials: {
                type: String,
                required: true,
            },
            avatar: {
                required: false,
                type: String,
                default: null
            },
            activityName: {
                type: String,
                required: true
            },
            xp: {
                type: Number,
                required: true
            },
            km: {
                required: true
            },
            duration: {
                required: true
            },
            date: {
                type: String,
                required: true
            }
        },
        components: {
            'user-avatar': UserAvatar,
        },
        mounted() {
            // 
        }
    }
</script>