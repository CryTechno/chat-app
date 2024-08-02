<script setup>
import ChatModal from '@/Components/ui/Chat/ChatModal.vue'
import MessageList from '@/Components/ui/Messages/MessageList.vue'
import ChannelsModal from '@/Components/ui/Channels/ChannelsModal.vue'
import { Centrifuge } from 'centrifuge';
import {router, usePage} from '@inertiajs/vue3';
import {ref, onMounted, watch, computed, Suspense, watchEffect} from 'vue';
import Cookies from 'js-cookie';
import Http from "@/services/httpRequests.js"
import InputError from "@/Components/ui/Shared/InputError.vue";

const page = usePage()
const currentUserName = computed(() => page.props.auth.user.name);
const token = computed(() => page.props.token);
const csrfToken = ref('');
const errorValidateMessagesRoomName = ref('')

const logout = () => {
    router.post('/logout')
}
const newRoomName = ref('');
const rooms = ref([]);
const activeRoom = ref(null);
const messages = ref([]);
const createRoom = (name) => {
    return Http(csrfToken.value).post('/rooms',{name})
        .then(res => res.data)
        .catch((error) => {
            console.log(error)
            return error.response ? error.response.data : { error: 'Unexpected error' };
        })
}

const handleCreateRoom = async (name) => {
    const data = await createRoom(name);
    if (data.rooms) {
        rooms.value = [...data.rooms].reverse();
        newRoomName.value ="";
        data.rooms.value = null;
    }
    else {
        errorValidateMessagesRoomName.value = data.message
    }
};

const sendMessage = async (message) => {
    if (message.length > 0) {
        try {
            await Http(csrfToken.value).post(`/rooms/${activeRoom.value}/publish`,{"message" : message})

        } catch (err) {
            console.error(err);
        }
    }
}

const getRooms = () => {
    return Http(csrfToken.value).get('/rooms')
    .then(res => res.data)
    .catch((error) => {
        console.log(error)
        return [];
    });
}

const addMessage = (message) => {
    messages.value.push(message);
}
function replaceTag(tag) {
    return tagsToReplace[tag] || tag;
}
const onRoomChange = (room) =>{
    if (activeRoom.value !== room.id ){
        activeRoom.value = room.id;
        messages.value = [...room.messages];
        const usersNames = room.users.map((user) => user.name);
        if(usersNames.indexOf(currentUserName.value)===-1){
            joinUserInRoom(room.id);
        }
    }
}

const joinUserInRoom = async (roomId) => {
    const res = await Http(csrfToken.value).post(`/rooms/${roomId}`)
        .then(res => res.data.rooms)
        .catch(error => {
            console.log(error)
            return null
        })
    if (res) {
        rooms.value = res;
    }
}

const initCentrifugo = () => {
    const centrifugo = new Centrifuge("wss://centrifugo." + window.location.host + "/connection/websocket",{
        token:token.value,
    });
    centrifugo.on('connect', function(ctx) {
        console.log("connected", ctx);
    });

    centrifugo.on('disconnect', function(ctx) {
        console.log("disconnected", ctx);
    });

    centrifugo.on('publication', function(ctx) {
        if (ctx.data.roomId === activeRoom.value) {
            const index = rooms.value.findIndex(room => room.id === ctx.data.roomId);
            rooms.value[index].messages.push(ctx.data)
            addMessage(ctx.data);
        }
    });

    centrifugo.connect();
};

// init Centrifugo on mounted component
onMounted(async () => {
    getRooms().then(res => {
        rooms.value = [...res.rooms].reverse();
    });
    initCentrifugo();
    csrfToken.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
});


</script>

<template>
    <div class="relative w-screen h-screen bg-bgblack">
      <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2">
        <div class="flex flex-row w-[1280px] bg-[#303134] h-[800px]">
            <Suspense>
                <ChannelsModal :active-room = 'activeRoom' :rooms = "rooms" @on-room-change="onRoomChange"  />
            </Suspense>
          <div class="w-3/5 flex flex-col h-full ">
            <MessageList :messages = 'messages' :active-room = 'activeRoom' class="shadow-inner w-full" />
          <Suspense>
            <ChatModal :active-room="activeRoom" @send-messages="sendMessage" />
          </Suspense>
          </div>
          <div class="w-1/5 shadow-inner flex flex-col text-roboto  text-xl opacity-70 items-center m-auto ">
              <div class="text-white">Hello, {{currentUserName}}</div>
              <div class="cursor-pointer hover:text-secondary" @click="logout">LOGOUT</div>
              <input placeholder="Name Room..." type="text" v-model="newRoomName" class="text-gray-700" >
              <InputError v-if="errorValidateMessagesRoomName" class="mt-2" :message="errorValidateMessagesRoomName"  />
              <div class="cursor-pointer hover:text-secondary" @click="handleCreateRoom(newRoomName)">Create Room</div>
          </div>
        </div>
      </div>
    </div>
</template>
