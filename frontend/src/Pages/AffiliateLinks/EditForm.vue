<template>
    <div>
        <h2>Edit Affiliate Link</h2>
        <form @submit.prevent="updateLink">
            <div>
                <label for="stream">Stream:</label>
                <select v-model="form.stream_id" required>
                    <option v-for="(name, id) in streams" :key="id" :value="id">
                        {{ name }}
                    </option>
                </select>
            </div>

            <div>
                <label for="platform">Platform:</label>
                <input id="platform" v-model="form.platform" type="text" required />
            </div>

            <div>
                <label for="iframe_url">Iframe URL:</label>
                <input id="iframe_url" v-model="form.iframe_url" type="url" required />
            </div>

            <div>
                <label for="clickable_link">Clickable Link:</label>
                <input id="clickable_link" v-model="form.clickable_link" type="url" />
            </div>

            <button type="submit">Save</button>
            <button @click="goBack" type="button">Cancel</button>
        </form>
    </div>
</template>

<script>
import { useForm } from '@inertiajs/inertia-vue3';

export default {
    props: {
        link: Object,
        streams: Object,
    },
    setup(props) {
        const form = useForm({
            stream_id: props.link.stream_id,
            platform: props.link.platform,
            iframe_url: props.link.iframe_url,
            clickable_link: props.link.clickable_link,
        });

        const updateLink = () => {
            form.put(route('aff.update', props.link.id)); // Используем Ziggy для генерации маршрута
        };

        const goBack = () => {
            window.history.back();
        };

        return {
            form,
            updateLink,
            goBack,
        };
    },
};
</script>
