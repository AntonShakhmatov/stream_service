<template>
    <LayoutAuthenticated>
        <SectionMain>
            <SectionTitleLineWithButton :title="`Editácia room - ${room.username} - ${room.chat}`" :has-cog="false" />
            <CardBox is-form @submit.prevent="submitForm">
                <div class="grid grid-cols-4 gap-4">
                    <div>
                        <label for="username">Username</label>
                        <FormControl v-model="form.username" id="username" name="username"/>
                    </div>
                    <div>
                        <label for="age">Age</label>
                        <FormControl v-model="form.age" id="age" name="age" />
                    </div>
                    <div>
                        <label for="gender">Gender</label>
                        <Multiselect
                            :options="genders"
                            v-model="form.gender"
                            name="gender"
                            class="text-black"
                            id="gender"
                        />
                    </div>
                    <div>
                        <label for="location">Location</label>
                        <Multiselect
                            :options="locations"
                            v-model="form.location"
                            name="location"
                            id="location"
                            :searchable="true"
                            class="text-black"
                        />
                    </div>
                    <div>
                        <label for="language">Language</label>
                        <Multiselect
                            :options="languages"
                            v-model="form.language"
                            name="language"
                            :searchable="true"
                            class="text-black"
                            id="language"
                        />
                    </div>
                    <div>
                        <label for="ethnicity">Ethnicity</label>
                        <Multiselect
                            :options="ethnicity"
                            v-model="form.ethnicity"
                            name="ethnicity"
                            :searchable="true"
                            class="text-black"
                            id="ethnicity"
                        />
                    </div>
                    <div>
                        <label for="viewers">Viewers</label>
                        <FormControl v-model="form.viewers" id="viewers" name="viewers" />
                    </div>
                    <div class="grid grid-cols-3 items-center">
                        <div class="flex justify-center items-center">
                            <label for="dmca" class="pr-2">DMCA</label>
                            <input type="checkbox" v-model="form.dmca" name="dmca" id="dmca"  />
                        </div>
                        <div class="flex justify-center items-center">
                            <label for="new" class="pr-2">New</label>
                            <input type="checkbox" v-model="form.new" name="new" id="new"  />
                        </div>
                        <div class="flex justify-center items-center">
                            <label for="hd" class="pr-2">HD</label>
                            <input type="checkbox" v-model="form.hd" name="hd" id="hd">
                        </div>
                    </div>
                    <div>
                        <label for="height">Height</label>
                        <FormControl v-model="form.height" name="height" id="height" />
                    </div>
                    <div>
                        <label for="weight">Weight</label>
                        <FormControl v-model="form.weight" name="weight" id="weight" />
                    </div>
                    <div>
                        <label for="body_type">Body type</label>
                        <Multiselect
                            name="body_type"
                            v-model="form.body_type"
                            :options="bodyTypes"
                            id="body_type"
                        />
                    </div>
                    <div>
                        <label for="bust_penis_size">Bust penis size</label>
                        <Multiselect
                            name="bust_penis_size"
                            v-model="form.bust_penis_size"
                            label="Bust penis size"
                            :options="bustPenisSize"
                            id="bust_penis_size"
                        />
                    </div>
                    <div>
                        <label for="hair_color">Hair color</label>
                        <Multiselect
                            name="hair_color"
                            v-model="form.hair_color"
                            label="Hair color"
                            :options="hair_colors"
                            id="hair_color"
                        />
                    </div>
                    <div>
                        <label for="hair_length">Hair length</label>
                        <Multiselect
                            name="hair_length"
                            v-model="form.hair_length"
                            :options="hair_length"
                            id="hair_length"
                        />
                    </div>
                    <div>
                        <label for="sex_orientation">Sex orientation</label>
                        <Multiselect
                            name="sex_orientation"
                            v-model="form.sex_orientation"
                            :options="sexOrientation"
                            id="sex_orientation"
                        />
                    </div>
                    <div>
                        <label for="pubic_hair">Pubic hair</label>
                        <Multiselect
                            name="pubic_hair"
                            v-model="form.pubic_hair"
                            :options="pubicHair"
                            id="pubic_hair"
                        />
                    </div>
                    <div>
                        <label for="eye_color">Eye color</label>
                        <Multiselect
                            name="eye_color"
                            v-model="form.eye_color"
                            :options="eye_colors"
                            id="eye_color"
                        />
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="chatUrl">Chat url</label>
                        <FormControl v-model="form.chat_url" name="chatUrl" id="chatUrl" />
                    </div>
                    <div>
                        <label for="previewImage">Preview image url</label>
                        <FormControl v-model="form.previewImage" name="preview_image" id="previewImage" disabled />
                    </div>
                </div>
                <div>
                    <label for="subject">Subject</label>
                    <FormControl v-model="form.subject" name="subject" id="subject" />
                </div>
                <button type="submit" class="bg-transparent hover:bg-blue-500 text-white font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded mt-10">Save room</button>
            </CardBox>
        </SectionMain>
    </LayoutAuthenticated>
</template>
<!--Dorobit preview image, chat url, subject -->
<script setup>
import LayoutAuthenticated from '@/Layouts/LayoutAuthenticated.vue';
import SectionMain from "@/Components/SectionMain.vue";
import SectionTitleLineWithButton from "@/Components/SectionTitleLineWithButton.vue";
import CardBox from "@/Components/CardBox.vue";
import {useForm, router} from "@inertiajs/vue3";
import FormControl from "@/Components/FormControl.vue";
import Multiselect from "@vueform/multiselect";
import {computed} from "vue";

const props = defineProps({
    room: Object,
    locations: Object,
})

const submitForm = () => {
    const url = route('rooms.update', props.room.id);
    router.put(url, form);
}

const form = useForm({
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
});

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
