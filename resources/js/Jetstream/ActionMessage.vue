<template>
    <div>
        <transition
            leave-active-class="transition ease-in duration-1000"
            leave-class="opacity-100"
            leave-to-class="opacity-0"
        >
            <div
                v-show="on"
                class="text-sm"
                :class="classTextColor"
            >
                <slot />
            </div>
        </transition>
    </div>
</template>

<script>
    export default {
        props: ['on', 'color'],
        computed: {
            classTextColor() {
                return this.color ? 'text-' + this.color + '-600' : 'text-gray-600'
            }
        }
    }

</script>
