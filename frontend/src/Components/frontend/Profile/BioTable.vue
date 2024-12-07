<template>
    <div>
        <table class="w-full text-left">
            <tbody>
            <tr>
                <th>Age</th>
                <td class="w-full text-center">
                    {{ room?.age || '-'}}
                </td>
            </tr>
            <tr>
                <th>Gender</th>
                <td class="w-full text-center">
                    {{ parseRoomGender(room?.gender) || '-' }}
                </td>
            </tr>
            <tr>
                <th>Ethnicity</th>
                <td class="w-full text-center">
                    {{ room?.ethnicity || '-' }}
                </td>
            </tr>
            <tr>
                <th>Location</th>
                <td class="w-full text-center">
                    {{ room?.location || '-' }}
                </td>
            </tr>
            <tr>
                <th>Chat</th>
                <td class="w-full text-center">
                    {{ getChats[0][this.room.chat] || '-' }}
                </td>
            </tr>
            <tr>
                <th>Status</th>
                <td class="w-full text-center">
                    {{ getStatuses[0][this.room.status] || '-' }}
                </td>
            </tr>
            <tr>
                <th>Body type</th>
                <td class="w-full text-center">
                    {{ room?.body_type || '-' }}
                </td>
            </tr>
            <tr>
                <th>Height</th>
                <td class="w-full text-center">
                    {{ room?.height ? `${room?.height} cm` : '-' }}
                </td>
            </tr>
            <tr>
                <th>Weight</th>
                <td class="w-full text-center">
                    {{ room?.weight ? `${room?.weight} kg` : '-' }}
                </td>
            </tr>
            <tr>
                <th>Hair color</th>
                <td class="w-full text-center">
                    {{ room?.hair_color || '-' }}
                </td>
            </tr>
            <tr>
                <th>Eye color</th>
                <td class="w-full text-center">
                    {{ room?.eye_color || '-' }}
                </td>
            </tr>
            <tr>
                <th class="whitespace-nowrap">Sex orientation</th>
                <td class="w-full text-center">
                    {{ room?.sex_orientation || '-' }}
                </td>
            </tr>
            <tr>
                <th>Pubic hair</th>
                <td class="w-full text-center">
                    {{ room?.pubic_hair || '-' }}
                </td>
            </tr>
            <tr>
                <th class="whitespace-nowrap">Bust/penis size</th>
                <td class="w-full text-center">
                    {{ room?.bust_penis_size || '-' }}
                </td>
            </tr>
            <tr>
                <th>Languages</th>
                <td class="w-full text-center">
                    {{ room?.language || '-' }}
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
import {parseGender} from "@/helpers";
import {mapGetters} from "vuex";

export default {
    name: "BioTable",
    props: {
        room: Object,
    },
    methods: {
      parseRoomGender() {
          return parseGender(this.room.gender);
      }
    },
    computed: {
        ...mapGetters([
            "getChats",
            "getStatuses",
        ])
    }
}
</script>

<style scoped>

</style>
