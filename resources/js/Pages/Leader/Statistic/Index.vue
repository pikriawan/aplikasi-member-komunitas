<script setup>
import { usePage } from "@inertiajs/vue3";
import { computed } from "vue";
import { Line } from "vue-chartjs";
import { Chart as ChartJS, Title, Tooltip, Legend, LineElement, PointElement, LinearScale, CategoryScale } from "chart.js";
import DashboardHeader from "../../../Components/DashboardHeader.vue";
import LeaderLayout from "../../../Layouts/LeaderLayout.vue";
import { cn } from "../../../lib/utils.js";

const page = usePage();

const memberProfiles = computed(() => page.props.memberProfiles);
const contents = computed(() => page.props.contents);
const posts = computed(() => page.props.posts);
const invoices = computed(() => page.props.invoices);

const chartOptions = { responsive: true };

ChartJS.register(Title, Tooltip, Legend, LineElement, PointElement, LinearScale, CategoryScale);
</script>

<template>
    <LeaderLayout>
        <DashboardHeader title="Statistik">
        </DashboardHeader>
        <main class="flex-1 overflow-auto">
            <div class="flex flex-col gap-8 p-8 lg:grid grid-cols-[repeat(auto-fill,minmax(25rem,1fr))]">
                <div class="flex flex-col gap-4">
                    <h2 class="font-semibold">Statistik Member</h2>
                    <div>
                        <Line :data="memberProfiles" :options="chartOptions" />
                    </div>
                </div>
                <div class="flex flex-col gap-4">
                    <h2 class="font-semibold">Statistik Konten</h2>
                    <div>
                        <Line :data="contents" :options="chartOptions" />
                    </div>
                </div>
                <div class="flex flex-col gap-4">
                    <h2 class="font-semibold">Statistik Postingan</h2>
                    <div>
                        <Line :data="posts" :options="chartOptions" />
                    </div>
                </div>
                <div class="flex flex-col gap-4">
                    <h2 class="font-semibold">Statistik Pendapatan</h2>
                    <div>
                        <Line :data="invoices" :options="chartOptions" />
                    </div>
                </div>
            </div>
        </main>
    </LeaderLayout>
</template>
