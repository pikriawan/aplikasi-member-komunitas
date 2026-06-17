<script setup>
import { Form, Link, usePage } from "@inertiajs/vue3";
import { computed } from "vue";
import DashboardHeader from "../../../Components/DashboardHeader.vue";
import Alert from "../../../Components/Ui/Alert.vue";
import Button from "../../../Components/Ui/Button.vue";
import TextField from "../../../Components/Ui/TextField.vue";
import StaffLayout from "../../../Layouts/StaffLayout.vue";
import { cn } from "../../../lib/utils.js";

const page = usePage();

const appUrl = computed(() => page.props.appUrl);
const storageUrl = computed(() => page.props.storageUrl);
const messages = computed(() => page.flash.messages);
const conversations = computed(() => page.props.conversations);
const q = computed(() => page.props.q);

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
            <div class="flex flex-col gap-8 p-8 lg:min-h-full">
                <div class="flex-1 flex flex-col gap-8 justify-between">
                    <div class="flex flex-col gap-8">
                        <Alert v-for="message in messages" :variant="message.variant" :key="message.text">
                            {{ message.text }}
                        </Alert>
                        <div class="flex justify-center">
                            <div class="flex flex-col gap-5 w-full lg:max-w-150">
                                <Form class="flex flex-col gap-4">
                                    <label class="font-semibold" for="search">Cari member</label>
                                    <div class="flex items-center gap-4">
                                        <TextField class="w-full" id="search" name="q" placeholder="Cari member" :value="q" />
                                        <Button>Cari</Button>
                                    </div>
                                </Form>
                                <div v-if="conversations?.data?.length > 0" class="flex flex-col rounded-lg ring ring-inset ring-onyx-200">
                                    <div class="flex flex-col">
                                    <Link v-for="conversation in conversations.data" :key="conversation.id" class="flex items-center gap-5 p-5 not-last:shadow-[0_-0.0625rem_0_var(--color-onyx-200)_inset]" :href="route('staff.conversations.show', conversation.id)">
                                        <img :src="conversation.submitter.member_profile.image_url ? `${storageUrl}/${conversation.submitter.member_profile.image_url}` : `${appUrl}/images/profile-placeholder.svg`" :alt="conversation.submitter.name" class="w-12 aspect-square rounded-full">
                                        <p>{{ conversation.submitter.name }}</p>
                                    </Link>
                                </div>
                                </div>
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
