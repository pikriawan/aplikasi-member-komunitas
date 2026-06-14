<script setup>
import { Form, Link, usePage } from "@inertiajs/vue3";
import { computed } from "vue";
import DashboardHeader from "../../../Components/DashboardHeader.vue";
import Alert from "../../../Components/Ui/Alert.vue";
import Button from "../../../Components/Ui/Button.vue";
import Popover from "../../../Components/Ui/Popover.vue";
import PopoverContent from "../../../Components/Ui/PopoverContent.vue";
import PopoverTrigger from "../../../Components/Ui/PopoverTrigger.vue";
import TextField from "../../../Components/Ui/TextField.vue";
import StaffLayout from "../../../Layouts/StaffLayout.vue";
import { cn } from "../../../lib/utils.js";

const page = usePage();

const storageUrl = computed(() => page.props.storageUrl);
const messages = computed(() => page.props.messages);
const posts = computed(() => page.props.posts);
const q = computed(() => page.props.q);

const links = computed(() => posts.value?.links.map((link) => {
    const result = {...link};

    if (result.label === "&laquo; Previous") {
        result.label = "Previous";
    }

    if (result.label === "Next &raquo;") {
        result.label = "Next";
    }

    return result;
}));
</script>

<template>
    <StaffLayout>
        <DashboardHeader title="Blog">
            <Popover class="h-full aspect-square">
                <PopoverTrigger class="w-full h-full flex justify-center items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-ellipsis-vertical-icon lucide-ellipsis-vertical"><circle cx="12" cy="12" r="1"/><circle cx="12" cy="5" r="1"/><circle cx="12" cy="19" r="1"/></svg>
                </PopoverTrigger>
                <PopoverContent class="top-[calc(100%-1rem)] right-4 flex flex-col gap-px bg-onyx-200">
                    <Link class="flex items-center gap-4 p-4 bg-white first:rounded-t-[0.4375rem] last:rounded-b-[0.4375rem] whitespace-nowrap" href="#">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-upload-icon lucide-upload shrink-0"><path d="M12 3v12"/><path d="m17 8-5-5-5 5"/><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/></svg>
                        Tulis postingan baru
                    </Link>
                </PopoverContent>
            </Popover>
        </DashboardHeader>
        <main class="flex-1 overflow-auto">
            <div class="flex flex-col gap-8 p-8 lg:min-h-full">
                <div class="flex-1 flex flex-col gap-8 justify-between">
                    <div class="flex flex-col gap-8">
                        <Alert v-for="message in messages" :variant="message.variant" :key="message.text">
                            {{ message.text }}
                        </Alert>
                        <div class="flex justify-center">
                            <div class="flex flex-col gap-5 w-full lg:max-w-150">
                                <Form class="flex flex-col gap-4">
                                    <label class="font-semibold" for="search">Cari postingan</label>
                                    <div class="flex items-center gap-4">
                                        <TextField class="w-full" id="search" name="q" placeholder="Cari postingan" :value="q" />
                                        <Button>Cari</Button>
                                    </div>
                                </Form>
                                <template v-if="posts?.data?.length > 0">
                                    <Link v-for="post in posts.data" :key="post.id" href="#" class="flex flex-col gap-4 p-6 rounded-lg ring ring-inset ring-onyx-200">
                                        <span class="p-1 self-start text-sm rounded bg-primary text-white">{{ post.date }}</span>
                                        <h2 class="font-semibold text-2xl">{{ post.title }}</h2>
                                        <p>{{ post.summary }}</p>
                                    </Link>
                                </template>
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-center">
                        <div class="flex justify-center items-center flex-wrap gap-3">
                            <template v-for="link in links" :key="link.label">
                                <Link v-if="link.url" :class="cn('px-4 py-2 rounded-lg', link.active && 'bg-primary text-white')" :href="link.url" v-html="link.label" />
                                <span v-else class="px-4 py-2" v-html="link.label" />
                            </template>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </StaffLayout>
</template>
