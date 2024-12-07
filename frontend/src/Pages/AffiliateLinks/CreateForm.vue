<template>
    <div class="create-form">
        <h1 class="text-2xl font-bold mb-4">Create Aff. Link</h1>
        <form @submit.prevent="submit">
            <div class="mb-4" >
                <label for="platform" class="block text-sm font-medium text-gray-700">Platform</label>
                <select type="text" id="platform" v-model="form.platform"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <option disabled value="">Choose one of platforms</option>
                        <option>Chaturbate</option>
                        <option>MyFreeCams</option>
                        <option>Cam4</option>
                        <option>Camsoda</option>
                        <option>Stripchat</option>
                        <option>Bongacams</option>
                </select>
                    <!-- <input type="text" id="platform" v-model="form.platform"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" /> -->
                <span v-if="errors.platform" class="text-red-500 text-sm">{{ errors.platform }}</span>
            </div>

            <div class="mb-4">
                <label for="url" class="block text-sm font-medium text-gray-700">URL</label>
                <input type="text" id="url" v-model="form.url"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" />
                <span v-if="errors.url" class="text-red-500 text-sm">{{ errors.url }}</span>
            </div>

            <div class="flex justify-end">
                <button type="submit"
                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Save
                </button>
            </div>
        </form>
    </div>
</template>

<script>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';

export default {
    props: {
        streams: {
            type: Object,
            required: true,
        },
    },
    setup() {
        const form = useForm({
            platform: '',
            url: '',
        });

        const errors = ref({});

        const submit = async () => {
            form.post(route('aff.store'), {
                onError: (err) => {
                    errors.value = err; // Обработка ошибок
                },
                onFinish: () => {
                    // Дополнительная логика после отправки, например, редирект
                    if (!errors.value) {
                        window.location.href = '/aff'; // Перенаправление после успешной отправки
                    }
                },
            });
        };

        return {
            form,
            errors,
            submit,
        };
    },
};
</script>

<style scoped>
.create-form {
    max-width: 600px;
    margin: 0 auto;
}
</style>
