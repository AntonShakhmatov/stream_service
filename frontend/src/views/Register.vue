<script>
import MainLayout from '@/views/layouts/MainLayout.vue';
import InputError from '@/components/partials/InputError.vue';
import InputLabel from '@/components/partials/InputLabel.vue';
import PrimaryButton from '@/components/partials/PrimaryButton.vue';
import TextInput from '@/components/partials/TextInput.vue';
import auth from "@/store/auth/auth"

export default {
    name: "Register",
    data() {
        return {
            form: {
                name: '',
                email: '',
                password: '',
                password_confirmation: '',
                terms: false,
                errors: [],
            }
        }
    },
    methods: {
        async submit() {
            await auth.post("/api/register", this.form).then( res => {
                this.$cookies.set("my_token", res.data.token);
                this.$router.push({name: "home"});
            }).catch(err => {
                this.form.errors = err.response.data.errors;
            });
        }
    },
    components: {
        MainLayout,InputError,InputLabel,PrimaryButton,TextInput
    }
}
</script>

<template>
    <MainLayout>

        <div class="h-screen w-full flex items-center justify-center">
            <form @submit.prevent="submit" class="flex flex-col gap-5 p-5 rounded-md bg-secondary-color w-96">
                <img src="@/assets/images/logo.png" alt="Mycamstars.net">
                <div>
                    <InputLabel for="name" value="Name" class="text-white" />

                    <TextInput
                        id="name"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.name"
                        required
                        autofocus
                        autocomplete="name"
                    />

                    <InputError class="mt-2" :message="form.errors?.name" />
                </div>

                <div class="mt-4">
                    <InputLabel for="email" value="Email" class="text-white" />

                    <TextInput
                        id="email"
                        type="email"
                        class="mt-1 block w-full"
                        v-model="form.email"
                        required
                        autocomplete="username"
                    />

                    <InputError class="mt-2" :message="msg" v-for="msg in form.errors?.email" />
                </div>

                <div class="mt-4">
                    <InputLabel for="password" value="Password" class="text-white" />

                    <TextInput
                        id="password"
                        type="password"
                        class="mt-1 block w-full"
                        v-model="form.password"
                        required
                        autocomplete="new-password"
                    />

                    <InputError class="mt-2" :message="msg" v-for="msg in form.errors?.password" />
                </div>

                <div class="mt-4">
                    <InputLabel for="password_confirmation" value="Confirm Password" class="text-white" />

                    <TextInput
                        id="password_confirmation"
                        type="password"
                        class="mt-1 block w-full"
                        v-model="form.password_confirmation"
                        required
                        autocomplete="new-password"
                    />

                    <InputError class="mt-2" :message="form.errors?.password_confirmation" />
                </div>

                <div class="flex items-center justify-end mt-4">
                    <router-view
                        :to="{name: 'login'}"
                        class="underline text-sm text-white hover:text-white rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    >
                        Already registered?
                    </router-view>

                    <PrimaryButton class="ml-4 bg-primary-color" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        Register
                    </PrimaryButton>
                </div>
            </form>
        </div>
    </MainLayout>
</template>
