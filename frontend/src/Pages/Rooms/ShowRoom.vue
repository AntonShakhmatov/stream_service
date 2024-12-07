<template>
    <Modal :open="openModal" :external-open="true">
        <template #title>
            <h1>Zobrazenie Room : {{ room.username }} - {{ room.chat }}</h1>
        </template>
        <template #content>
            <div class="grid grid-cols-3 gap-3">
                <p><span class="font-bold text-black">Username</span>: <br> {{ room.username }}</p>
                <p><span class="font-bold text-black">Chat</span>: <br> {{ chats[room.chat] }}</p>
                <p><span class="font-bold text-black">Gender</span>: <br> {{ genders(room.gender) }}</p>
                <p><span class="font-bold text-black">Age</span>: <br> {{ room.age }}</p>
                <p><span class="font-bold text-black">Location</span>: <br> {{ room.location }}</p>
                <p><span class="font-bold text-black">Language</span>: <br> {{ room.language }}</p>
                <p><span class="font-bold text-black">Ethnicity</span>: <br> {{ room.ethnicity ?? '-' }}</p>
                <p><span class="font-bold text-black">New</span>: <br> {{ room.new }}</p>
                <p><span class="font-bold text-black">HD</span>: <br> {{ room.hd }}</p>
                <p><span class="font-bold text-black">DMCA</span>: <br> {{ room.dmca }}</p>
                <p><span class="font-bold text-black">Height</span>: <br> {{ room.height ?? '-' }}</p>
                <p><span class="font-bold text-black">Weight</span>: <br> {{ room.weight ?? '-' }}</p>
                <p><span class="font-bold text-black">Body type</span>: <br> {{ room.body_type ?? '-' }}</p>
                <p><span class="font-bold text-black">Hair color</span>: <br> {{ room.hair_color ?? '-' }}</p>
                <p><span class="font-bold text-black">Hair length</span>: <br> {{ room.hair_length ?? '-' }}</p>
                <p><span class="font-bold text-black">Eye color</span>: <br> {{ room.eye_color ?? '-' }}</p>
                <p><span class="font-bold text-black">Bust penis size</span>: <br> {{ room.bust_penis_size ?? '-' }}</p>
                <p><span class="font-bold text-black">Sex orientation</span>: <br> {{ room.sex_orientation ?? '-' }}</p>
                <p><span class="font-bold text-black">Pubic hair</span>: <br> {{ room.pubic_hair ?? '-' }}</p>
            </div>
            <p><span class="font-bold text-black">Tags</span>: <br> <span v-for="tag in room.tags">{{ tag }}, </span></p>
            <p><span class="font-bold text-black">Chat url</span>: <br> {{ room.chat_url }}</p>
            <div>
                <p><span class="font-bold text-black">Preview image</span>: <br> <img :src="room.preview_image" alt="Preview image"></p>
            </div>
        </template>

        <template #buttons="{ setIsOpen }">
            <Button
                @click="closeModal"
                color="gray"
                variant="outline"
            >
                <!-- {{ $t("mycustomadmin", "Close") }} -->
                {{ $t("Close") }}
            </Button>
        </template>
    </Modal>
</template>

<script setup lang="ts">
import {Modal, Button} from "@/components";
// import {defineEmits} from "vue";

interface Props {
    openModal:boolean,
    room: Object,
    chats: Object,
}

const emit = defineEmits(['toggleModal']);

const closeModal = () => {
    emit('toggleModal');
}

const props = defineProps<Props>();

const genders = (gender: string) => {
    switch (gender) {
        case "m":
        case "male":
            gender = "Male";
            break;
        case "f":
        case "female":
            gender =  "Female";
            break;
        case "c":
        case "couple":
            gender =  "Couple";
            break;
        case "t":
        case "trans":
        case "transgender":
            gender =  "Trans";
            break;
    }
    return gender;
};
</script>
