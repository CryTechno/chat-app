<template>
    <div class="pl-2 text-roboto text-secondary font-bold text-s">
        <slot name="name"></slot>
    </div>
    <div class="pl-2 text-roboto text-primary text-s">
        <slot name="content"></slot>
    </div>
    <p class="justify-end text-roboto text-secondary text-sm">
        <slot name="timestamp"></slot>
    </p>
</template>
