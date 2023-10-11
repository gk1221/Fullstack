<template>
    <form @submit.prevent="register">
        <div class="mx-auto w-1/2">
            <div>
                <label for="name" class="label">Your Name </label>
                <input
                    id="name"
                    type="text"
                    v-model="form.name"
                    class="input"
                />
                <div class="input-error" v-if="form.errors.name">
                    {{ form.errors.name }}
                </div>
            </div>
            <div class="mt-4">
                <label for="email" class="label">E-mail </label>
                <input
                    id="email"
                    type="text"
                    v-model="form.email"
                    class="input"
                />
                <div class="input-error" v-if="form.errors.email">
                    {{ form.errors.email }}
                </div>
            </div>
            <div class="mt-4">
                <label for="password" class="label">password</label>
                <input
                    id="password"
                    type="password"
                    v-model="form.password"
                    class="input"
                />
                <div class="input-error" v-if="form.errors.password">
                    {{ form.errors.password }}
                </div>
            </div>
            <div class="mt-4">
                <label for="password_confirmation" class="label"
                    >Confirm password</label
                >
                <input
                    id="password_confirmation"
                    type="password"
                    v-model="form.password_confirmation"
                    class="input"
                />
            </div>
            <div class="mt-4">
                <button class="btn-primary w-full" type="submit">
                    Create Account
                </button>
                <div class="mt-2 text-center">
                    <Link :href="route('login')" class="text-sm text-gray-500"
                        >Have an account?</Link
                    >
                </div>
            </div>
            <div></div>
        </div>
    </form>
</template>

<script setup>
import { useForm, Link } from "@inertiajs/vue3";

const form = useForm({
    name: null,
    email: null,
    password: null,
    password_confirmation: null,
});

const register = () => form.post(route("user-account.store"));
</script>
