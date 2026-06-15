<script setup>
import { useForm, usePage } from "@inertiajs/vue3";
import { computed, ref, watchEffect } from "vue";
import DashboardHeader from "../../../Components/DashboardHeader.vue";
import PostEditor from "../../../Components/PostEditor.vue";
import Button from "../../../Components/Ui/Button.vue";
import Popover from "../../../Components/Ui/Popover.vue";
import PopoverContent from "../../../Components/Ui/PopoverContent.vue";
import PopoverTrigger from "../../../Components/Ui/PopoverTrigger.vue";
import TextField from "../../../Components/Ui/TextField.vue";
import PostCategory from "../../../Enums/PostCategory.js";
import StaffLayout from "../../../Layouts/StaffLayout.vue";
import { cn } from "../../../lib/utils.js";

delete PostCategory.All;

const page = usePage();

const appUrl = computed(() => page.props.appUrl);

const category = ref(PostCategory.News.value);

const form = useForm({
    title: "",
    category: PostCategory.News.value,
    summary: "",
    content: ""
});

function onSubmit() {
    form.post(route('staff.posts.store'));
}
</script>

<template>
    <StaffLayout>
        <DashboardHeader title="Tulis Postingan Baru" :back-href="route('staff.posts.index')">
            <Popover class="h-full aspect-square">
                <PopoverTrigger class="w-full h-full flex justify-center items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-ellipsis-vertical-icon lucide-ellipsis-vertical"><circle cx="12" cy="12" r="1"/><circle cx="12" cy="5" r="1"/><circle cx="12" cy="19" r="1"/></svg>
                </PopoverTrigger>
                <PopoverContent class="top-[calc(100%-1rem)] right-4 flex flex-col gap-px bg-onyx-200">
                    <button form="publish_post" class="flex items-center gap-4 p-4 bg-white first:rounded-t-[0.4375rem] last:rounded-b-[0.4375rem] whitespace-nowrap">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-send-horizontal-icon lucide-send-horizontal shrink-0"><path d="M3.714 3.048a.498.498 0 0 0-.683.627l2.843 7.627a2 2 0 0 1 0 1.396l-2.842 7.627a.498.498 0 0 0 .682.627l18-8.5a.5.5 0 0 0 0-.904z"/><path d="M6 12h16"/></svg>
                        Kirim postingan
                    </button>
                </PopoverContent>
            </Popover>
        </DashboardHeader>
        <main class="flex-1 overflow-auto">
            <div class="flex justify-center p-8 lg:min-h-full">
                <form id="publish_post" class="flex flex-col gap-8 w-full lg:max-w-150" @submit.prevent="onSubmit">
                    <div class="flex flex-col gap-2">
                        <label for="title" class="font-semibold">Judul</label>
                        <TextField id="title" name="title" placeholder="Judul" v-model="form.title" />
                        <p class="text-danger-500 text-sm" v-if="form.errors.title">{{ form.errors.title }}</p>
                    </div>
                    <div class="flex flex-col gap-2">
                        <span class="font-semibold">Kategori</span>
                        <div class="flex flex-col gap-2">
                            <label v-for="[key, c] in PostCategory.entries()" :key="key" class="flex items-center gap-2">
                                <input type="radio" name="category" :id="c.value" :value="c.value" v-model="form.category">
                                <span>{{ c.label }}</span>
                            </label>
                        </div>
                        <p class="text-danger-500 text-sm" v-if="form.errors.type">{{ form.errors.type }}</p>
                    </div>
                    <div class="flex flex-col gap-2">
                        <label for="summary" class="font-semibold">Ringkasan</label>
                        <TextField as="textarea" id="summary" name="summary" placeholder="Ringkasan" v-model="form.summary" />
                        <p class="text-danger-500 text-sm" v-if="form.errors.summary">{{ form.errors.summary }}</p>
                    </div>
                    <div class="flex flex-col gap-2">
                        <label class="font-semibold">Konten</label>
                        <PostEditor v-model="form.content" />
                        <p class="text-danger-500 text-sm" v-if="form.errors.content">{{ form.errors.content }}</p>
                    </div>
                </form>
            </div>
        </main>
    </StaffLayout>
</template>
