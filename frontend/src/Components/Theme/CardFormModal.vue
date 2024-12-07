<template>
    <OverlayLayer v-show="value" @overlay-click="cancel">
        <CardBox
            v-show="value"
            class="shadow-lg max-h-modal w-11/12 md:w-3/5 lg:w-2/5 xl:w-4/12 z-50"
            is-modal
        >
            <CardBoxComponentTitle :title="title">
                <BaseButton
                    v-if="hasCancel"
                    :icon="mdiClose"
                    color="whiteDark"
                    small
                    rounded-full
                    @click.prevent="cancel"
                />
            </CardBoxComponentTitle>

            <div class="space-y-3">
                <slot />
            </div>

            <template #footer>
                <BaseButtons>
                    <BaseButton :label="buttonLabel" :color="button" @click="confirm" />
                    <BaseButton v-if="hasCancel" label="Cancel" :color="button" outline @click="cancel" />
                </BaseButtons>
            </template>
        </CardBox>
    </OverlayLayer>
</template>

<script setup>
import OverlayLayer from '@/components/OverlayLayer.vue';
import CardBox from '@/components/CardBox.vue';
import CardBoxComponentTitle from "@/components/CardBoxComponentTitle.vue";
import BaseButton from "@/components/BaseButton.vue";
import BaseButtons from "@/components/BaseButtons.vue";


</script>

