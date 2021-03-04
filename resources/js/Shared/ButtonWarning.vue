<template>
    <button :type="type" class="py-2 px-4 bg-yellow-300 text-white uppercase text-sm font-bold hover:bg-yellow-400">
        <slot></slot>
    </button>
</template>

<script>
export default {
    props: {
        type: {
            type: String,
            default: 'submit',
        },
    }
}
</script>