<script setup>
import { router, usePage } from "@inertiajs/vue3";
import { computed, onMounted, reactive, useTemplateRef } from "vue";
import DashboardHeader from "../../../Components/DashboardHeader.vue";
import Alert from "../../../Components/Ui/Alert.vue";
import Button from "../../../Components/Ui/Button.vue";
import Popover from "../../../Components/Ui/Popover.vue";
import PopoverContent from "../../../Components/Ui/PopoverContent.vue";
import PopoverTrigger from "../../../Components/Ui/PopoverTrigger.vue";
import StaffLayout from "../../../Layouts/StaffLayout.vue";
import { cn } from "../../../lib/utils.js";

const page = usePage();

const user = computed(() => page.props.user);
const flashMessages = computed(() => page.flash.messages);
const conversation = computed(() => page.props.conversation);
const messages = computed(() => page.props.messages);

const container = useTemplateRef("container");
const input = useTemplateRef("input");

onMounted(() => {
    if (container.value && input.value) {
        container.value.scrollTop = container.value.scrollHeight;
        input.value.focus();
    }
});

const form = reactive({
    message: null,
});

function onSubmit(event) {
    router.post(route('staff.conversations.message.store', conversation.value.id), form, {
        onFinish() {
            if (container.value) {
                container.value.scrollTop = container.value.scrollHeight;
            }

            form.message = null;
        }
    });
}
</script>

<template>
    <StaffLayout>
        <DashboardHeader :title="conversation?.submitter.name || '-'" :back-href="route('staff.conversations.index')" />
        <main class="flex-1 overflow-auto">
            <div v-if="flashMessages" class="flex flex-col gap-8 p-8 lg:min-h-full">
                <div class="flex-1 flex flex-col gap-8 justify-between">
                    <div class="flex flex-col gap-8">
                        <Alert v-for="message in flashMessages" :variant="message.variant" :key="message.text">
                            {{ message.text }}
                        </Alert>
                    </div>
                </div>
            </div>
            <div v-else class="flex flex-col h-[calc(100dvh-5rem)]">
                <div class="h-full overflow-y-auto" ref="container">
                    <div class="flex flex-col gap-8 p-8">
                        <template v-for="[date, messages] in Object.entries(messages)" :key="date">
                            <p class="text-center">{{ date }}</p>
                            <div v-for="message in messages" :class="cn('flex break-all', message.sender_id === user.id && 'justify-end')">
                                <div :class="cn('flex flex-col gap-3 p-5 w-full max-w-100 rounded-[0.25rem_1rem_1rem_1rem] bg-onyx-100', message.sender_id === user.id && 'bg-onyx-50 rounded-[1rem_0.25rem_1rem_1rem]')">
                                    <p class="font-medium">
                                        {{ message.sender_id === user.id ? "Saya" : message.sender.name }}
                                        <span class="text-onyx-400">
                                            {{ ` • ${message.time}` }}
                                        </span>
                                    </p>
                                    <p>{{ message.content }}</p>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
                <div class="shrink-0 p-2 w-full bg-white">
                    <form class="flex items-center gap-4 p-3 ring ring-inset ring-onyx-200 rounded-[1.25rem] focus-within:ring-primary" @submit.prevent="onSubmit">
                        <input class="w-full focus:outline-0" placeholder="Tulis pertanyaan" v-model="form.message" ref="input">
                        <Button>
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-send-horizontal-icon lucide-send-horizontal shrink-0"><path d="M3.714 3.048a.498.498 0 0 0-.683.627l2.843 7.627a2 2 0 0 1 0 1.396l-2.842 7.627a.498.498 0 0 0 .682.627l18-8.5a.5.5 0 0 0 0-.904z"/><path d="M6 12h16"/></svg>
                            Kirim
                        </Button>
                    </form>
                </div>
            </div>
        </main>
    </StaffLayout>
</template>
