<template>
    <form @submit.prevent="login">
        <div class="mx-auto w-1/2">
            <div>
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
                <button class="btn-primary w-full" type="submit">Login</button>
                <div class="mt-2 text-center">
                    <Link
                        :href="route('user-account.create')"
                        class="text-sm text-gray-500"
                        >Need an account?</Link
                    >
                </div>
            </div>
        </div>
    </form>
</template>

<script setup>
import { Link, useForm } from "@inertiajs/vue3";

const form = useForm({
    email: null,
    password: null,
});

const login = () => form.post(route("login.store"));
</script>
