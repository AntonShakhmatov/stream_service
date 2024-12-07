<template>
    <PageHeader :title="`Editácia room - ${room.username} - ${room.chat}`" />
    <PageContent>
        <div class="grid grid-cols-4 gap-4">
            <div>
                <TextInput
                    v-model="form.username" id="username" name="username"
                    label="Username"
                    label-class="text-white"
                />
            </div>
            <div>
                <TextInput
                    v-model="form.age"
                    name="age"
                    label="Age"
                    label-class="text-white"
                />
            </div>
            <div>
                <Multiselect
                    :options="genders"
                    v-model="form.gender"
                    name="gender"
                    class="text-black"
                    mode="single"
                    label-class="text-white"
                    label="Gender"
                />
            </div>
            <div>
                <Multiselect
                    :options="locations"
                    v-model="form.location"
                    name="location"
                    id="location"
                    :searchable="true"
                    class="text-black"
                    mode="single"
                    label="Location"
                    label-class="text-white"
                />
            </div>
            <div>
                <Multiselect
                    :options="languages"
                    v-model="form.language"
                    name="language"
                    :searchable="true"
                    class="text-black"
                    mode="single"
                    label="Language"
                    label-class="text-white"
                />
            </div>
            <div>
                <Multiselect
                    :options="ethnicity"
                    v-model="form.ethnicity"
                    name="ethnicity"
                    :searchable="true"
                    class="text-black"
                    label="Ethnicity"
                    mode="single"
                    label-class="text-white"
                />
            </div>
            <div>
                <TextInput
                    v-model="form.viewers"
                    name="viewers"
                    label="Viewers"
                    label-class="text-white"
                />
            </div>
            <div class="grid grid-cols-3 items-center">
                <div class="flex justify-center items-center">
                    <Checkbox v-model="form.dmcs" name="dmca" label="DMCA" label-class="text-white" />
                </div>
                <div class="flex justify-center items-center">
                    <Checkbox v-model="form.new" name="new" label="New" label-class="text-white"  />
                </div>
                <div class="flex justify-center items-center">
                    <Checkbox v-model="form.hd" name="hd" label="HD" label-class="text-white" />
                </div>
            </div>
            <div>
                <TextInput
                    v-model="form.height"
                    name="height"
                    label="Height"
                    label-class="text-white"
                />
            </div>
            <div>
                <TextInput
                    v-model="form.weight"
                    name="weight"
                    label="Weight"
                    label-class="text-white"
                />
            </div>
            <div>
                <Multiselect
                    name="body_type"
                    v-model="form.body_type"
                    :options="bodyTypes"
                    mode="single"
                    label="Body type"
                    label-class="text-white"
                />
            </div>
            <div>
                <Multiselect
                    name="bust_penis_size"
                    v-model="form.bust_penis_size"
                    label="Bust penis size"
                    :options="bustPenisSize"
                    label-class="text-white"
                />
            </div>
            <div>
                <Multiselect
                    name="hair_color"
                    v-model="form.hair_color"
                    label="Hair color"
                    :options="hair_colors"
                    label-class="text-white"
                />
            </div>
            <div>
                <Multiselect
                    name="hair_length"
                    v-model="form.hair_length"
                    :options="hair_length"
                    label-class="text-white"
                    label="Hair length"
                />
            </div>
            <div>
                <Multiselect
                    name="sex_orientation"
                    v-model="form.sex_orientation"
                    :options="sexOrientation"
                    id="sex_orientation"
                    label-class="text-white"
                    label="Sex orientation"
                />
            </div>
            <div>
                <Multiselect
                    name="pubic_hair"
                    v-model="form.pubic_hair"
                    :options="pubicHair"
                    label-class="text-white"
                    label="Pubic hair"
                />
            </div>
            <div>
                <Multiselect
                    name="eye_color"
                    v-model="form.eye_color"
                    :options="eye_colors"
                    label-class="text-white"
                    label="Eye color"
                />
            </div>
        </div>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <TextInput
                    v-model="form.chat_url"
                    name="chatUrl"
                    label="Chat url"
                    label-class="text-white"
                />
            </div>
            <div>
                <TextInput
                    v-model="form.previewImage"
                    name="preview_image"
                    disabled
                    label="Preview image url"
                    label-class="text-white"
                />
            </div>
        </div>
        <div>
            <TextInput
                v-model="form.subject"
                name="subject"
                label="Subject"
                label-class="text-white"
            />
        </div>
        <button @click="submit" class="bg-transparent hover:bg-blue-500 text-white font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded mt-10">Save room</button>
    </PageContent>
</template>
<!--Dorobit preview image, chat url, subject -->
<script setup lang="ts">
import {router} from "@inertiajs/vue3";
import {computed} from "vue";
import {PageHeader, PageContent} from "@/components"
import {TextInput, Multiselect,Checkbox} from "@/components";
import { useForm } from "@/hooks/useForm";
import {RoomForm} from "@/Pages/Rooms/types";

const props = defineProps({
    room: Object,
    locations: Object,
})


const {form, submit } = useForm<RoomForm>(
    {
    username: props.room.username,
    age: props.room.age,
    gender: props.room.gender,
    location: props.room.location,
    language: props.room.language,
    ethnicity: props.room.ethnicity,
    viewers: props.room.viewers,
    previewImage: props.room.preview_image,
    chat_url: props.room.chat_url,
    new: props.room.new,
    hd: props.room.hd,
    dmca: props.room.dmca,
    subject: props.room.subject,
    height: props.room.height,
    weight: props.room.weight,
    body_type: props.room.body_type,
    bust_penis_size: props.room.bust_penis_size,
    hair_color: props.room.hair_color,
    hair_length: props.room.hair_length,
    sex_orientation: props.room.sex_orientation,
    pubic_hair: props.room.pubic_hair,
    eye_color: props.room.eye_color,
    tags: props.room.tags,
}, route('rooms.update', props.room.id), 'put');

const genders = computed(() => [
    'Female', 'Male', 'Couple', 'Trans',
]);
const languages = computed(() => [
    'English', 'Spanish', 'Russian', 'French', 'German', 'Italian', 'Dutch', 'Portuguese', 'Other',
]);
const chats = computed(() => [
    'chaturbate', 'bongacams', 'myfreecams', 'cam4', 'camsoda'
]);
const bodyTypes = computed(() => [
    'Petite', 'Slim', 'Athletic', 'Average', 'Curvy', 'Muscular', 'BBW', 'Other'
]);
const ethnicity = computed(() => [
    'Arabian', 'Asian', 'Black/Ebony', 'Indian', 'Hispanic', 'Middle Eastern', 'White', 'Other'
]);
const eye_colors = computed(() => [
    'Black', 'Brown', 'Blue', 'Green', 'Hazel', 'Gray', 'Other',
]);
const hair_colors = computed(() => [
    'black', 'brown', 'Red', 'Blonde', 'Other'
]);
const hair_length = computed(() => [
    'Bold', 'Short', 'Shoulder', 'Long', 'Other'
]);
const bustPenisSize = computed(() => [
    'Tiny', 'Small', 'Average', 'Big', 'Huge', 'Other'
]);
const pubicHair = computed(() => [
    'Shaved', 'Trimmed', 'Hairy', 'Other'
]);
const sexOrientation = computed(() => [
    'Straight', 'Bi-curious', 'Bisexual', 'Gay/Lesbian', 'Other'
])

</script>

<style src="@vueform/multiselect/themes/default.css"></style>
