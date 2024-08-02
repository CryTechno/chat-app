<script setup>
import MessageLayout from './MessageLayout.vue';


defineProps({
    content: { type: String },
    name: { type: String },
    imSender: { type: Boolean },
    timestamp: { type: String},
})

</script>
<template>
      <div class="flex" :class = "imSender ? 'justify-end ' : 'justify-start '">
        <div class="flex flex-col bg-gray-700 p-3 " :class = "imSender ? 'rounded-l-3xl rounded-tr-[30px] ' : 'rounded-r-3xl rounded-tl-[30px] '">
          <MessageLayout>
            <template #name>
              {{ name }}
            </template>
            <template #content>
              {{ content }}
            </template>
            <template #timestamp>
              {{new Date(timestamp).toLocaleTimeString ('ua-UA', {
                hour: '2-digit',
                minute: '2-digit',
                hour12: false
            })}}
            </template>
          </MessageLayout>
        </div>
      </div>
</template>

