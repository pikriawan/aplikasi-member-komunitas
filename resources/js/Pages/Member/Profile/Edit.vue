<script setup>
import { Form, usePage } from "@inertiajs/vue3";
import { computed, useTemplateRef } from "vue";
import DashboardHeader from "../../../Components/DashboardHeader.vue";
import Button from "../../../Components/Ui/Button.vue";
import Popover from "../../../Components/Ui/Popover.vue";
import PopoverContent from "../../../Components/Ui/PopoverContent.vue";
import PopoverTrigger from "../../../Components/Ui/PopoverTrigger.vue";
import TextField from "../../../Components/Ui/TextField.vue";
import MemberLayout from "../../../Layouts/MemberLayout.vue";

const page = usePage();

const appUrl = computed(() => page.props.appUrl);
const storageUrl = computed(() => page.props.storageUrl);
const user = computed(() => page.props.user);
const memberProfile = computed(() => page.props.memberProfile);

const profileImage = useTemplateRef("profile-image");
const profileImageInput = useTemplateRef("profile-image-input");
const deleteProfileImage = useTemplateRef("delete-profile-image");

function onProfileImageInputChange(event) {
    const fileList = event.target.files;

    if (fileList.length === 1) {
        profileImage.value.src = URL.createObjectURL(fileList[0]);
    }

    deleteProfileImage.value.value = "false";
}

function clearProfileImageInput() {
    profileImageInput.value.value = "";
    profileImage.value.src = `${appUrl.value}/images/profile-placeholder.svg`;
    deleteProfileImage.value.value = "true";
}
</script>

<template>
    <MemberLayout>
        <DashboardHeader title="Edit Profil" :back-href="route('member.profile.index')">
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
            <Form id="edit_profile" class="flex flex-col gap-8 p-8 lg:min-h-full" :action="route('member.profile.update')" method="post" enctype="multipart/form-data" v-slot="{ errors }">
                <div class="flex flex-col gap-8">
                    <div class="flex flex-col gap-4 lg:max-w-150">
                        <label class="font-semibold">Foto profil</label>
                        <img :src="memberProfile.image_url ? `${storageUrl}/${memberProfile.image_url}` : `${appUrl}/images/profile-placeholder.svg`" alt="Profile" class="w-32 aspect-square object-cover rounded-full" ref="profile-image">
                        <div class="flex gap-2 text-onyx-400">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-alert-icon lucide-circle-alert shrink-0"><circle cx="12" cy="12" r="10"/><line x1="12" x2="12" y1="8" y2="12"/><line x1="12" x2="12.01" y1="16" y2="16"/></svg>
                            Format JPG atau PNG, ukuran maksimal 1MB
                        </div>
                        <div class="flex flex-wrap gap-4">
                            <input type="file" accept=".jpg, .jpeg, .png, " class="hidden" name="profile_image" id="profile_image" @change="onProfileImageInputChange" ref="profile-image-input">
                            <Button as="label" for="profile_image" class="whitespace-nowrap">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-upload-icon lucide-upload shrink-0"><path d="M12 3v12"/><path d="m17 8-5-5-5 5"/><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/></svg>
                                Unggah foto profil
                            </Button>
                            <input type="hidden" name="delete_profile_image" value="false" ref="delete-profile-image">
                            <Button variant="outlined" @click="clearProfileImageInput" type="button" class="whitespace-nowrap">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trash2-icon lucide-trash-2 shrink-0"><path d="M10 11v6"/><path d="M14 11v6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6"/><path d="M3 6h18"/><path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                                Hapus foto profil
                            </Button>
                        </div>
                        <p class="text-danger-500 text-sm" v-if="errors.profile_image">{{ errors.profile_image }}</p>
                    </div>
                    <div class="flex flex-col gap-2 lg:max-w-150">
                        <label for="telephone" class="font-semibold">Nomor telepon</label>
                        <TextField id="telephone" name="telephone" placeholder="Nomor telepon" :value="user.telephone" />
                        <p class="text-danger-500 text-sm" v-if="errors.telephone">{{ errors.telephone }}</p>
                    </div>
                    <div class="flex flex-col gap-2">
                        <span class="font-medium">Jenis kelamin</span>
                        <div class="flex flex-col gap-2">
                            <label class="flex items-center gap-2" for="gender_male">
                                <input type="radio" name="gender" id="gender_male" value="Laki-laki" :checked="memberProfile.gender === 'Laki-laki'">
                                <span>Laki-laki</span>
                            </label>
                            <label class="flex items-center gap-2" for="gender_female">
                                <input type="radio" name="gender" id="gender_female" value="Perempuan" :checked="memberProfile.gender === 'Perempuan'">
                                <span>Perampuan</span>
                            </label>
                            <label class="flex items-center gap-2" for="gender_none">
                                <input class="hidden" type="radio" name="gender" id="gender_none" value="" :checked="!memberProfile.gender">
                                <Button as="span" variant="outlined" type="button">Batalkan pilihan</Button>
                            </label>
                        </div>
                        <p class="text-danger-500 text-sm" v-if="errors.gender">{{ errors.gender }}</p>
                    </div>
                    <div class="flex flex-col gap-2">
                        <span class="font-medium">Golongan darah</span>
                        <div class="flex flex-col gap-2">
                            <label class="flex items-center gap-2" for="blood_type_a">
                                <input type="radio" name="blood_type" id="blood_type_a" value="A" :checked="memberProfile.blood_type === 'A'">
                                <span>A</span>
                            </label>
                            <label class="flex items-center gap-2" for="blood_type_b">
                                <input type="radio" name="blood_type" id="blood_type_b" value="B" :checked="memberProfile.blood_type === 'B'">
                                <span>B</span>
                            </label>
                            <label class="flex items-center gap-2" for="blood_type_ab">
                                <input type="radio" name="blood_type" id="blood_type_ab" value="AB" :checked="memberProfile.blood_type === 'AB'">
                                <span>AB</span>
                            </label>
                            <label class="flex items-center gap-2" for="blood_type_o">
                                <input type="radio" name="blood_type" id="blood_type_o" value="O" :checked="memberProfile.blood_type === 'O'">
                                <span>O</span>
                            </label>
                            <label class="flex items-center gap-2" for="blood_type_none">
                                <input class="hidden" type="radio" name="blood_type" id="blood_type_none" value="" :checked="!memberProfile.blood_type">
                                <Button as="span" variant="outlined" type="button">Batalkan pilihan</Button>
                            </label>
                        </div>
                        <p class="text-danger-500 text-sm" v-if="errors.blood_type">{{ errors.blood_type }}</p>
                    </div>
                    <div class="flex flex-col gap-2 lg:max-w-150">
                        <label for="last_education" class="font-semibold">Pendidikan terakhir</label>
                        <TextField id="last_education" name="last_education" placeholder="Pendidikan terakhir" :value="memberProfile.last_education" />
                        <p class="text-danger-500 text-sm" v-if="errors.last_education">{{ errors.last_education }}</p>
                    </div>
                    <div class="flex flex-col gap-2 lg:max-w-150">
                        <label for="institution" class="font-semibold">Institusi</label>
                        <TextField id="institution" name="institution" placeholder="Institusi" :value="memberProfile.institution" />
                        <p class="text-danger-500 text-sm" v-if="errors.institution">{{ errors.institution }}</p>
                    </div>
                    <div class="flex flex-col gap-2 lg:max-w-150">
                        <label for="department" class="font-semibold">Departemen</label>
                        <TextField id="department" name="department" placeholder="Departemen" :value="memberProfile.department" />
                        <p class="text-danger-500 text-sm" v-if="errors.department">{{ errors.department }}</p>
                    </div>
                    <div class="flex flex-col gap-2 lg:max-w-150">
                        <label for="address" class="font-semibold">Alamat rumah</label>
                        <TextField id="address" name="address" placeholder="Alamat rumah" as="textarea" :value="memberProfile.address" />
                        <p class="text-danger-500 text-sm" v-if="errors.address">{{ errors.address }}</p>
                    </div>
                </div>
                <div class="flex flex-col gap-8">
                    <h2 class="text-2xl font-semibold">Ubah Password</h2>
                    <div class="flex flex-col gap-2 lg:max-w-150">
                        <label for="old_password" class="font-semibold">Password lama</label>
                        <TextField id="old_password" name="old_password" placeholder="Password lama" type="password" />
                        <p class="text-danger-500 text-sm" v-if="errors.old_password">{{ errors.old_password }}</p>
                    </div>
                    <div class="flex flex-col gap-2 lg:max-w-150">
                        <label for="password" class="font-semibold">Password baru</label>
                        <TextField id="password" name="password" placeholder="Password baru" type="password" />
                        <p class="text-danger-500 text-sm" v-if="errors.password">{{ errors.password }}</p>
                    </div>
                    <div class="flex flex-col gap-2 lg:max-w-150">
                        <label for="password_confirmation" class="font-semibold">Konfirmasi password baru</label>
                        <TextField id="password_confirmation" name="password_confirmation" placeholder="Konfirmasi password baru" type="password" />
                        <p class="text-danger-500 text-sm" v-if="errors.password_confirmation">{{ errors.password_confirmation }}</p>
                    </div>
                </div>
            </Form>
        </main>
    </MemberLayout>
</template>
