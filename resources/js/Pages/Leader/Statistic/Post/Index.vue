<script setup>
import { Link, usePage } from "@inertiajs/vue3";
import { computed } from "vue";
import DashboardHeader from "../../../../Components/DashboardHeader.vue";
import Alert from "../../../../Components/Ui/Alert.vue";
import Badge from "../../../../Components/Ui/Badge.vue";
import PostCategory from "../../../../Enums/PostCategory.js";
import LeaderLayout from "../../../../Layouts/LeaderLayout.vue";
import { cn } from "../../../../lib/utils.js";

const page = usePage();

const posts = computed(() => page.props.posts);
const messages = computed(() => page.flash.messages);

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
    <LeaderLayout>
        <DashboardHeader title="Statistik Konten" :back-href="route('leader.statistics.index')" />
        <main class="flex-1 overflow-auto">
            <div class="flex flex-col gap-8 p-8 lg:min-h-full">
                <div class="flex-1 flex flex-col gap-8 justify-between">
                    <div class="flex flex-col gap-8">
                        <Alert v-for="message in messages" :variant="message.variant" :key="message.text">
                            {{ message.text }}
                        </Alert>
                        <div v-if="posts?.data?.length > 0" class="w-full overflow-x-auto rounded-lg border border-onyx-200">
                            <table class="min-w-full">
                                <thead class="bg-onyx-50 rounded-lg">
                                    <tr class="border-b border-onyx-200">
                                        <th class="whitespace-nowrap p-4 text-start font-semibold">Judul</th>
                                        <th class="whitespace-nowrap p-4 text-start font-semibold">Kategori</th>
                                        <th class="whitespace-nowrap p-4 text-start font-semibold">Penulis</th>
                                        <th class="whitespace-nowrap p-4 text-start font-semibold">Tanggal publikasi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="post in posts.data" :key="post.id">
                                        <td class="whitespace-nowrap p-4 align-middle">{{ post.title }}</td>
                                        <td class="whitespace-nowrap p-4 align-middle">
                                            <Badge :variant="PostCategory.from(post.category).variant">{{ PostCategory.from(post.category).label }}</Badge>
                                        </td>
                                        <td class="whitespace-nowrap p-4 align-middle">{{ post.author.name }}</td>
                                        <td class="whitespace-nowrap p-4 align-middle">{{ post.date }}</td>
                                    </tr>
                                </tbody>
                            </table>
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
    </LeaderLayout>
</template>
