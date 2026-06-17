<script setup>
import { Form, useForm, usePage } from "@inertiajs/vue3";
import { computed, ref, watchEffect } from "vue";
import DashboardHeader from "../../../Components/DashboardHeader.vue";
import PostEditor from "../../../Components/PostEditor.vue";
import Alert from "../../../Components/Ui/Alert.vue";
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
const messages = computed(() => page.flash.messages);
const post = computed(() => page.props.post);

const category = ref();

const form = useForm({
    title: "",
    category: "",
    summary: "",
    content: ""
});

watchEffect(() => {
    form.title = post.value?.title;
    form.category = post.value?.category;
    form.summary = post.value?.summary;
    form.content = post.value?.content;
});

function onSubmit() {
    form.put(route('staff.posts.update', post.value.id));
}
</script>

<template>
    <StaffLayout>
        <DashboardHeader title="Edit Postingan" :back-href="route('staff.posts.index')">
            <Popover class="h-full aspect-square">
                <PopoverTrigger class="w-full h-full flex justify-center items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-ellipsis-vertical-icon lucide-ellipsis-vertical"><circle cx="12" cy="12" r="1"/><circle cx="12" cy="5" r="1"/><circle cx="12" cy="19" r="1"/></svg>
                </PopoverTrigger>
                <PopoverContent class="top-[calc(100%-1rem)] right-4 flex flex-col gap-px bg-onyx-200">
                    <button form="edit_post" class="flex items-center gap-4 p-4 bg-white first:rounded-t-[0.4375rem] last:rounded-b-[0.4375rem] whitespace-nowrap">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-upload-icon lucide-upload shrink-0"><path d="M12 3v12"/><path d="m17 8-5-5-5 5"/><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/></svg>
                        Simpan perubahan
                    </button>
                    <Form class="flex first:rounded-t-[0.4375rem] last:rounded-b-[0.4375rem] bg-white text-red-500" :action="route('staff.posts.destroy', post.id)" method="delete">
                        <button class="w-full flex items-center gap-4 p-4 whitespace-nowrap">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trash2-icon lucide-trash-2 shrink-0"><path d="M10 11v6"/><path d="M14 11v6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6"/><path d="M3 6h18"/><path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                            Hapus postingan
                        </button>
                    </Form>
                </PopoverContent>
            </Popover>
        </DashboardHeader>
        <main class="flex-1 overflow-auto">
            <div class="flex justify-center p-8 lg:min-h-full">
                <div v-if="messages?.length > 0" class="w-full flex flex-col gap-8">
                    <Alert v-for="message in messages" :variant="message.variant" :key="message.text">
                        {{ message.text }}
                    </Alert>
                </div>
                <form v-if="post" id="edit_post" class="flex flex-col gap-8 w-full lg:max-w-150" @submit.prevent="onSubmit">
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
