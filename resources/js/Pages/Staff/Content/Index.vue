<script setup>
import { Link, usePage } from "@inertiajs/vue3";
import { computed } from "vue";
import DashboardHeader from "../../../Components/DashboardHeader.vue";
import Alert from "../../../Components/Ui/Alert.vue";
import Popover from "../../../Components/Ui/Popover.vue";
import PopoverContent from "../../../Components/Ui/PopoverContent.vue";
import PopoverTrigger from "../../../Components/Ui/PopoverTrigger.vue";
import ContentType from "../../../Enums/ContentType.js";
import StaffLayout from "../../../Layouts/StaffLayout.vue";
import { cn } from "../../../lib/utils.js";

const page = usePage();

const appUrl = computed(() => page.props.appUrl);
const storageUrl = computed(() => page.props.storageUrl);
const user = computed(() => page.props.user);
const messages = computed(() => page.flash.messages);
const contents = computed(() => page.props.contents);
const activeType = computed(() => ContentType.from(page.props.type));

const links = computed(() => contents.value?.links.map((link) => {
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
        <DashboardHeader title="Konten">
            <Popover class="h-full aspect-square">
                <PopoverTrigger class="w-full h-full flex justify-center items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-ellipsis-vertical-icon lucide-ellipsis-vertical"><circle cx="12" cy="12" r="1"/><circle cx="12" cy="5" r="1"/><circle cx="12" cy="19" r="1"/></svg>
                </PopoverTrigger>
                <PopoverContent class="top-[calc(100%-1rem)] right-4 flex flex-col gap-px bg-onyx-200">
                    <Link class="flex items-center gap-4 p-4 bg-white first:rounded-t-[0.4375rem] last:rounded-b-[0.4375rem] whitespace-nowrap" :href="route('staff.contents.create')">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-upload-icon lucide-upload shrink-0"><path d="M12 3v12"/><path d="m17 8-5-5-5 5"/><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/></svg>
                        Unggah konten baru
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
                        <div class="flex flex-col gap-8">
                            <div class="flex gap-4">
                                <Link :class="cn('px-4 py-3 rounded-full bg-surface text-primary', type.value === activeType.value && 'bg-primary text-white')" v-for="[key, type] in ContentType.entries()" :key="key" :href="route('staff.contents.index', { _query: { type: type.value } })">
                                    {{ type.label }}
                                </Link>
                            </div>
                            <div v-if="contents?.data?.length > 0" :class="cn('flex flex-col lg:grid grid-cols-3 gap-8', activeType.value === ContentType.Ebook.value && 'grid-cols-5')">
                                <Link class="flex flex-col gap-4" v-for="content in contents.data" :href="route('staff.contents.edit', content.id)" :key="content.id">
                                    <img :src="content.thumbnail_url ? `${storageUrl}/${content.thumbnail_url}` : `${appUrl}/images/content-placeholder.svg`" :alt="content.title" :class="cn('w-full rounded-2xl aspect-video object-cover', content.type === ContentType.Ebook.value && 'aspect-9/16')">
                                    <h3 class="font-semibold text-2xl">{{ content.title }}</h3>
                                    <p class="text-onyx-400">{{ content.date }}</p>
                                </Link>
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
