<template>
    <data-table :data="getData()" class="w-full bg-background-secondary text-white">
        <thead>
        <tr>
            <th class="p-2 border">Name</th>
            <th class="p-2 border">Age</th>
            <th class="p-2 border">Gender</th>
            <th class="p-2 border">Country</th>
            <th class="p-2 border">Follows</th>
            <th class="p-2 border">Last m.</th>
        </tr>
        </thead>
    </data-table>
<!--    <table class="w-full bg-background-secondary text-white">-->
<!--        <thead>-->
<!--        <tr class="text-left">-->
<!--            <th class="p-2 border">Name</th>-->
<!--            <th class="p-2 border">Age</th>-->
<!--            <th class="p-2 border">Gender</th>-->
<!--
      </tr>-->
<!--        </thead>-->
<!--        <tbody>-->
<!--        <tr v-for="(room, idx) in rooms.data" :key="idx" class="border border-[#252526] hover:border-b-primary-color">-->
<!--           <td class="py-3 px-1">-->
<!--                {{ rowId(idx) }}. {{ room.username }}-->
<!--            </td>-->
<!--            <td class="py-3 px-1 text-center">{{ room.age }}</td>-->
<!--            <td class="py-3 px-1 text-center">{{ room.gender }}</td>-->
<!--            <td class="py-3 px-1 text-center">-->
<!--                <div class="flex justify-center gap-2">-->
<!--                    <object-->
<!--                        :data="locationImageUrl(room)"-->
<!--                        type="image/png"-->
<!--                        class=" !bg-cover !bg-no-repeat"-->
<!--                    >-->
<!--                        <img-->
<!--                            src="/assets/flags/unspecified-country.png"-->
<!--                            :title="room.location"-->
<!--                            :alt="room.location"-->
<!--                            style="height: 24px;"-->
<!--                        />-->
<!--                    </object>-->
<!--                    {{ room.location }}-->
<!--                </div>-->
<!--            </td>-->
<!--            <td class="py-3 px-1 text-center">{{ room.viewers }}</td>-->
<!--            <td class="py-3 px-1 text-center">{{ room.viewers }}</td>-->
<!--            <td class="py-3 px-1 text-center">{{ room.viewers }}</td>-->
<!--        </tr>-->
<!--        </tbody>-->
<!--    </table>-->
</template>

<script>
import DataTable from 'datatables.net-vue3'
import DataTablesLib from 'datatables.net';
import dayjs from "dayjs";

DataTable.use(DataTablesLib);
export default {
    name: "StatsTable",
    props: {
        rooms: Object,
    },
    methods: {
        locationImageUrl(room) {
            const normalizedLocation = room.location?.toLowerCase().replaceAll(' ', '-')
            return `/assets/flags/${normalizedLocation}.png`
        },
        rowId(idx) {
            const page = this.rooms.current_page;
            if (page) {
                return ( idx + 1 + parseInt((page-1) +"00"));
            } else {
                return idx +1;
            }
        },
        getData() {
            let data = [];
            this.rooms.data.forEach((item) => {
                data.push([
                    item.username,
                    item.age,
                    item.gender,
                    item.location,
                    item.cb_followers,
                    dayjs(item.last_seen).format("D.M.YYYY HH:mm"),
                ]);
            })
            return data;
        }
    },
    components: {
        DataTable
    }
}
</script>

<style lang="scss">
.datatable {
    color: white;
    .col-sm-12 {
        width: 100%;
    }
    .col-md-6 {
        width: 50%;
    }
}
#DataTables_Table_0_info {
    margin-top: 10px;
}
#DataTables_Table_0_filter {
    display: inline-flex;
    width: 50%;
    justify-content: flex-end;
    margin-bottom: 10px;

    input[type=search] {
        color: black;
    }
}
#DataTables_Table_0_length {
    display: inline-flex;
    width: 50%;
    margin-bottom: 10px;

    select {
        color: black;
    }
}

#DataTables_Table_0_paginate {
    display: flex;
    justify-content: center;
    align-items: center;

    .previous {
        padding: 2px 10px;
        border: 1px solid white;
        border-radius: 5px;
        margin-right: 5px;
        background: black;
        &:hover {
            cursor:pointer;
            background: #0177E5FF;
        }
    }
    .next {
        padding: 2px 10px;
        border: 1px solid white;
        border-radius: 5px;
        margin-left: 5px;
        background: black;
        &:hover {
            background: rgb(1 119 229);
        }
    }
    .paginate_button {
        padding: 2px 10px;
        border: 1px solid white;
        border-radius: 5px;
        margin-left: 5px;
        background: black;
        &:hover {
            background: rgb(1 119 229);
        }
    }
}

</style>
