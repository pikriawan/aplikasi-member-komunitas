<script setup>
import { Form, Link } from '@inertiajs/vue3';
import HomeLayout from '../../layouts/HomeLayout.vue';
</script>

<template>
    <HomeLayout>
        <h1 class="text-3xl font-medium">Login</h1>
        <Form class="flex flex-col items-start gap-3" action="/auth/login" method="post" #default="{ errors }">
            <div class="flex flex-col gap-2">
                <label for="login_email">Email</label>
                <input class="px-2 py-1 border border-neutral-950" id="login_email" name="email" type="email" />
                <p class="text-red-600 text-sm" v-if="errors.email">{{ errors.email }}</p>
            </div>
            <div class="flex flex-col gap-2">
                <label for="login_password">Password</label>
                <input class="px-2 py-1 border border-neutral-950" id="login_password" name="password" type="password" />
                <p class="text-red-600 text-sm" v-if="errors.password">{{ errors.password }}</p>
            </div>
            <button class="bg-blue-700 text-white px-4 py-2">Login</button>
            <p class="text-red-600 text-sm" v-if="errors.general">{{ errors.general }}</p>
            <p>Belum punya akun? <Link class="text-blue-600" href="/auth/register">Daftar sekarang</Link></p>
        </Form>
    </HomeLayout>
</template>
