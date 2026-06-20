<script setup>
import DashboardHeader from "../../../Components/DashboardHeader.vue";
import LeaderLayout from "../../../Layouts/LeaderLayout.vue";
import { cn } from "../../../lib/utils.js";
</script>

<template>
    <LeaderLayout>
        <DashboardHeader title="Statistik">
        </DashboardHeader>
        <main class="flex-1 overflow-auto">
            <div class="flex flex-col gap-8 p-8 lg:min-h-full">
                <div class="flex-1 flex flex-col gap-8 justify-between">
                </div>
            </div>
        </main>
    </LeaderLayout>
</template>

