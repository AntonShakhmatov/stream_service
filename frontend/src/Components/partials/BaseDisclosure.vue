<template>
    <Disclosure as="div" class="border-t border-gray-200 p-4">
        <h3 class="-mx-2 -my-3 flow-root">
            <DisclosureButton class="w-full flex items-center justify-between text-gray-100 hover:text-primary" @click="open = !open">
                <span class="font-medium text-gray-200">{{ sectionName }}</span>
                <span class="ml-6 flex items-center">
                    <font-awesome-icon :icon="['fass', 'minus']" v-if="open"  />

                    <font-awesome-icon :icon="['fass', 'plus']" v-if="!open" />
                </span>
            </DisclosureButton>
        </h3>
        <DisclosurePanel class="pt-4">
            <div class="space-y-2">
                <slot />
            </div>
        </DisclosurePanel>
    </Disclosure>
</template>

<script>
import {Disclosure, DisclosureButton, DisclosurePanel} from "@headlessui/vue";

export default {
    name: "BaseDisclosure",
    components: {Disclosure, DisclosureButton, DisclosurePanel},
    props: {
        sectionName: String,
    },
    data() {
        return {
            open: false,
        }
    }
}
</script>
