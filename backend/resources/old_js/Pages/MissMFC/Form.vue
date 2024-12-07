<script setup>
import { useForm } from '@inertiajs/vue3'
import LayoutAuthenticated from "@/Layouts/LayoutAuthenticated.vue";
import SectionMain from "@/Components/SectionMain.vue";
import CardBox from "@/Components/CardBox.vue";
import DatePicker from "@/Components/DatePicker.vue"
import BaseButton from "@/Components/BaseButton.vue";
import FormField from "@/Components/FormField.vue";
import FormFilePicker from "@/Components/FormFilePicker.vue";

const form = useForm({
    date: null,
    miss_mfc: null,
})

function submit() {
    form.post(route('mfcstats-miss.store'))
}
</script>

<template>
    <LayoutAuthenticated>
        <SectionMain>
            <CardBox is-form @submit.prevent="submit">

                    <FormField>
                        <DatePicker
                            v-model="form.date"
                        />
                    </FormField>
                    <FormFilePicker
                        v-model="form.miss_mfc"
                    />
                   <FormField>
                       <progress v-if="form.progress" :value="form.progress.percentage" max="100">
                           {{ form.progress.percentage }}%
                       </progress>
                   </FormField>
                   <FormField>
                       <BaseButton label="Submit" type="submit" />
                   </FormField>
            </CardBox>
        </SectionMain>
    </LayoutAuthenticated>
</template>
