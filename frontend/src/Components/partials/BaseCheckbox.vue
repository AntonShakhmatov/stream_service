<template>
    <div class='flex items-center'>
        <input
            :id="id"
            :name="id"
            @change="$emit('onChange')"
            type="checkbox"
            class="h-4 w-4 border-transparent rounded text-primary focus:ring-primary"
            :class="cssClass"
            :checked="checked"
        />
        <label :for="id" class="ml-3 min-w-0 flex-1 text-gray-300">
            {{ label }}
        </label>
    </div>
</template>

<script>
export default {
    name: "BaseCheckbox",
    props: {
        id: {
            type: String,
            required: true,
        },
        checked: {
            type: Boolean,
        },
        cssClass: {
            type: String,
            default: "",
        },
        label: {
            type: String,
            required: true,
        }
    }
}

</script>

<style scoped>

</style>
