<script setup>
    import { useGlobalStore } from '../stores/global'

    const global = useGlobalStore()
</script>
<template>
    <footer class="w-full border-t-2 border-lime-600 z-0">
        <div class="grid lg:grid-cols-3 py-4 bg-lime-muni background-mapa">
            <div class="flex justify-center z-10 ">
                <img src="../assets/img/logo.svg" class="w-48" alt="">
            </div>
            <div class=" text-center lg:text-left text-blue-muni z-10">
                <h1 class="text-2xl lg:text-3xl font-bold  lg:tracking-[.25em]">¿ Necesitas ayuda ?</h1>
                <br>
                <div class="text-sm lg:text-lg">
                    <div class="flex space-x-4 items-center justify-center lg:justify-start">
                        <icon icon="fa-solid fa-envelope" class=" lg:text-xl " />
                        <h2>gestiondeserviciosdcai@muniguate.com</h2>
                    </div>
                    <div class="flex space-x-4 items-center justify-center lg:justify-start">
                        <icon icon="fa-solid fa-phone" class="text-xl lg:text-xl " />
                        <h2>2285-8610</h2>
                    </div>
                    <hr class="my-2 border-green-600 border-2">
                    <div class="flex space-x-4 items-center justify-center lg:justify-start">
                        <icon icon="fa-solid fa-envelope" class=" lg:text-xl " />
                        <h2>soportecatastro@muniguate.com</h2>
                    </div>
                    <div class="flex space-x-4 items-center justify-center lg:justify-start">
                        <icon icon="fa-solid fa-phone" class="text-xl lg:text-xl " />
                        <h2>2285-8687</h2>
                    </div>
                </div>
            </div>
            <div class="flex items-end text-blue-muni z-10">
                <p class=" font-medium text-center ">© {{ global.year.getFullYear() }} Dirección de Catastro y Administración del IUSI</p>
            </div>
        </div>
    </footer>
</template>

<style scoped>
    .background-mapa {
        background-image: url('../assets/img/mapa.svg');
        background-size: 119rem ;
        background-position: center;
        background-repeat: no-repeat;
    }
</style>