<script setup>
import ApplicationLogo from '@/Components/ui/Shared/ApplicationLogo.vue';
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-bgblack">
        <div>
            <Link href="/">
                <ApplicationLogo class="w-40 h-40 fill-current text-white" viewBox="0 0 420 420" />
            </Link>
        </div>

        <div
            class="w-full sm:max-w-md mt-6 px-6 py-4 bg-bgsecondary shadow-md overflow-hidden sm:rounded-lg"
        >
            <slot />
        </div>
    </div>
</template>
