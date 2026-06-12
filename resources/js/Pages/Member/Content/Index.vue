<script setup>
import { Link, usePage } from "@inertiajs/vue3";
import { computed } from "vue";
import DashboardHeader from "../../../Components/DashboardHeader.vue";
import Alert from "../../../Components/Ui/Alert.vue";
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
    <MemberLayout>
        <DashboardHeader title="Konten" />
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
                                    <img :src="content.thumbnail_url ? `${storageUrl}/${content.thumbnail_url}` : `${appUrl}/images/content-placeholder.svg`" :alt="content.title" :class="cn('w-full rounded-2xl aspect-video object-cover', content.type === ContentType.Ebook.value && 'aspect-9/16')">
                                    <h3 class="font-semibold text-2xl">{{ content.title }}</h3>
                                    <p class="text-onyx-400"><span class="font-semibold">{{ content.uploader.name }}</span> • {{ content.date }}</p>
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
