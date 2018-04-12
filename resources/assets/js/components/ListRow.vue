<template>
    <div class="list-row with-progress">
        <user-avatar :link="true" :key="id" :id="id" :initials="initials" :avatar="avatar"></user-avatar>
        <div class="row-progress-bar" v-bind:class="{ inactive: score <= 0 }">
            <div class="row-progress" v-bind:style="{ width: comparison }">
                <span v-if="score > 0" class="progress-amount">{{ score }}xp</span>
            </div>
        </div>
        
    </div>
</template>

<script>
    import UserAvatar from './UserAvatar.vue';

    export default {
        props: {
            id: {
                type: Number,
                required: true
            },
            initials: {
                type: String,
                required: true
            },
            avatar: {
                type: String,
                required: false
            },
            comparison: {
                type: String,
                required: true
            },
            score: {
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