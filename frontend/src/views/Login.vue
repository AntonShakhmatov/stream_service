<script>
import Checkbox from '@/components/partials/Checkbox.vue';
import MainLayout from '@/views/layouts/MainLayout.vue'
import InputError from '@/components/partials/InputError.vue';
import InputLabel from '@/components/partials/InputLabel.vue';
import PrimaryButton from '@/components/partials/PrimaryButton.vue';
import TextInput from '@/components/partials/TextInput.vue';
import {mapActions, mapGetters} from "vuex";
import { toast } from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';

export default {
    components: {MainLayout, Checkbox, InputLabel, InputError, PrimaryButton,TextInput},
    data() {
        return {
            form: {
                email: "",
                password: "",
                remember: false,
            }
        }
    },
    created() {
        if (this.$cookies.get("my_token")?.name) {
            this.$router.push({name: "home"});
            toast.info("Still logged in");
        }
    },

    methods: {
        ...mapActions('auth', [
            'login',
            "getToken",
        ]),
        async submit() {
            const res = await this.login(this.form);

            if (res?.response?.data?.message) {
                toast.error(res?.response?.data?.message);
            }

            if (this.getUser && res === "success") {

                this.$cookies.set("my_token", this.getToken, "2h");

                this.$router.push({name: "home"});
                toast.success("Logged successfully");
            }
        },
    },
    computed: {
        ...mapGetters('auth',[
            "getUser",
            "getToken",
        ])
    }
}
</script>

<template>
    <MainLayout>
        <div class="h-screen w-full flex items-center justify-center">
            <form @submit.prevent="submit" class="flex flex-col gap-5 p-5 rounded-md bg-secondary-color w-96">
                <img src="@/assets/images/logo.png" alt="MyCamStars.com">
                <div>
                    <InputLabel for="email" value="Email" class="text-white" />

                    <TextInput
                        id="email"
                        type="email"
                        class="mt-1 block w-full"
                        v-model="form.email"
                        required
                        autofocus
                        autocomplete="username"
                    />

                    <InputError class="mt-2" :message="form.errors?.email" />
                </div>

                <div class="mt-4">
                    <InputLabel for="password" value="Password" class="text-white" />

                    <TextInput
                        id="password"
                        type="password"
                        class="mt-1 block w-full"
                        v-model="form.password"
                        required
                        autocomplete="current-password"
                    />

                    <InputError class="mt-2" :message="form.errors?.password" />
                </div>

                <div class="block mt-4">
                    <label class="flex items-center">
                        <Checkbox name="remember" v-model:checked="form.remember" />
                        <span class="ml-2 text-sm text-white">Remember me</span>
                    </label>
                </div>

                <div class="flex items-center justify-end mt-4">
                    <PrimaryButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        Log in
                    </PrimaryButton>
                </div>
            </form>
        </div>
    </MainLayout>
</template>
