<script setup>
    import { useAuthStore } from '../stores/auth'
    import BackTop from '../components/BackTop.vue'
    import Steps from '../components/Steps.vue'

    const auth = useAuthStore()

</script>

<template>
    <main>
        <div class="h-screen flex flex-col">
            <section class="flex-1 px-4 md:px-10 pt-2 mb-4">
                <div class="overflow-hidden pb-4">
                    <div class="container mx-auto max-w-7xl">
                        <Steps />
                    </div>
                    <BackTop />
                </div>
            </section>
        </div>
    </main> 
</template>
