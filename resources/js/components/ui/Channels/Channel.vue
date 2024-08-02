<script setup>
    import ChannelLayout from "@/Components/ui/Channels/ChannelLayout.vue";
    import {ref} from "vue";

    defineProps({
        message: { type: String, default: 'no messages' },
        roomName: { type: String, default: 'load' },
        userName: { type: String, default: '' },
    })

    const truncate = function (text, length, suffix){
        if (text.length > length) {
            text = text.replace(/\n/g, ' ');
            return text.substring(0, length) + suffix;
        } else {
            return text;
        }
    }
    const isSelect = ref(false);


</script>

<template>
    <div class="w-[250px] h-[80px] p-4 hover:bg-gray-600 cursor-pointer select-none">
    <ChannelLayout>
        <template #img>
            <img class="min-w-[50px]" :src="`https://robohash.org/${encodeURIComponent(roomName)}`" alt="avatar">
        </template>
        <template #nameChannel>
            {{ roomName }}
        </template>
        <template #name>
            <span v-if="userName" class="text-roboto text-white font-bold text-s after:content-[':']">{{truncate(userName, 6, "...")}}</span>
        </template>
        <template #message>
            <span class="text-roboto text-secondary text-s pl-1">{{truncate(message, 9, "...")}}</span>
        </template>
        </ChannelLayout>
    </div>
</template>
