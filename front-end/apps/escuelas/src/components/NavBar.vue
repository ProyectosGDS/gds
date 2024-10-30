<script setup>
    import UserCard from './UserCard.vue';
    const props = defineProps({
        title : {
            default : 'Ejemplo de título'
        }
    })

    const ruta = localStorage.getItem('escuelas') === 'true' ? '/escuelas' : '/editar'    

</script>

<template>
    <nav class="fixed w-full top-0 h-16 px-10 bg-white z-10 flex items-center">
        <a :href="ruta">
             <h1 class="text-2xl font-bold cursor-pointer">
                {{ props.title }}
            </h1>
        </a>
        <div class="flex-1">
            
        </div>
        <div>
            <UserCard />
        </div>
    </nav>
</template>