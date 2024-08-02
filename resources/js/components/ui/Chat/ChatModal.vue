<script setup>
import {ref, computed} from 'vue'
import SendIcon from '@/assets/icons/SendIcon.vue'
import EmojisIcon from '@/assets/icons/EmojisIcon.vue'

const emits = defineEmits(['send-messages']);
defineProps({
    activeRoom: Number,
})

const tagsToReplace = {
    '&': '&amp;',
    '<': '&lt;',
    '>': '&gt;'
};
const textarea = ref(null)
const text = ref("")
const classSendIcon = computed(() => ({
  'fill-gray-300': text.value.trim(),
  'fill-gray-500': !text.value.trim()
}))

function safeTagsReplace(str) {
    return str.replace(/[&<>]/g, match => tagsToReplace[match]);
}
const sendMessage = (event) => {
    if (event) {
        event.preventDefault();
    }
    const trimmedText = safeTagsReplace(text.value).trim();
    if (trimmedText.length > 0) {
        emits('send-messages', trimmedText);
        text.value = '';
    }
};
const resizeTextArea = () => {
  if (textarea.value.scrollHeight <= 4 * 28) {
    textarea.value.style.height = '28px'
    textarea.value.style.height = textarea.value.scrollHeight + 'px'
  }
}

</script>

<template>
  <div v-if="activeRoom" class="relative flex shadow-inner w-full py-[12px] pl-3">
    <textarea @input="resizeTextArea" v-model="text" ref="textarea" rows="1" @keydown.enter="sendMessage"
      placeholder="Write a message..."
      class="w-full min-h-[48px] resize-none text-lg text-roboto text-white pr-24 focus:ring-0 focus:outline-none bg-transparent placeholder-white/50 no-scrollbar" />
    <button @click="sendMessage" class="absolute right-3 top-1/2 -translate-y-1/2 focus:outline-none hover:scale-110">
      <SendIcon class="w-8 h-8" :class="classSendIcon" />
    </button>
    <button class="absolute right-12 top-1/2 -translate-y-1/2 focus:outline-none hover:scale-110">
      <EmojisIcon class="w-9 h-9 fill-gray-300" />
    </button>
  </div>
</template>
