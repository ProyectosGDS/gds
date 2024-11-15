<script setup>
    import { useInscripcionStore } from '@/stores/inscripcion'

    const store = useInscripcionStore()
    
    async function checkField(fieldname) {
        const direcciones = await store.camposRegistro.find(item => item.campo === fieldname ).di_direcciones
        return direcciones.includes(store.datos.di_direccion_id)
    }

</script>

<template>
    <details :open="true" class="border p-4 rounded-lg border-violet-400">
        <summary>DATOS MEDICOS </summary>
        <br>
        <div class="grid xl:flex gap-4">
            <div v-if="checkField('tipo_sangre_id')" class="grow">
                <span class="uppercase">tipo sangre</span>
                <select v-model="store.datos.tipo_sangre_id" class="input focus:outline-none uppercase" :class="{'border-red-400':store.errors.hasOwnProperty('tipo_sangre_id')}">
                    <option v-for="tipo_sangre in store.catalogos.tipo_sangre" :value="tipo_sangre.id">{{ tipo_sangre.nombre }}</option>
                </select>
            </div>
            <div v-if="checkField('enfermedad_id')" class="grow">
                <span class="uppercase">¿ Padece alguna enfermedad cronica, cual ?</span>
                <select v-model="store.datos.enfermedad_id" class="input focus:outline-none uppercase" :class="{'border-red-400':store.errors.hasOwnProperty('enfermedad_id')}">
                    <option v-for="enfermedad in store.catalogos.enfermedades" :value="enfermedad.id">{{ enfermedad.nombre }}</option>
                </select>
            </div>
            <div v-if="checkField('alergias')" class="grow">
                <span class="uppercase">¿ Alergias a medicamentos o comida ?</span>
                <input v-model="store.datos.alergias" type="text" class="input focus:outline-none" :class="{'border-red-400':store.errors.hasOwnProperty('alergias')}" >
            </div>
        </div>
        <div class="grid xl:flex gap-4">
            <div v-if="checkField('medicamento')" class="grow">
                <span class="uppercase">¿ Toma algun medicamento ?</span>
                <input v-model="store.datos.medicamento" type="text" class="input focus:outline-none" :class="{'border-red-400':store.errors.hasOwnProperty('medicamento')}" >
            </div>
            <div v-if="checkField('dosis')" class="grow">
                <span class="uppercase">¿ Dosis de medicamento ?</span>
                <input v-model="store.datos.dosis" type="text" class="input focus:outline-none" :class="{'border-red-400':store.errors.hasOwnProperty('dosis')}" >
            </div>
        </div>
    </details>
</template>