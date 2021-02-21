<template>
    <div>
        <div class="min-h-screen bg-gray-100">
            <navbar></navbar>

            <!-- Page Heading -->
            <header class="bg-white shadow" v-if="$slots.header">
                <div class="max-w-7xl mx-auto py-5 px-4 sm:px-6 lg:px-8">
                    <slot name="header"></slot>
                </div>
            </header>

            <!-- Page Content -->
            <main>
                <slot></slot>
            </main>
        </div>
    </div>
</template>

<script>
    import JetBanner from '@/Jetstream/Banner'
    import Navbar from '@/Shared/Navbar'

    export default {
        components: {
            JetBanner,
            Navbar,
        },
    }
</script>
