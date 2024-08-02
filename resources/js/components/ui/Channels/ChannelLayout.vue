<script setup>
    import ChannelIcon from "@/assets/icons/ChannelIcon.vue";
    defineProps({
        roomName:String,
    })

</script>

<template>
    <div class="flex gap-2">
        <div class="w-[50px] flex justify-center items-center ">
            <slot name = 'img'></slot>
        </div>
        <div class="">
            <div class="shadow-inner flex flex-col text-roboto text-white text-xl opacity-70 ">
                <slot name ="nameChannel"></slot>
            </div>
            <div class="max-w-[200px] flex flex-row">
                <slot name ="name"></slot>
                <slot name ="message"></slot>
            </div>
        </div>
    </div>
</template>
