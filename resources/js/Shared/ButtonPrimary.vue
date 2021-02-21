<template>
    <button :type="type" class="py-2 px-4 bg-green-400 text-white uppercase text-sm font-bold hover:bg-green-500">
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