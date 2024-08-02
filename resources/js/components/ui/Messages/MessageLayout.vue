<template>
    <div class="pl-2 text-roboto text-secondary font-bold text-s">
        <slot name="name"></slot>
    </div>
    <div class="whitespace-pre-wrap break-all pl-2 font-xl text-roboto text-primary text-s max-w-[320px]">
        <slot name="content"></slot>
    </div>
    <p class="text-right text-roboto text-secondary text-sm">
        <slot name="timestamp"></slot>
    </p>
</template>
