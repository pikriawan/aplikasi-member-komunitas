<script setup>
import { Form, Link } from '@inertiajs/vue3';
import HomeLayout from '../layouts/HomeLayout.vue';
</script>

<template>
    <HomeLayout>
        <div class="bg-primary text-white flex p-8 lg:p-0 lg:px-4 lg:py-8 lg:justify-center">
            <div class="flex flex-col gap-4 lg:w-full lg:max-w-270 lg:flex-row lg:items-center lg:justify-between">
                <h1 class="text-2xl font-medium">Login</h1>
            </div>
        </div>
        <div class="flex p-8 lg:p-0 lg:px-4 lg:py-16 justify-center">
            <div class="w-full lg:max-w-lg flex">
                <Form class="w-full font-geist flex flex-col gap-8" action="/login" method="post" v-slot="{ errors }">
                    <div class="flex flex-col gap-2">
                        <label class="font-semibold" for="login_email">Email</label>
                        <input class="px-4 py-3 rounded-lg placeholder:text-[#CCCCCC] shadow-[0_0_0_0.0625rem_#CCCCCC_inset] focus:outline-0 focus:shadow-[0_0_0_0.0625rem_var(--color-primary)_inset]" id="login_email" name="email" type="email" placeholder="example@mail.com" />
                        <p class="text-[#FF0800] text-sm" v-if="errors.email">{{ errors.email }}</p>
                    </div>
                    <div class="flex flex-col gap-2">
                        <label class="font-semibold" for="login_password">Password</label>
                        <input class="px-4 py-3 rounded-lg placeholder:text-[#CCCCCC] shadow-[0_0_0_0.0625rem_#CCCCCC_inset] focus:outline-0 focus:shadow-[0_0_0_0.0625rem_var(--color-primary)_inset]" id="login_password" name="password" type="password" placeholder="Password" />
                        <p class="text-[#FF0800] text-sm" v-if="errors.password">{{ errors.password }}</p>
                        <div class="flex justify-end">
                            <Link class="text-primary" href="/forgot-password">Lupa password?</Link>
                        </div>
                    </div>
                    <button class="flex justify-center items-center bg-primary text-white font-medium px-4 py-3 rounded-lg">Login</button>
                    <p class="text-center">Belum daftar membership? <Link class="text-primary" href="/register">Daftar sekarang</Link></p>
                </Form>
            </div>
        </div>
    </HomeLayout>
</template>
