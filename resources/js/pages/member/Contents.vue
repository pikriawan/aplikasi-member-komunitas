<script setup>
import { ref } from "vue";
import Button from "../../components/Button.vue";
import MemberLayout from "../../layouts/MemberLayout.vue";

const optionsOpen = ref(false);
</script>

<template>
    <MemberLayout v-slot="{ setSidebarShow }">
        <header class="sticky top-0 h-14 flex items-center lg:gap-4 shadow-[0_-0.0625rem_0_#CCCCCC_inset] lg:h-20 lg:px-8 bg-white">
            <button class="h-full aspect-square flex items-center justify-center lg:hidden" @click="setSidebarShow(true)">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-menu-icon lucide-menu"><path d="M4 5h16"/><path d="M4 12h16"/><path d="M4 19h16"/></svg>
            </button>
            <h1 class="w-full font-semibold lg:text-2xl">Konten</h1>
            <div class="h-full aspect-square relative">
                <div class="fixed top-0 left-0 w-full h-full" v-if="optionsOpen" @click="optionsOpen = false" />
                <div class="absolute w-50 top-[calc(100%+0.5rem)] right-2 flex flex-col gap-px p-px bg-[#CCCCCC] rounded-lg font-medium shadow-[0_0.25rem_4rem_rgba(0,0,0,0.1)] lg:hidden" v-if="optionsOpen">
                    <Form class="flex bg-white rounded-t-[0.4375rem]">
                        <button class="w-full h-full flex items-center gap-4 p-4">Aksi 1</button>
                    </Form>
                    <Form class="flex bg-white">
                        <button class="w-full h-full flex items-center gap-4 p-4">Aksi 2</button>
                    </Form>
                    <Form class="flex bg-white rounded-b-[0.4375rem]">
                        <button class="w-full h-full flex items-center gap-4 p-4">Aksi 3</button>
                    </Form>
                </div>
                <button class="w-full h-full flex items-center justify-center lg:hidden" @click="optionsOpen = true">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-ellipsis-vertical-icon lucide-ellipsis-vertical"><circle cx="12" cy="12" r="1"/><circle cx="12" cy="5" r="1"/><circle cx="12" cy="19" r="1"/></svg>
                </button>
            </div>
            <div class="shrink-0 gap-4 hidden lg:flex">
                <Button variant="outlined">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-pencil-icon lucide-pencil"><path d="M21.174 6.812a1 1 0 0 0-3.986-3.987L3.842 16.174a2 2 0 0 0-.5.83l-1.321 4.352a.5.5 0 0 0 .623.622l4.353-1.32a2 2 0 0 0 .83-.497z"/><path d="m15 5 4 4"/></svg>
                    Aksi 1
                </Button>
                <Button variant="danger">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-pencil-icon lucide-pencil"><path d="M21.174 6.812a1 1 0 0 0-3.986-3.987L3.842 16.174a2 2 0 0 0-.5.83l-1.321 4.352a.5.5 0 0 0 .623.622l4.353-1.32a2 2 0 0 0 .83-.497z"/><path d="m15 5 4 4"/></svg>
                    Aksi 2
                </Button>
                <Button>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-pencil-icon lucide-pencil"><path d="M21.174 6.812a1 1 0 0 0-3.986-3.987L3.842 16.174a2 2 0 0 0-.5.83l-1.321 4.352a.5.5 0 0 0 .623.622l4.353-1.32a2 2 0 0 0 .83-.497z"/><path d="m15 5 4 4"/></svg>
                    Aksi 3
                </Button>
            </div>
        </header>
        <div class="overflow-x-auto lg:w-full lg:h-full lg:overflow-auto">
            Content goes here...
        </div>
    </MemberLayout>
</template>
