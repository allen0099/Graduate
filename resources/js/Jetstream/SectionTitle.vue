<template>
    <div class="md:col-span-1">
        <div class="px-4 px-sm-0">
            <h3 class="title font-weight-medium">
                <slot name="title"></slot>
            </h3>
            <p class="mt-1 subtitle-2">
                <slot name="description"></slot>
            </p>
        </div>
    </div>
</template>
