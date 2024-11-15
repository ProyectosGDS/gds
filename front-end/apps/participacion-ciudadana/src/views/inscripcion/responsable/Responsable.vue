<script setup>
    import { useInscripcionStore } from '@/stores/inscripcion'

    import DatosResponsable from '@/views/inscripcion/responsable/DatosResponsable.vue'
    import DatosEmergencia from '@/views/inscripcion/responsable/DatosEmergencia.vue'


    const inscripcion = useInscripcionStore()

</script>

<template>
    <div class="grid gap-4 text-violet-400" >
        <DatosResponsable />
        <DatosEmergencia />
        <Button @click="inscripcion.store()" text="Inscribirse" icon="fas fa-user" class="btn-primary rounded-lg" />
    </div>
</template>

