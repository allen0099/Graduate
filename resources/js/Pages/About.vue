<template>
    <div class="container py-8">
        <div class="space-x-3 pb-2 border-b border-purple-200">
            <inertia-link href="/test" class="link">Hello world</inertia-link>
            <inertia-link href="/about" class="link">About</inertia-link>
            <inertia-link href="/fail" class="link">Fail</inertia-link>
        </div>
        <h1 class="text-2xl mt-2">About</h1>
    </div>
</template>

<script>
export default {
    metaInfo: {
        title: 'About'
    },
}
</script>
