<script setup>
import { Form, Link, usePage } from "@inertiajs/vue3";
import { computed, useTemplateRef } from "vue";
import DashboardHeader from "../../../Components/DashboardHeader.vue";
import Button from "../../../Components/Ui/Button.vue";
import Popover from "../../../Components/Ui/Popover.vue";
import PopoverContent from "../../../Components/Ui/PopoverContent.vue";
import PopoverTrigger from "../../../Components/Ui/PopoverTrigger.vue";
import TextField from "../../../Components/Ui/TextField.vue";
import SuperAdminLayout from "../../../Layouts/SuperAdminLayout.vue";
import { cn } from "../../../lib/utils.js";

const page = usePage();

const appUrl = computed(() => page.props.appUrl);
const storageUrl = computed(() => page.props.storageUrl);
const setting = computed(() => page.props.setting);

function useImageInput(key) {
    const image = useTemplateRef(key);
    const imageInput = useTemplateRef(`${key}-input`);
    const deleteImage = useTemplateRef(`delete-${key}`);

    function onImageInputChange(event) {
        const fileList = event.target.files;

        if (fileList.length === 1) {
            image.value.src = URL.createObjectURL(fileList[0]);
        }

        deleteImage.value.value = "false";
    }

    function clearImageInput() {
        imageInput.value.value = "";
        image.value.src = `${appUrl.value}/images/placeholder.svg`;
        deleteImage.value.value = "true";
    }

    return { onImageInputChange, clearImageInput };
}

const {
    onImageInputChange: onLogoInputChange,
    clearImageInput: clearLogoInput
} = useImageInput("logo");

const {
    onImageInputChange: onBackgroundInputChange,
    clearImageInput: clearBackgroundInput
} = useImageInput("background");

const {
    onImageInputChange: onAboutImageInputChange,
    clearImageInput: clearAboutImageInput
} = useImageInput("about-image");

const {
    onImageInputChange: onCardBackgroundInputChange,
    clearImageInput: clearCardBackgroundInput
} = useImageInput("card-background");

const {
    onImageInputChange: onLeaderSignInputChange,
    clearImageInput: clearLeaderSignInput
} = useImageInput("leader-sign");
</script>

<template>
    <SuperAdminLayout>
        <DashboardHeader title="Pengaturan Sistem">
            <Popover class="h-full aspect-square">
                <PopoverTrigger class="w-full h-full flex justify-center items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-ellipsis-vertical-icon lucide-ellipsis-vertical"><circle cx="12" cy="12" r="1"/><circle cx="12" cy="5" r="1"/><circle cx="12" cy="19" r="1"/></svg>
                </PopoverTrigger>
                <PopoverContent class="top-[calc(100%-1rem)] right-4 flex flex-col gap-px bg-onyx-200">
                    <button form="edit_profile" class="flex items-center gap-4 p-4 bg-white first:rounded-t-[0.4375rem] last:rounded-b-[0.4375rem] whitespace-nowrap">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-file-icon lucide-file shrink-0"><path d="M6 22a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h8a2.4 2.4 0 0 1 1.704.706l3.588 3.588A2.4 2.4 0 0 1 20 8v12a2 2 0 0 1-2 2z"/><path d="M14 2v5a1 1 0 0 0 1 1h5"/></svg>
                        Simpan perubahan
                    </button>
                </PopoverContent>
            </Popover>
        </DashboardHeader>
        <main class="w-full h-full overflow-auto">
            <Form id="edit_profile" class="flex flex-col gap-8 p-8 lg:min-h-full" action="" method="get" v-slot="{ errors }">
                <div class="flex flex-col gap-8">
                    <div class="flex flex-col gap-2 lg:max-w-150">
                        <label for="community_name" class="font-semibold">Nama komunitas</label>
                        <TextField id="community_name" name="community_name" placeholder="Nama komunitas" :value="setting.community_name" />
                        <p class="text-danger-500 text-sm" v-if="errors.community_name">{{ errors.community_name }}</p>
                    </div>
                    <div class="flex flex-col gap-4 lg:max-w-150">
                        <label class="font-semibold">Logo komunitas</label>
                        <img :src="setting.community_logo ? `${storageUrl}/${setting.community_logo}` : `${appUrl}/images/placeholder.svg`" alt="Community Logo" class="w-32 aspect-square object-cover rounded-lg border border-onyx-200" ref="logo">
                        <div class="flex gap-2 text-onyx-400">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-alert-icon lucide-circle-alert shrink-0"><circle cx="12" cy="12" r="10"/><line x1="12" x2="12" y1="8" y2="12"/><line x1="12" x2="12.01" y1="16" y2="16"/></svg>
                            Format JPG atau PNG, ukuran maksimal 1MB
                        </div>
                        <div class="flex flex-wrap gap-4">
                            <input type="file" accept=".jpg, .jpeg, .png" class="hidden" name="community_logo" id="community_logo" @change="onLogoInputChange" ref="logo-input">
                            <Button as="label" for="community_logo" class="whitespace-nowrap">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-upload-icon lucide-upload shrink-0"><path d="M12 3v12"/><path d="m17 8-5-5-5 5"/><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/></svg>
                                Unggah logo
                            </Button>
                            <input type="hidden" name="delete_community_logo" value="false" ref="delete-logo">
                            <Button variant="outlined" @click="clearLogoInput" type="button" class="whitespace-nowrap">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trash2-icon lucide-trash-2 shrink-0"><path d="M10 11v6"/><path d="M14 11v6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6"/><path d="M3 6h18"/><path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                                Hapus logo
                            </Button>
                        </div>
                        <p class="text-danger-500 text-sm" v-if="errors.community_logo">{{ errors.community_logo }}</p>
                    </div>
                    <div class="flex flex-col gap-2 lg:max-w-150">
                        <label for="email" class="font-semibold">Email</label>
                        <TextField id="email" name="email" placeholder="Email" type="email" :value="setting.email" />
                        <p class="text-danger-500 text-sm" v-if="errors.email">{{ errors.email }}</p>
                    </div>
                    <div class="flex flex-col gap-2 lg:max-w-150">
                        <label for="telephone" class="font-semibold">Telepon</label>
                        <TextField id="telephone" name="telephone" placeholder="Telepon" :value="setting.telephone" />
                        <p class="text-danger-500 text-sm" v-if="errors.telephone">{{ errors.telephone }}</p>
                    </div>
                    <div class="flex flex-col gap-2 lg:max-w-150">
                        <label for="address" class="font-semibold">Alamat</label>
                        <TextField id="address" name="address" placeholder="Alamat" as="textarea" :value="setting.address" />
                        <p class="text-danger-500 text-sm" v-if="errors.address">{{ errors.address }}</p>
                    </div>
                    <div class="flex flex-col gap-2 lg:max-w-150">
                        <label for="x_account_url" class="font-semibold">Tautan akun X</label>
                        <TextField id="x_account_url" name="x_account_url" placeholder="Tautan akun X" :value="setting.x_account_url" />
                        <p class="text-danger-500 text-sm" v-if="errors.x_account_url">{{ errors.x_account_url }}</p>
                    </div>
                    <div class="flex flex-col gap-2 lg:max-w-150">
                        <label for="facebook_account_url" class="font-semibold">Tautan akun Facebook</label>
                        <TextField id="facebook_account_url" name="facebook_account_url" placeholder="Tautan akun Facebook" :value="setting.facebook_account_url" />
                        <p class="text-danger-500 text-sm" v-if="errors.facebook_account_url">{{ errors.facebook_account_url }}</p>
                    </div>
                    <div class="flex flex-col gap-2 lg:max-w-150">
                        <label for="linkedin_account_url" class="font-semibold">Tautan akun LinkedIn</label>
                        <TextField id="linkedin_account_url" name="linkedin_account_url" placeholder="Tautan akun LinkedIn" :value="setting.linkedin_account_url" />
                        <p class="text-danger-500 text-sm" v-if="errors.linkedin_account_url">{{ errors.linkedin_account_url }}</p>
                    </div>
                    <div class="flex flex-col gap-2 lg:max-w-150">
                        <label for="skype_account_url" class="font-semibold">Tautan akun Skype</label>
                        <TextField id="skype_account_url" name="skype_account_url" placeholder="Tautan akun Skype" :value="setting.skype_account_url" />
                        <p class="text-danger-500 text-sm" v-if="errors.skype_account_url">{{ errors.skype_account_url }}</p>
                    </div>
                    <div class="flex flex-col gap-2 lg:max-w-150">
                        <label for="instagram_account_url" class="font-semibold">Tautan akun Instagram</label>
                        <TextField id="instagram_account_url" name="instagram_account_url" placeholder="Tautan akun Instagram" :value="setting.instagram_account_url" />
                        <p class="text-danger-500 text-sm" v-if="errors.instagram_account_url">{{ errors.instagram_account_url }}</p>
                    </div>
                    <div class="flex flex-col gap-2 lg:max-w-150">
                        <label for="youtube_account_url" class="font-semibold">Tautan akun YouTube</label>
                        <TextField id="youtube_account_url" name="youtube_account_url" placeholder="Tautan akun YouTube" :value="setting.youtube_account_url" />
                        <p class="text-danger-500 text-sm" v-if="errors.youtube_account_url">{{ errors.youtube_account_url }}</p>
                    </div>
                    <div class="flex flex-col gap-2 lg:max-w-150">
                        <label for="account_holder_name" class="font-semibold">Nama pemilik rekening</label>
                        <TextField id="account_holder_name" name="account_holder_name" placeholder="Nama pemilik rekening" :value="setting.account_holder_name" />
                        <p class="text-danger-500 text-sm" v-if="errors.account_holder_name">{{ errors.account_holder_name }}</p>
                    </div>
                    <div class="flex flex-col gap-2 lg:max-w-150">
                        <label for="account_number" class="font-semibold">Nomor rekening</label>
                        <TextField id="account_number" name="account_number" placeholder="Nomor rekening" :value="setting.account_number" />
                        <p class="text-danger-500 text-sm" v-if="errors.account_number">{{ errors.account_number }}</p>
                    </div>
                    <div class="flex flex-col gap-2 lg:max-w-150">
                        <label for="youtube_account_url" class="font-semibold">Nama bank pemilik rekening</label>
                        <TextField id="youtube_account_url" name="youtube_account_url" placeholder="Nama bank pemilik rekening" :value="setting.youtube_account_url" />
                        <p class="text-danger-500 text-sm" v-if="errors.youtube_account_url">{{ errors.youtube_account_url }}</p>
                    </div>
                    <div class="flex flex-col gap-2 lg:max-w-150">
                        <label for="membership_fee" class="font-semibold">Biaya langganan membership</label>
                        <TextField id="membership_fee" name="membership_fee" placeholder="Biaya langganan membership" :value="setting.membership_fee" />
                        <p class="text-danger-500 text-sm" v-if="errors.membership_fee">{{ errors.membership_fee }}</p>
                    </div>
                    <div class="flex flex-col gap-2 lg:max-w-150">
                        <label for="membership_duration" class="font-semibold">Masa berlaku membership (bulan)</label>
                        <TextField id="membership_duration" name="membership_duration" placeholder="Masa berlaku membership (bulan)" :value="setting.membership_duration" />
                        <p class="text-danger-500 text-sm" v-if="errors.membership_duration">{{ errors.membership_duration }}</p>
                    </div>
                    <div class="flex flex-col gap-2 lg:max-w-150">
                        <label for="invoice_countdown" class="font-semibold">Tagihan member kadaluarsa dalam (jam)</label>
                        <TextField id="invoice_countdown" name="invoice_countdown" placeholder="Tagihan member kadaluarsa dalam (jam)" :value="setting.invoice_countdown" />
                        <p class="text-danger-500 text-sm" v-if="errors.invoice_countdown">{{ errors.invoice_countdown }}</p>
                    </div>
                    <div class="flex flex-col gap-2 lg:max-w-150">
                        <label for="primary_color" class="font-semibold">Warna primary</label>
                        <input id="primary_color" name="primary_color" type="color" :value="setting.primary_color">
                        <p class="text-danger-500 text-sm" v-if="errors.primary_color">{{ errors.primary_color }}</p>
                    </div>
                    <div class="flex flex-col gap-2 lg:max-w-150">
                        <label for="surface_color" class="font-semibold">Warna surface</label>
                        <input id="surface_color" name="surface_color" type="color" :value="setting.surface_color">
                        <p class="text-danger-500 text-sm" v-if="errors.surface_color">{{ errors.surface_color }}</p>
                    </div>
                    <div class="flex flex-col gap-4 lg:max-w-150">
                        <label class="font-semibold">Gambar latar belakang</label>
                        <img :src="setting.background_image ? `${storageUrl}/${setting.background_image}` : `${appUrl}/images/placeholder.svg`" alt="Latar Belakang" class="w-32 aspect-square object-cover rounded-lg border border-onyx-200" ref="background">
                        <div class="flex gap-2 text-onyx-400">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-alert-icon lucide-circle-alert shrink-0"><circle cx="12" cy="12" r="10"/><line x1="12" x2="12" y1="8" y2="12"/><line x1="12" x2="12.01" y1="16" y2="16"/></svg>
                            Format JPG atau PNG, ukuran maksimal 1MB
                        </div>
                        <div class="flex flex-wrap gap-4">
                            <input type="file" accept=".jpg, .jpeg, .png" class="hidden" name="background_image" id="background_image" @change="onBackgroundInputChange" ref="background-input">
                            <Button as="label" for="background_image" class="whitespace-nowrap">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-upload-icon lucide-upload shrink-0"><path d="M12 3v12"/><path d="m17 8-5-5-5 5"/><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/></svg>
                                Unggah gambar
                            </Button>
                            <input type="hidden" name="delete_background_image" value="false" ref="delete-background">
                            <Button variant="outlined" @click="clearBackgroundInput" type="button" class="whitespace-nowrap">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trash2-icon lucide-trash-2 shrink-0"><path d="M10 11v6"/><path d="M14 11v6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6"/><path d="M3 6h18"/><path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                                Hapus gambar
                            </Button>
                        </div>
                        <p class="text-danger-500 text-sm" v-if="errors.background_image">{{ errors.background_image }}</p>
                    </div>
                    <div class="flex flex-col gap-2 lg:max-w-150">
                        <label for="hero_title" class="font-semibold">Judul Hero Section</label>
                        <TextField id="hero_title" name="hero_title" placeholder="Judul Hero Section" as="textarea" :value="setting.hero_title" />
                        <p class="text-danger-500 text-sm" v-if="errors.hero_title">{{ errors.hero_title }}</p>
                    </div>
                    <div class="flex flex-col gap-2 lg:max-w-150">
                        <label for="hero_description" class="font-semibold">Deskripsi Hero Section</label>
                        <TextField id="hero_description" name="hero_description" placeholder="Deskripsi Hero Section" as="textarea" :value="setting.hero_description" />
                        <p class="text-danger-500 text-sm" v-if="errors.hero_description">{{ errors.hero_description }}</p>
                    </div>
                    <div class="flex flex-col gap-4 lg:max-w-150">
                        <label class="font-semibold">Gambar About Section</label>
                        <img :src="setting.about_image ? `${storageUrl}/${setting.about_image}` : `${appUrl}/images/placeholder.svg`" alt="Tentang" class="w-32 aspect-square object-cover rounded-lg border border-onyx-200" ref="about-image">
                        <div class="flex gap-2 text-onyx-400">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-alert-icon lucide-circle-alert shrink-0"><circle cx="12" cy="12" r="10"/><line x1="12" x2="12" y1="8" y2="12"/><line x1="12" x2="12.01" y1="16" y2="16"/></svg>
                            Format JPG atau PNG, ukuran maksimal 1MB
                        </div>
                        <div class="flex flex-wrap gap-4">
                            <input type="file" accept=".jpg, .jpeg, .png" class="hidden" name="about_image" id="about_image" @change="onAboutImageInputChange" ref="about-image-input">
                            <Button as="label" for="about_image" class="whitespace-nowrap">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-upload-icon lucide-upload shrink-0"><path d="M12 3v12"/><path d="m17 8-5-5-5 5"/><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/></svg>
                                Unggah gambar
                            </Button>
                            <input type="hidden" name="delete_about_image" value="false" ref="delete-about-image">
                            <Button variant="outlined" @click="clearAboutImageInput" type="button" class="whitespace-nowrap">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trash2-icon lucide-trash-2 shrink-0"><path d="M10 11v6"/><path d="M14 11v6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6"/><path d="M3 6h18"/><path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                                Hapus gambar
                            </Button>
                        </div>
                        <p class="text-danger-500 text-sm" v-if="errors.about_image">{{ errors.about_image }}</p>
                    </div>
                    <div class="flex flex-col gap-2 lg:max-w-150">
                        <label for="about_title" class="font-semibold">Judul About Section</label>
                        <TextField id="about_title" name="about_title" placeholder="Judul About Section" as="textarea" :value="setting.about_title" />
                        <p class="text-danger-500 text-sm" v-if="errors.about_title">{{ errors.about_title }}</p>
                    </div>
                    <div class="flex flex-col gap-2 lg:max-w-150">
                        <label for="about_description" class="font-semibold">Deskripsi About Section</label>
                        <TextField id="about_description" name="about_description" placeholder="Deskripsi About Section" as="textarea" :value="setting.about_description" />
                        <p class="text-danger-500 text-sm" v-if="errors.about_description">{{ errors.about_description }}</p>
                    </div>
                    <div class="flex flex-col gap-2 lg:max-w-150">
                        <label for="member_stat_title" class="font-semibold">Judul Stats Section</label>
                        <TextField id="member_stat_title" name="member_stat_title" placeholder="Judul Stats Section" as="textarea" :value="setting.member_stat_title" />
                        <p class="text-danger-500 text-sm" v-if="errors.member_stat_title">{{ errors.member_stat_title }}</p>
                    </div>
                    <div class="flex flex-col gap-2 lg:max-w-150">
                        <label for="member_stat_description" class="font-semibold">Deskripsi Stats Section</label>
                        <TextField id="member_stat_description" name="member_stat_description" placeholder="Deskripsi Stats Section" as="textarea" :value="setting.member_stat_description" />
                        <p class="text-danger-500 text-sm" v-if="errors.member_stat_description">{{ errors.member_stat_description }}</p>
                    </div>
                    <div class="flex flex-col gap-2 lg:max-w-150">
                        <label for="stat_member_active" class="font-semibold">Jumlah member aktif</label>
                        <TextField id="stat_member_active" name="stat_member_active" placeholder="Jumlah member aktif" :value="setting.stat_member_active" />
                        <p class="text-danger-500 text-sm" v-if="errors.stat_member_active">{{ errors.stat_member_active }}</p>
                    </div>
                    <div class="flex flex-col gap-2 lg:max-w-150">
                        <label for="stat_member_inactive" class="font-semibold">Jumlah member nonaktif</label>
                        <TextField id="stat_member_inactive" name="stat_member_inactive" placeholder="Jumlah member nonaktif" :value="setting.stat_member_inactive" />
                        <p class="text-danger-500 text-sm" v-if="errors.stat_member_inactive">{{ errors.stat_member_inactive }}</p>
                    </div>
                    <div class="flex flex-col gap-2 lg:max-w-150">
                        <label for="stat_member_company" class="font-semibold">Jumlah member company</label>
                        <TextField id="stat_member_company" name="stat_member_company" placeholder="Jumlah member company" :value="setting.stat_member_company" />
                        <p class="text-danger-500 text-sm" v-if="errors.stat_member_company">{{ errors.stat_member_company }}</p>
                    </div>
                    <div class="flex flex-col gap-2 lg:max-w-150">
                        <label for="stat_member_personal" class="font-semibold">Jumlah member personal</label>
                        <TextField id="stat_member_personal" name="stat_member_personal" placeholder="Jumlah member personal" :value="setting.stat_member_personal" />
                        <p class="text-danger-500 text-sm" v-if="errors.stat_member_personal">{{ errors.stat_member_personal }}</p>
                    </div>
                    <div class="flex flex-col gap-4 lg:max-w-150">
                        <label class="font-semibold">Gambar latar belakang kartu member</label>
                        <img :src="setting.card_background_image ? `${storageUrl}/${setting.card_background_image}` : `${appUrl}/images/placeholder.svg`" alt="Latar Belakang Kartu Member" class="w-32 aspect-square object-cover rounded-lg border border-onyx-200" ref="card-background">
                        <div class="flex gap-2 text-onyx-400">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-alert-icon lucide-circle-alert shrink-0"><circle cx="12" cy="12" r="10"/><line x1="12" x2="12" y1="8" y2="12"/><line x1="12" x2="12.01" y1="16" y2="16"/></svg>
                            Format JPG atau PNG, ukuran maksimal 1MB
                        </div>
                        <div class="flex flex-wrap gap-4">
                            <input type="file" accept=".jpg, .jpeg, .png" class="hidden" name="card_background_image" id="card_background_image" @change="onCardBackgroundInputChange" ref="card-background-input">
                            <Button as="label" for="card_background_image" class="whitespace-nowrap">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-upload-icon lucide-upload shrink-0"><path d="M12 3v12"/><path d="m17 8-5-5-5 5"/><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/></svg>
                                Unggah gambar
                            </Button>
                            <input type="hidden" name="delete_card_background_image" value="false" ref="delete-card-background">
                            <Button variant="outlined" @click="clearCardBackgroundInput" type="button" class="whitespace-nowrap">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trash2-icon lucide-trash-2 shrink-0"><path d="M10 11v6"/><path d="M14 11v6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6"/><path d="M3 6h18"/><path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                                Hapus gambar
                            </Button>
                        </div>
                        <p class="text-danger-500 text-sm" v-if="errors.card_background_image">{{ errors.card_background_image }}</p>
                    </div>
                    <div class="flex flex-col gap-4 lg:max-w-150">
                        <label class="font-semibold">Tanda tangan ketua</label>
                        <img :src="setting.leader_sign_image ? `${storageUrl}/${setting.leader_sign_image}` : `${appUrl}/images/placeholder.svg`" alt="Tanda Tangan Ketua" class="w-32 aspect-square object-cover rounded-lg border border-onyx-200" ref="leader-sign">
                        <div class="flex gap-2 text-onyx-400">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-alert-icon lucide-circle-alert shrink-0"><circle cx="12" cy="12" r="10"/><line x1="12" x2="12" y1="8" y2="12"/><line x1="12" x2="12.01" y1="16" y2="16"/></svg>
                            Format JPG atau PNG, ukuran maksimal 1MB
                        </div>
                        <div class="flex flex-wrap gap-4">
                            <input type="file" accept=".jpg, .jpeg, .png" class="hidden" name="leader_sign_image" id="leader_sign_image" @change="onLeaderSignInputChange" ref="leader-sign-input">
                            <Button as="label" for="leader_sign_image" class="whitespace-nowrap">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-upload-icon lucide-upload shrink-0"><path d="M12 3v12"/><path d="m17 8-5-5-5 5"/><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/></svg>
                                Unggah gambar
                            </Button>
                            <input type="hidden" name="delete_leader_sign_image" value="false" ref="delete-leader-sign">
                            <Button variant="outlined" @click="clearLeaderSignInput" type="button" class="whitespace-nowrap">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trash2-icon lucide-trash-2 shrink-0"><path d="M10 11v6"/><path d="M14 11v6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6"/><path d="M3 6h18"/><path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                                Hapus gambar
                            </Button>
                        </div>
                        <p class="text-danger-500 text-sm" v-if="errors.leader_sign_image">{{ errors.leader_sign_image }}</p>
                    </div>
                </div>
            </Form>
        </main>
    </SuperAdminLayout>
</template>
