<script setup>
import { Form, Link } from '@inertiajs/vue3';
import HomeLayout from '../layouts/HomeLayout.vue';
</script>

<template>
    <HomeLayout>
        <div class="bg-primary text-white flex p-8 lg:p-0 lg:px-4 lg:py-8 lg:justify-center">
            <div class="flex flex-col gap-4 lg:w-full lg:max-w-270 lg:flex-row lg:items-center lg:justify-between">
                <h1 class="text-2xl font-medium">Daftar Membership</h1>
            </div>
        </div>
        <div class="flex p-8 lg:p-0 lg:px-4 lg:py-16 justify-center">
            <div class="w-full lg:max-w-lg flex">
                <Form class="w-full font-geist flex flex-col gap-8" action="/register" method="post" v-slot="{ errors }">
                    <div class="flex flex-col gap-2">
                        <label class="font-semibold" for="register_name">Nama lengkap *</label>
                        <input class="px-4 py-3 rounded-lg placeholder:text-[#CCCCCC] shadow-[0_0_0_0.0625rem_#CCCCCC_inset]" id="register_name" name="name" placeholder="Nama lengkap" />
                        <p class="text-[#FF0800] text-sm" v-if="errors.name">{{ errors.name }}</p>
                    </div>
                    <div class="flex flex-col gap-2">
                        <label class="font-semibold" for="register_email">Email *</label>
                        <input class="px-4 py-3 rounded-lg placeholder:text-[#CCCCCC] shadow-[0_0_0_0.0625rem_#CCCCCC_inset]" id="register_email" name="email" type="email" placeholder="example@mail.com" />
                        <p class="text-[#FF0800] text-sm" v-if="errors.email">{{ errors.email }}</p>
                    </div>
                    <div class="flex flex-col gap-2">
                        <label class="font-semibold" for="register_telephone">Nomor telepon *</label>
                        <input class="px-4 py-3 rounded-lg placeholder:text-[#CCCCCC] shadow-[0_0_0_0.0625rem_#CCCCCC_inset]" id="register_telephone" name="telephone" type="tel" placeholder="Nomor telepon" />
                        <p class="text-[#FF0800] text-sm" v-if="errors.telephone">{{ errors.telephone }}</p>
                    </div>
                    <div class="flex flex-col gap-2">
                        <label class="font-semibold" for="register_password">Password *</label>
                        <input class="px-4 py-3 rounded-lg placeholder:text-[#CCCCCC] shadow-[0_0_0_0.0625rem_#CCCCCC_inset]" id="register_password" name="password" type="password" placeholder="Password" />
                        <p class="text-[#FF0800] text-sm" v-if="errors.password">{{ errors.password }}</p>
                    </div>
                    <div class="flex flex-col gap-2">
                        <label class="font-semibold" for="register_confirmPassword">Konfirmasi Password *</label>
                        <input class="px-4 py-3 rounded-lg placeholder:text-[#CCCCCC] shadow-[0_0_0_0.0625rem_#CCCCCC_inset]" id="register_confirmPassword" name="confirmPassword" type="password" placeholder="Konfirmasi password" />
                        <p class="text-[#FF0800] text-sm" v-if="errors.confirmPassword">{{ errors.confirmPassword }}</p>
                    </div>
                    <button class="flex justify-center items-center bg-primary text-white font-medium px-4 py-3 rounded-lg">Daftar</button>
                    <p class="text-center">Sudah memiliki akun? <Link class="text-primary" href="/login">Login</Link></p>
                </Form>
            </div>
        </div>
    </HomeLayout>
</template>
