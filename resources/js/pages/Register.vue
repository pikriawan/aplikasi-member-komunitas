<script setup>
import { Form, Link } from '@inertiajs/vue3';
import HomeLayout from '../layouts/HomeLayout.vue';
</script>

<template>
    <HomeLayout>
        <h1 class="text-3xl font-medium">Daftar</h1>
        <Form class="flex flex-col items-start gap-3" action="/register" method="post" v-slot="{ errors }">
            <div class="flex flex-col gap-2">
                <label for="register_name">Nama</label>
                <input class="px-2 py-1 border border-neutral-950" id="register_name" name="name" />
                <p class="text-red-600 text-sm" v-if="errors.name">{{ errors.name }}</p>
            </div>
            <div class="flex flex-col gap-2">
                <label for="register_email">Email</label>
                <input class="px-2 py-1 border border-neutral-950" id="register_email" name="email" type="email" />
                <p class="text-red-600 text-sm" v-if="errors.email">{{ errors.email }}</p>
            </div>
            <div class="flex flex-col gap-2">
                <label for="register_telephone">Telephone</label>
                <input class="px-2 py-1 border border-neutral-950" id="register_telephone" name="telephone" />
                <p class="text-red-600 text-sm" v-if="errors.telephone">{{ errors.telephone }}</p>
            </div>
            <div class="flex flex-col gap-2">
                <label for="register_password">Password</label>
                <input class="px-2 py-1 border border-neutral-950" id="register_password" name="password" type="password" />
                <p class="text-red-600 text-sm" v-if="errors.password">{{ errors.password }}</p>
            </div>
            <div class="flex flex-col gap-2">
                <label for="register_confirmPassword">Konfirmasi password</label>
                <input class="px-2 py-1 border border-neutral-950" id="register_confirmPassword" name="confirmPassword" type="password" />
            </div>
            <button class="bg-blue-700 text-white px-4 py-2">Registrasi</button>
            <p>Sudah punya akun? <Link class="text-blue-600" href="/login">Login sekarang</Link></p>
        </Form>
    </HomeLayout>
</template>
