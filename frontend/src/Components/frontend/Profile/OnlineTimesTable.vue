<template>
    <table class="w-full max-h-56 text-left overflow-y-scroll mt-2">
        <thead>
        <tr>
            <th>Login</th>
            <th>Logout</th>
            <th>Status</th>
            <th>Mins</th>
        </tr>
        </thead>
        <tbody>
        <tr :key="onlineTime._id" class="text-[11px]" v-for="onlineTime in onlineTimes">
            <td>{{ onlineTime.login_time }}</td>
            <td>{{ onlineTime.logout_time }}</td>
            <td>{{ getStatuses[0][onlineTime.status] }}</td>
            <td>
                {{ subtractDates(onlineTime) }}
            </td>
        </tr>
        </tbody>
    </table>
</template>

<script>
import {mapActions, mapGetters} from "vuex";
import dayjs from "dayjs";

export default {
    name: "OnlineTimesTable",

    created() {
        this.onlineTimes = this.getProfileOnlineTimes;
    },
    data() {
        return {
            onlineTimes: [],
        }
    },
    methods: {
        ...mapActions([
            "fetchProfileRoomOnlineTimes",
        ]),
        subtractDates(time) {
            const login = dayjs(time.login_time, 'YYYY-MM-DD HH:ii')
            const logout = dayjs(time.logout_time, 'YYYY-MM-DD HH:ii');

            return !isNaN(login) && !isNaN(logout) ? logout.diff(login, 'minutes'): 0 ;
        }
    },
    computed: {
        ...mapGetters([
            "getProfileOnlineTimes",
            "getStatuses"
        ]),
    },
    components: {
        dayjs
    }
}
</script>

<style scoped>

</style>
