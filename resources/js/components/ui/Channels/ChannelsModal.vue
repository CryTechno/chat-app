<script setup>

import Channels from "@/Components/ui/Channels/Channel.vue";
import {router, usePage} from '@inertiajs/vue3';
import {ref, watch} from "vue";


const props = defineProps({
    rooms: { type: Array },
    activeRoom : {type: Number}
});

const emits = defineEmits(['on-room-change'])

const localRooms = [ref(props.rooms)];

watch(() => props.rooms, (newValue) => {
    console.log(newValue)
    localRooms.value = newValue;
});

</script>


<template>
        <div class="scroll-smooth overflow-auto scrollbar">
                <Channels
                v-for = "room in localRooms.value"
                :user-name = room.userN
                :room-name= room.name
                :message = room.message
                :key="room.id"
                @click="emits('on-room-change', room)"
                :class="room.id === activeRoom ? 'bg-gray-800 hover:bg-gray-800 ': ''"
                />
        </div>
</template>
<style scoped>
.scrollbar-closed {
    overflow-y: hidden;
}

.scrollbar {
    overflow-y: scroll;

}




.scrollbar::-webkit-scrollbar {
    width: 7px;
    margin-right: 3px;
}


.scrollbar::-webkit-scrollbar-track:hover {
    background-color: #4b4b4b;
}


.scrollbar::-webkit-scrollbar-thumb {
    background-color: #92929285;
    border-radius: 3px;

}


.scrollbar::-webkit-scrollbar-track {
    background-color: #4d4d4d50;
    border-radius: 3px;
    margin-top: 7px;
    margin-bottom: 7px;
    margin-block: 15px;
}
</style>
