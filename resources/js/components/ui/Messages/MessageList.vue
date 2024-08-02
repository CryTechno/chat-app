<script setup>
import Message from './Message.vue'
import {computed, nextTick, onMounted, ref, watch, watchEffect} from 'vue'
import { usePage } from '@inertiajs/vue3'
const page = usePage()
const props = defineProps({
    messages:{type:Object},
    activeRoom : {type:Number}
})
const user = computed(() => page.props.auth.user.name)
const messagesContainer = ref(null)

watch(() => props.messages.length, async (newCount, oldCount) => {
    if (newCount > oldCount) {
        await scrollToBottom();
    }
}, { deep: true });
onMounted(() => {
    if (messagesContainer.value) {
        messagesContainer.value.scrollTop = messagesContainer.value.scrollHeight;
    }
});

const scrollToBottom = async () => {
    await nextTick();
    if (messagesContainer.value) {
        messagesContainer.value.scroll({
            top: messagesContainer.value.scrollHeight,
            behavior: 'smooth' // Плавное скроллирование
        });
    }
};

</script>

<template>
  <div ref="messagesContainer"
    class="relative shadow-inner w-full h-full p-3 scrollbar " >
      <div  v-if="props.messages.length" >
            <Message v-for="message in props.messages" :key="message.id" :name="message.sender_name" :content="message.message" :timestamp="message.created_at" :imSender=" message.sender_name===user" class='mb-3' />
      </div>
      <div v-if="!props.messages.length && activeRoom" class="absolute w-full text-center text-4xl text-secondary top-[50%] left-[50%] translate-x-[-50%]">
          Type your first message!
      </div>
      <div v-if="!props.messages.length && !activeRoom" class="absolute w-full text-center text-4xl text-secondary top-[50%] left-[50%] translate-x-[-50%]">
          Choose or create a room!
      </div>
  </div>
</template>

<style scoped>

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
