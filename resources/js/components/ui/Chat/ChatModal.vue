<script setup>
import { ref, computed } from 'vue'
import SendIcon from '@/assets/icons/SendIcon.vue'
import EmojisIcon from '@/assets/icons/EmojisIcon.vue'
import axios from 'axios'

// Изменение высоты при каждой новой строчкой
const textarea = ref(null)
const text = ref('')
const classSendIcon = computed(() => ({
  'fill-gray-300': text.value.trim(),
  'fill-gray-500': !text.value.trim()
}))


const resizeTextArea = () => {
  if (textarea.value.scrollHeight <= 4 * 28) {
    textarea.value.style.height = '28px'
    textarea.value.style.height = textarea.value.scrollHeight + 'px'
  }
  console.log(text.value)
}
const sendMessage = async (event) => {
  event.preventDefault()
  text.value = text.value.trim()
  if (text.value.length > 0) {
    const res = await axios
      .post('https://281345ae1a0e9c9b.mokky.dev/messages', { text: text.value })
      .then((res) => {
        console.log(res)
        text.value = ''
        textarea.value.style.height = '28px'
      })
      .catch((err) => {
        console.log(err)
      })
  } else {
    textarea.value.style.height = '28px'
  }
}
</script>

<template>
  <div class="relative flex shadow-inner w-full py-[12px] pl-3">
    <textarea @input="resizeTextArea" v-model="text" ref="textarea" rows="1" @keydown.enter.exact="sendMessage"
      placeholder="Write a message..."
      class="w-full resize-none bg-transparent text-lg text-roboto text-white pr-24 focus:ring-0 focus:outline-none bg-transparent placeholder-white/50" />
    <button @click="sendMessage" class="absolute right-3 top-1/2 -translate-y-1/2 focus:outline-none hover:scale-110">
      <SendIcon class="w-8 h-8" :class="classSendIcon" />
    </button>
    <button class="absolute right-12 top-1/2 -translate-y-1/2 focus:outline-none hover:scale-110">
      <EmojisIcon class="w-9 h-9 fill-gray-300" />
    </button>
  </div>
</template>
