<script setup>
import { Form, Link, usePage } from "@inertiajs/vue3";
import HomeLayout from "../layouts/HomeLayout.vue";
import { computed, onMounted, ref } from "vue";

const page = usePage();

const token = ref("");
const email = ref("");

onMounted(() => {
    token.value = new URL(page.url, window.location.origin).pathname.split("/").at(-1);
    email.value = new URLSearchParams(window.location.search).get("email");
});

const passwordShow = ref(false);
const confirmPasswordShow = ref(false);
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
                <Form class="w-full font-geist flex flex-col gap-8" action="/reset-password" method="post" v-slot="{ errors }">
                    <input type="hidden" name="token" :value="token" />
                    <div class="flex flex-col gap-2">
                        <label class="font-semibold" for="resetPassword_email">Email</label>
                        <input class="px-4 py-3 rounded-lg placeholder:text-[#CCCCCC] shadow-[0_0_0_0.0625rem_#CCCCCC_inset] focus:outline-0 focus:shadow-[0_0_0_0.0625rem_var(--color-primary)_inset]" id="resetPassword_email" name="email" type="email" placeholder="example@mail.com" :value="email" />
                        <p class="text-[#FF0800] text-sm" v-if="errors.email">{{ errors.email }}</p>
                    </div>
                    <div class="flex flex-col gap-2">
                        <label class="font-semibold" for="resetPassword_password">Password</label>
                        <div class="relative">
                            <input class="w-full pl-4 pr-12 py-3 rounded-lg placeholder:text-[#CCCCCC] shadow-[0_0_0_0.0625rem_#CCCCCC_inset] focus:outline-0 focus:shadow-[0_0_0_0.0625rem_var(--color-primary)_inset]" id="resetPassword_password" name="password" :type="passwordShow ? 'text' : 'password'" placeholder="Password" />
                            <button class="absolute top-0 right-0 h-full aspect-square flex justify-center items-center" type="button" @click="passwordShow = !passwordShow">
                                <svg v-if="passwordShow" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-eye-off-icon lucide-eye-off"><path d="M10.733 5.076a10.744 10.744 0 0 1 11.205 6.575 1 1 0 0 1 0 .696 10.747 10.747 0 0 1-1.444 2.49"/><path d="M14.084 14.158a3 3 0 0 1-4.242-4.242"/><path d="M17.479 17.499a10.75 10.75 0 0 1-15.417-5.151 1 1 0 0 1 0-.696 10.75 10.75 0 0 1 4.446-5.143"/><path d="m2 2 20 20"/></svg>
                                <svg v-else xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-eye-icon lucide-eye"><path d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0"/><circle cx="12" cy="12" r="3"/></svg>
                            </button>
                        </div>
                        <p class="text-[#FF0800] text-sm" v-if="errors.password">{{ errors.password }}</p>
                    </div>
                    <div class="flex flex-col gap-2">
                        <label class="font-semibold" for="resetPassword_confirmPassword">Konfirmasi password</label>
                        <div class="relative">
                            <input class="w-full pl-4 pr-12 py-3 rounded-lg placeholder:text-[#CCCCCC] shadow-[0_0_0_0.0625rem_#CCCCCC_inset] focus:outline-0 focus:shadow-[0_0_0_0.0625rem_var(--color-primary)_inset]" id="resetPassword_confirmPassword" name="password_confirmation" :type="confirmPasswordShow ? 'text' : 'password'" placeholder="Konfirmasi password" />
                            <button class="absolute top-0 right-0 h-full aspect-square flex justify-center items-center" type="button" @click="confirmPasswordShow = !confirmPasswordShow">
                                <svg v-if="confirmPasswordShow" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-eye-off-icon lucide-eye-off"><path d="M10.733 5.076a10.744 10.744 0 0 1 11.205 6.575 1 1 0 0 1 0 .696 10.747 10.747 0 0 1-1.444 2.49"/><path d="M14.084 14.158a3 3 0 0 1-4.242-4.242"/><path d="M17.479 17.499a10.75 10.75 0 0 1-15.417-5.151 1 1 0 0 1 0-.696 10.75 10.75 0 0 1 4.446-5.143"/><path d="m2 2 20 20"/></svg>
                                <svg v-else xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-eye-icon lucide-eye"><path d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0"/><circle cx="12" cy="12" r="3"/></svg>
                            </button>
                        </div>
                        <p class="text-[#FF0800] text-sm" v-if="errors.password_confirmation">{{ errors.password_confirmation }}</p>
                    </div>
                    <div class="flex gap-2 text-[#999999]">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-alert-icon lucide-circle-alert"><circle cx="12" cy="12" r="10"/><line x1="12" x2="12" y1="8" y2="12"/><line x1="12" x2="12.01" y1="16" y2="16"/></svg>
                        Password minimal 8 karakter dengan kombinasi huruf dan angka.
                    </div>
                    <button class="flex justify-center items-center bg-primary text-white font-medium px-4 py-3 rounded-lg">Reset password</button>
                </Form>
            </div>
        </div>
    </HomeLayout>
</template>
