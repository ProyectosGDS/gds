<script setup>
    import { ref } from 'vue';
    import Steps from '@/components/Steps.vue'
    import SelectSearch from '@/components/SelectSearch.vue'
    
    import DatosGenerales from '@/views/inscripciones/DatosGenerales.vue'
    import RepresentanteLegal from '@/views/inscripciones/RepresentanteLegal.vue'
    import ContactoEmergencia from '@/views/inscripciones/ContactoEmergencia.vue'
    

    const steps = ref([
        { 
            index : 1, 
            text : 'Datos generales', 
            name : 'DatosGenerales',
            active : false 
        },
        { 
            index : 2, 
            text : 'Representante legal', 
            name : 'RepresentanteLegal', 
            active : false 
        },
        { 
            index : 3, 
            text : 'Contacto de emergencia', 
            name : 'ContactoEmergencia', 
            active : false 
        },
    ])

    const components = {
        DatosGenerales,
        RepresentanteLegal, 
        ContactoEmergencia, 
    }

</script>

<template>
    <div class="container mx-auto max-w-7xl">
        <Steps :steps="steps" :components="components"/>
    </div>
</template>