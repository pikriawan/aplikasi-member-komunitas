<script setup>
import { Form, usePage } from "@inertiajs/vue3";
import { computed, ref, useTemplateRef } from "vue";
import DashboardHeader from "../../../Components/DashboardHeader.vue";
import Alert from "../../../Components/Ui/Alert.vue";
import Button from "../../../Components/Ui/Button.vue";
import Popover from "../../../Components/Ui/Popover.vue";
import PopoverContent from "../../../Components/Ui/PopoverContent.vue";
import PopoverTrigger from "../../../Components/Ui/PopoverTrigger.vue";
import TextField from "../../../Components/Ui/TextField.vue";
import ContentType from "../../../Enums/ContentType.js";
import StaffLayout from "../../../Layouts/StaffLayout.vue";
import { cn } from "../../../lib/utils.js";

const page = usePage();

const appUrl = computed(() => page.props.appUrl);
const storageUrl = computed(() => page.props.storageUrl);
const messages = computed(() => page.flash.messages);
const content = computed(() => page.props.content);

console.log(content.value);

const type = ref();

const thumbnail = useTemplateRef("thumbnail");
const thumbnailInput = useTemplateRef("thumbnail-input");
const deleteThumbnail = useTemplateRef("delete-thumbnail");

function onThumbnailInputChange(event) {
    const fileList = event.target.files;

    if (fileList.length === 1) {
        thumbnail.value.src = URL.createObjectURL(fileList[0]);
    }

    deleteThumbnail.value.value = "false";
}

function clearThumbnailInput() {
    thumbnailInput.value.value = "";
    thumbnail.value.src = `${appUrl.value}/images/content-placeholder.svg`;
    deleteThumbnail.value.value = "true";
}

const fileName = ref();

function onFileInputChange(event) {
    const fileList = event.target.files;

    if (fileList.length === 1) {
        fileName.value = fileList[0].name;
    }
}
</script>

<template>
    <StaffLayout>
        <DashboardHeader title="Edit Konten" :back-href="content.type === ContentType.Ebook.value ? route('staff.contents.index', { _query: { type: 'ebook' } }) : route('staff.contents.index')">
            <Popover v-if="content" class="h-full aspect-square">
                <PopoverTrigger class="w-full h-full flex justify-center items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-ellipsis-vertical-icon lucide-ellipsis-vertical"><circle cx="12" cy="12" r="1"/><circle cx="12" cy="5" r="1"/><circle cx="12" cy="19" r="1"/></svg>
                </PopoverTrigger>
                <PopoverContent class="top-[calc(100%-1rem)] right-4 flex flex-col gap-px bg-onyx-200">
                    <button form="edit_content" class="flex items-center gap-4 p-4 bg-white first:rounded-t-[0.4375rem] last:rounded-b-[0.4375rem] whitespace-nowrap">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-upload-icon lucide-upload shrink-0"><path d="M12 3v12"/><path d="m17 8-5-5-5 5"/><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/></svg>
                        Simpan perubahan
                    </button>
                    <Form class="flex first:rounded-t-[0.4375rem] last:rounded-b-[0.4375rem] bg-white text-red-500" :action="route('staff.contents.destroy', content.id)" method="delete">
                        <button class="w-full flex items-center gap-4 p-4 whitespace-nowrap">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trash2-icon lucide-trash-2 shrink-0"><path d="M10 11v6"/><path d="M14 11v6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6"/><path d="M3 6h18"/><path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                            Hapus konten
                        </button>
                    </Form>
                </PopoverContent>
            </Popover>
        </DashboardHeader>
        <main class="flex-1 overflow-auto">
            <div class="flex flex-col gap-8 p-8 lg:min-h-full">
                <Alert v-for="message in messages" :variant="message.variant" :key="message.text">
                    {{ message.text }}
                </Alert>
                <div class="flex justify-center">
                    <Form v-if="content" id="edit_content" class="flex flex-col gap-8 w-full lg:max-w-150" :action="route('staff.contents.update', content.id)" method="put" v-slot="{ errors }">
                        <div class="flex flex-col gap-2">
                            <label for="title" class="font-semibold">Judul</label>
                            <TextField id="title" name="title" placeholder="Judul" :value="content.title" />
                            <p class="text-danger-500 text-sm" v-if="errors.title">{{ errors.title }}</p>
                        </div>
                        <div class="flex flex-col gap-2">
                            <span class="font-semibold">Tipe</span>
                            <div class="flex flex-col gap-2">
                                <label v-for="[key, t] in ContentType.entries()" :key="key" class="flex items-center gap-2">
                                    <input type="radio" name="type" :id="t.value" :value="t.value" v-model="type" :checked="content.type === t.value">
                                    <span>{{ t.label }}</span>
                                </label>
                            </div>
                            <p class="text-danger-500 text-sm" v-if="errors.type">{{ errors.type }}</p>
                        </div>
                        <div class="flex flex-col gap-4">
                            <label class="font-semibold">Thumbnail</label>
                            <img :src="content.thumbnail_url ? `${storageUrl}/${content.thumbnail_url}` : `${appUrl}/images/content-placeholder.svg`" alt="Thumbnail" :class="cn('w-80 aspect-video object-cover rounded-lg border border-onyx-200', (type || content.type) === ContentType.Ebook.value && 'w-50 aspect-9/16')" ref="thumbnail">
                            <div class="flex gap-2 text-onyx-400">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-alert-icon lucide-circle-alert shrink-0"><circle cx="12" cy="12" r="10"/><line x1="12" x2="12" y1="8" y2="12"/><line x1="12" x2="12.01" y1="16" y2="16"/></svg>
                                <ul class="list-disc pl-4">
                                    <li>Format JPG atau PNG, ukuran maksimal 1MB</li>
                                    <li>Rasio thumbnail video disarankan 16 : 9</li>
                                    <li>Rasio thumbnail ebook disarankan 9 : 16</li>
                                </ul>
                            </div>
                            <div class="flex flex-wrap gap-4">
                                <input type="file" accept=".jpg, .jpeg, .png" class="hidden" name="thumbnail" id="thumbnail" @change="onThumbnailInputChange" ref="thumbnail-input">
                                <Button as="label" for="thumbnail" class="whitespace-nowrap">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-upload-icon lucide-upload shrink-0"><path d="M12 3v12"/><path d="m17 8-5-5-5 5"/><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/></svg>
                                    Unggah thumbnail
                                </Button>
                                <input type="hidden" name="delete_thumbnail" value="false" ref="delete-thumbnail">
                                <Button variant="outlined" @click="clearThumbnailInput" type="button" class="whitespace-nowrap">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trash2-icon lucide-trash-2 shrink-0"><path d="M10 11v6"/><path d="M14 11v6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6"/><path d="M3 6h18"/><path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                                    Hapus thumbnail
                                </Button>
                            </div>
                            <p class="text-danger-500 text-sm" v-if="errors.thumbnail">{{ errors.thumbnail }}</p>
                        </div>
                        <div class="flex flex-col gap-4">
                            <label class="font-semibold">File</label>
                            <p>{{ fileName || content.file_url }}</p>
                            <div class="flex gap-2 text-onyx-400">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-alert-icon lucide-circle-alert shrink-0"><circle cx="12" cy="12" r="10"/><line x1="12" x2="12" y1="8" y2="12"/><line x1="12" x2="12.01" y1="16" y2="16"/></svg>
                                <ul class="list-disc pl-4">
                                    <li>Format MOV, MP4, atau WEBM untuk video</li>
                                    <li>Format PDF untuk ebook</li>
                                    <li>Ukuran maksimal 10MB</li>
                                </ul>
                            </div>
                            <div class="flex flex-wrap gap-4">
                                <input type="file" :accept="(type || content.type) === ContentType.Video.value ? '.mov, .mp4, .webm' : '.pdf'" class="hidden" name="file" id="file" @change="onFileInputChange">
                                <Button as="label" for="file" class="whitespace-nowrap">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-upload-icon lucide-upload shrink-0"><path d="M12 3v12"/><path d="m17 8-5-5-5 5"/><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/></svg>
                                    Unggah file
                                </Button>
                            </div>
                            <p class="text-danger-500 text-sm" v-if="errors.file">{{ errors.file }}</p>
                        </div>
                    </Form>
                </div>
            </div>
        </main>
    </StaffLayout>
</template>
