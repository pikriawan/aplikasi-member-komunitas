<script setup>
import { Link, usePage } from "@inertiajs/vue3";
import { computed } from "vue";
import DashboardHeader from "../../../Components/DashboardHeader.vue";
import Alert from "../../../Components/Ui/Alert.vue";
import Button from "../../../Components/Ui/Button.vue";
import Popover from "../../../Components/Ui/Popover.vue";
import PopoverContent from "../../../Components/Ui/PopoverContent.vue";
import PopoverTrigger from "../../../Components/Ui/PopoverTrigger.vue";
import ContentType from "../../../Enums/ContentType.js";
import MemberLayout from "../../../Layouts/MemberLayout.vue";
import { cn } from "../../../lib/utils.js";

const page = usePage();

const appUrl = computed(() => page.props.appUrl);
const storageUrl = computed(() => page.props.storageUrl);
const memberProfile = computed(() => page.props.memberProfile);
const messages = computed(() => page.flash.messages);
const contents = computed(() => page.props.contents);
const activeType = computed(() => ContentType.from(page.props.type));

const links = computed(() => contents.value.links.map((link) => {
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
    <MemberLayout>
        <DashboardHeader title="Konten">
            <Popover class="h-full aspect-square">
                <PopoverTrigger class="w-full h-full flex justify-center items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-ellipsis-vertical-icon lucide-ellipsis-vertical"><circle cx="12" cy="12" r="1"/><circle cx="12" cy="5" r="1"/><circle cx="12" cy="19" r="1"/></svg>
                </PopoverTrigger>
                <PopoverContent class="top-[calc(100%-1rem)] right-4 flex flex-col gap-px bg-onyx-200">
                    <Link class="flex items-center gap-4 p-4 bg-white first:rounded-t-[0.4375rem] last:rounded-b-[0.4375rem] whitespace-nowrap" href="#">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-alert-icon lucide-circle-alert shrink-0"><circle cx="12" cy="12" r="10"/><line x1="12" x2="12" y1="8" y2="12"/><line x1="12" x2="12.01" y1="16" y2="16"/></svg>
                        Very important action
                    </Link>
                    <Link class="flex items-center gap-4 p-4 bg-white first:rounded-t-[0.4375rem] last:rounded-b-[0.4375rem] whitespace-nowrap" href="#">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-ban-icon lucide-ban shrink-0"><circle cx="12" cy="12" r="10"/><path d="M4.929 4.929 19.07 19.071"/></svg>
                        Less important action
                    </Link>
                    <Link class="flex items-center gap-4 p-4 bg-white first:rounded-t-[0.4375rem] last:rounded-b-[0.4375rem] whitespace-nowrap" href="#">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-frown-icon lucide-frown shrink-0"><circle cx="12" cy="12" r="10"/><path d="M16 16s-1.5-2-4-2-4 2-4 2"/><line x1="9" x2="9.01" y1="9" y2="9"/><line x1="15" x2="15.01" y1="9" y2="9"/></svg>
                        Forget about me
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
                        <div v-if="contents?.data?.length > 0" class="flex flex-col gap-8">
                            <div class="flex gap-4">
                                <Link :class="cn('px-4 py-3 rounded-full bg-surface text-primary', type.value === activeType.value && 'bg-primary text-white')" v-for="[key, type] in ContentType.entries()" :key="key" :href="route('member.contents.index', { _query: { type: type.value } })">
                                    {{ type.label }}
                                </Link>
                            </div>
                            <div :class="cn('flex flex-col lg:grid grid-cols-3 gap-8', activeType.value === ContentType.Ebook.value && 'grid-cols-5')">
                                <a class="flex flex-col gap-4" v-for="content in contents.data" :href="route('member.contents.show', content.file_url)" :key="content.id">
                                    <img :src="content.thumbnail_url ? `${storageUrl}/${content.thumbnail_url}` : `${appUrl}/images/content-placeholder.svg`" :alt="content.title" :class="cn('w-full rounded-2xl aspect-video object-cover', content.type === ContentType.Ebook.value && 'aspect-3/5')">
                                    <h3 class="font-semibold text-2xl">{{ content.title }}</h3>
                                    <p class="text-onyx-400">{{ content.date }}</p>
                                </a>
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
    </MemberLayout>
</template>
