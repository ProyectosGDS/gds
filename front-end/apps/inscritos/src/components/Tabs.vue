<script setup>
    import { useRoute } from 'vue-router'    
    
    const routes = useRoute()
    const props = defineProps(['index']);

</script>

<template>

    <nav class="mb-5 text-violet-500">
        <div class="flex justify-center items-center gap-4 md:gap-10 flex-wrap">
            <template v-for="route in routes.matched[props.index].children">
                <RouterLink :to="{name : route.name}" active-class="border-b-2 border-violet-500 font-bold" >
                    {{ route.name }} 
                </RouterLink>
            </template>
        </div>
    </nav>
</template>
