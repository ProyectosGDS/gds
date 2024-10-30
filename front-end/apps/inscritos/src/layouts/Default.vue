<script setup>
    import BackTop from '@/components/BackTop.vue'
</script>

<template>
    <main>
        <div class="h-screen flex flex-col">
            <section class="flex-1 px-4 md:px-10 pt-20 mb-4">
                <div class="overflow-hidden pb-4">
                    <div>
                        <RouterView/>
                    </div>
                    <BackTop />
                </div>
            </section>
        </div>
    </main>
</template>
