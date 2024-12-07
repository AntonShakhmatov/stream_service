<template>
    <DatePicker
        v-model="value"
        mode="date"
        is24hr
        :popover="{visibility: 'focus'}"
    >
        <template v-slot="{ inputValue, inputEvents }">
            <input type="text" v-on="inputEvents" :value="inputValue" class="text-black">
        </template>
    </DatePicker>
</template>

<script setup>
import {DatePicker} from "v-calendar";
import "v-calendar/dist/style.css";
// import {defineProps} from "vue";
import dayjs from "dayjs";
import { computed } from "vue";

const props = defineProps({
    label: String,
    name: String,
    modelValue: Date | String,
});

const emit = defineEmits(["update:modelValue"]);

const value = computed({
    get: () => {
        const date = dayjs(props.modelValue);

        if (!date.isValid()) {
            return "";
        }

        if (props.mode === "date") {
            return date.format("YYYY-MM-DD");
        }
        return date.format("YYYY-MM-DD HH:mm");
    },
    set: (value) => {
        // if (usePage().props?.errors?.[props.name]) {
        //     delete usePage().props?.errors[props.name];
        // }

        const date = dayjs(value);

        if (!date.isValid()) {
            emit("update:modelValue", "");
            return;
        }

        if (props.mode === "date") {
            emit("update:modelValue", date.format("YYYY-MM-DD"));
        } else {
            emit("update:modelValue", date.format("YYYY-MM-DD HH:mm"));
        }
    },
});

</script>

<style scoped>

</style>
