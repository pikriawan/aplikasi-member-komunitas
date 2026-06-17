<script setup>
import { Form, Link, usePage } from "@inertiajs/vue3";
import { computed } from "vue";
import DashboardHeader from "../../../Components/DashboardHeader.vue";
import Button from "../../../Components/Ui/Button.vue";
import TextField from "../../../Components/Ui/TextField.vue";
import StaffLayout from "../../../Layouts/StaffLayout.vue";
import { cn } from "../../../lib/utils.js";

const page = usePage();

const appUrl = computed(() => page.props.appUrl);
const storageUrl = computed(() => page.props.storageUrl);
const conversations = computed(() => page.props.conversations);
const q = computed(() => page.props.q);

console.log(conversations.value);

const links = computed(() => conversations.value?.links.map((link) => {
    const result = {...link};

    if (result.label === "&laquo; Previous") {
        result.label = "Previuos";
    }

    if (result.label === "Next &raquo;") {
        result.label = "Next";
    }

    return result;
}));
</script>

<template>
    <StaffLayout>
        <DashboardHeader title="Pertanyaan"></DashboardHeader>
        <main class="flex-1 overflow-auto">
            <div class="h-full block lg:grid grid-cols-[22.5rem_1fr]">
                <div class="h-full overflow-y-auto border-r border-onyx-200">
                    <Form class="flex flex-col gap-4 p-5 shadow-[0_-0.0625rem_0_var(--color-onyx-200)_inset]">
                        <label class="font-semibold" for="search">Cari member</label>
                        <div class="flex items-center gap-4">
                            <TextField class="w-full" id="search" name="q" placeholder="Cari member" :value="q" />
                            <Button>Cari</Button>
                        </div>
                    </Form>
                    <div class="flex flex-col">
                        <Link v-for="conversation in conversations.data" :key="conversation.id" class="flex items-center gap-5 p-5 shadow-[0_-0.0625rem_0_var(--color-onyx-200)_inset]" href="#">
                            <img :src="conversation.submitter.member_profile.image_url ? `${storageUrl}/${conversation.submitter.member_profile.image_url}` : `${appUrl}/images/profile-placeholder.svg`" :alt="conversation.submitter.name" class="w-12 aspect-square rounded-full">
                            <p>{{ conversation.submitter.name }}</p>
                        </Link>
                    </div>
                    <div class="flex justify-center p-5 shadow-[0_-0.0625rem_0_var(--color-onyx-200)_inset]">
                        <div class="flex justify-center items-center flex-wrap gap-3">
                            <template v-for="link in links" :key="link.label">
                                <Link v-if="link.url" :class="cn('px-4 py-2 rounded-lg', link.active && 'bg-primary text-white')" :href="link.url" v-html="link.label" />
                                <span v-else class="px-4 py-2" v-html="link.label" />
                            </template>
                        </div>
                    </div>
                </div>
                <div class="hidden lg:flex h-full overflow-y-auto"></div>
            </div>
        </main>
    </StaffLayout>
</template>
