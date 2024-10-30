<script setup>
    import BackTop from '@/components/BackTop.vue'
    import NavBar from '@/components/NavBar.vue'
    import axios from 'axios';
    import { onMounted, ref } from 'vue';

    const direccion = ref({})

    const fetchDireccion = () => {
        axios.get('direcciones/index/'+ localStorage.getItem('direccion_id'))
        .then(response =>  direccion.value = response.data[0])
        .catch(error => console.error(error.response.data))
    }

    onMounted(() => fetchDireccion())

</script>

<template>
    <main>
        <NavBar :title="direccion.nombre" />
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
