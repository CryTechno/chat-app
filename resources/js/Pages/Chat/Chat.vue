<script setup>
import ChatSpace from '@/components/ChatSpace/ChatSpace.vue'
import MessageList from '@/components/Messages/MessageList.vue'
</script>

<template>
  <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2">
    <div class="flex flex-row w-[1280px] bg-[#303134] h-[800px]">
      <div class="w-1/5 shadow-inner flex flex-col text-roboto text-white text-xl opacity-70 items-center m-auto">When it
        will
        be...</div>
      <div class="w-3/5 flex flex-col h-full ">
        <MessageList class="shadow-inner w-full" />
        <ChatSpace />



      </div>
      <div class="w-1/5 shadow-inner flex flex-col text-roboto text-white text-xl opacity-70 items-center m-auto">Group
        info</div>
    </div>
  </div>
</template>
