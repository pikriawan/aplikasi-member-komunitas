<script setup>
import { Form, Link } from "@inertiajs/vue3";
import HomeLayout from "../layouts/HomeLayout.vue";
import { ref } from "vue";

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
                <Form class="w-full font-geist flex flex-col gap-8" action="/register" method="post" v-slot="{ errors }">
                    <div class="flex flex-col gap-2">
                        <label class="font-semibold" for="register_name">Nama lengkap *</label>
                        <input class="px-4 py-3 rounded-lg placeholder:text-[#CCCCCC] shadow-[0_0_0_0.0625rem_#CCCCCC_inset] focus:outline-0 focus:shadow-[0_0_0_0.0625rem_var(--color-primary)_inset]" id="register_name" name="name" placeholder="Nama lengkap" />
                        <p class="text-[#FF0800] text-sm" v-if="errors.name">{{ errors.name }}</p>
                    </div>
                    <div class="flex flex-col gap-2">
                        <label class="font-semibold" for="register_email">Email *</label>
                        <input class="px-4 py-3 rounded-lg placeholder:text-[#CCCCCC] shadow-[0_0_0_0.0625rem_#CCCCCC_inset] focus:outline-0 focus:shadow-[0_0_0_0.0625rem_var(--color-primary)_inset]" id="register_email" name="email" type="email" placeholder="example@mail.com" />
                        <p class="text-[#FF0800] text-sm" v-if="errors.email">{{ errors.email }}</p>
                    </div>
                    <div class="flex flex-col gap-2">
                        <label class="font-semibold" for="register_telephone">Nomor telepon *</label>
                        <input class="px-4 py-3 rounded-lg placeholder:text-[#CCCCCC] shadow-[0_0_0_0.0625rem_#CCCCCC_inset] focus:outline-0 focus:shadow-[0_0_0_0.0625rem_var(--color-primary)_inset]" id="register_telephone" name="telephone" type="tel" placeholder="Nomor telepon" />
                        <p class="text-[#FF0800] text-sm" v-if="errors.telephone">{{ errors.telephone }}</p>
                    </div>
                    <div class="flex flex-col gap-2">
                        <label class="font-semibold" for="register_institution">Institusi</label>
                        <input class="px-4 py-3 rounded-lg placeholder:text-[#CCCCCC] shadow-[0_0_0_0.0625rem_#CCCCCC_inset] focus:outline-0 focus:shadow-[0_0_0_0.0625rem_var(--color-primary)_inset]" id="register_institution" name="institution" placeholder="Institusi" />
                        <p class="text-[#FF0800] text-sm" v-if="errors.institution">{{ errors.institution }}</p>
                    </div>
                    <div class="flex flex-col gap-2">
                        <label class="font-semibold" for="register_department">Departemen</label>
                        <input class="px-4 py-3 rounded-lg placeholder:text-[#CCCCCC] shadow-[0_0_0_0.0625rem_#CCCCCC_inset] focus:outline-0 focus:shadow-[0_0_0_0.0625rem_var(--color-primary)_inset]" id="register_department" name="department" placeholder="Departemen" />
                        <p class="text-[#FF0800] text-sm" v-if="errors.department">{{ errors.department }}</p>
                    </div>
                    <div class="flex flex-col gap-2">
                        <label class="font-semibold" for="register_address">Alamat</label>
                        <textarea class="min-h-32 px-4 py-3 rounded-lg placeholder:text-[#CCCCCC] shadow-[0_0_0_0.0625rem_#CCCCCC_inset] focus:outline-0 focus:shadow-[0_0_0_0.0625rem_var(--color-primary)_inset]" id="register_address" name="address" placeholder="Alamat" />
                        <p class="text-[#FF0800] text-sm" v-if="errors.address">{{ errors.address }}</p>
                    </div>
                    <div class="flex flex-col gap-2">
                        <label class="font-semibold" for="register_password">Password</label>
                        <div class="relative">
                            <input class="w-full pl-4 pr-12 py-3 rounded-lg placeholder:text-[#CCCCCC] shadow-[0_0_0_0.0625rem_#CCCCCC_inset] focus:outline-0 focus:shadow-[0_0_0_0.0625rem_var(--color-primary)_inset]" id="register_password" name="password" :type="passwordShow ? 'text' : 'password'" placeholder="Password" />
                            <button class="absolute top-0 right-0 h-full aspect-square flex justify-center items-center" type="button" @click="passwordShow = !passwordShow">
                                <svg v-if="passwordShow" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-eye-off-icon lucide-eye-off"><path d="M10.733 5.076a10.744 10.744 0 0 1 11.205 6.575 1 1 0 0 1 0 .696 10.747 10.747 0 0 1-1.444 2.49"/><path d="M14.084 14.158a3 3 0 0 1-4.242-4.242"/><path d="M17.479 17.499a10.75 10.75 0 0 1-15.417-5.151 1 1 0 0 1 0-.696 10.75 10.75 0 0 1 4.446-5.143"/><path d="m2 2 20 20"/></svg>
                                <svg v-else xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-eye-icon lucide-eye"><path d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0"/><circle cx="12" cy="12" r="3"/></svg>
                            </button>
                        </div>
                        <p class="text-[#FF0800] text-sm" v-if="errors.password">{{ errors.password }}</p>
                    </div>
                    <div class="flex flex-col gap-2">
                        <label class="font-semibold" for="register_confirmPassword">Konfirmasi password</label>
                        <div class="relative">
                            <input class="w-full pl-4 pr-12 py-3 rounded-lg placeholder:text-[#CCCCCC] shadow-[0_0_0_0.0625rem_#CCCCCC_inset] focus:outline-0 focus:shadow-[0_0_0_0.0625rem_var(--color-primary)_inset]" id="register_confirmPassword" name="confirmPassword" :type="confirmPasswordShow ? 'text' : 'password'" placeholder="Konfirmasi password" />
                            <button class="absolute top-0 right-0 h-full aspect-square flex justify-center items-center" type="button" @click="confirmPasswordShow = !confirmPasswordShow">
                                <svg v-if="confirmPasswordShow" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-eye-off-icon lucide-eye-off"><path d="M10.733 5.076a10.744 10.744 0 0 1 11.205 6.575 1 1 0 0 1 0 .696 10.747 10.747 0 0 1-1.444 2.49"/><path d="M14.084 14.158a3 3 0 0 1-4.242-4.242"/><path d="M17.479 17.499a10.75 10.75 0 0 1-15.417-5.151 1 1 0 0 1 0-.696 10.75 10.75 0 0 1 4.446-5.143"/><path d="m2 2 20 20"/></svg>
                                <svg v-else xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-eye-icon lucide-eye"><path d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0"/><circle cx="12" cy="12" r="3"/></svg>
                            </button>
                        </div>
                        <p class="text-[#FF0800] text-sm" v-if="errors.confirmPassword">{{ errors.confirmPassword }}</p>
                    </div>
                    <div class="flex gap-2 text-[#999999]">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-alert-icon lucide-circle-alert"><circle cx="12" cy="12" r="10"/><line x1="12" x2="12" y1="8" y2="12"/><line x1="12" x2="12.01" y1="16" y2="16"/></svg>
                        Password minimal 8 karakter dengan kombinasi huruf dan angka.
                    </div>
                    <div class="flex gap-2 text-[#999999]">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-alert-icon lucide-circle-alert"><circle cx="12" cy="12" r="10"/><line x1="12" x2="12" y1="8" y2="12"/><line x1="12" x2="12.01" y1="16" y2="16"/></svg>
                        * wajib diisi.
                    </div>
                    <button class="flex justify-center items-center bg-primary text-white font-medium px-4 py-3 rounded-lg">Daftar</button>
                    <p class="text-center">Sudah memiliki akun? <Link class="text-primary" href="/login">Login</Link></p>
                </Form>
            </div>
        </div>
    </HomeLayout>
</template>
