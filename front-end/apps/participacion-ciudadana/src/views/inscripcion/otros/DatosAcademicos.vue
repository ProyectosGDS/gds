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
        <summary>ULTIMOS DATOS ACADEMICOS </summary>
        <br>

        <div class="grid xl:flex gap-4">
            <div v-if="checkField('establecimiento_educativo')" class="grow">
                <span class="uppercase">establecimiento educativo</span>
                <input v-model="store.datos.establecimiento_educativo" type="text" class="input focus:outline-none" :class="{'border-red-400':store.errors.hasOwnProperty('establecimiento_educativo')}" >
            </div>
            <div v-if="checkField('escolaridad_id')" class="grow">
                <span class="uppercase">escolaridad</span>
                <select v-model="store.datos.escolaridad_id" class="input focus:outline-none uppercase" :class="{'border-red-400':store.errors.hasOwnProperty('escolaridad_id')}">
                    <option v-for="escolaridad in store.catalogos.escolaridades" :value="escolaridad.id">{{ escolaridad.nombre }}</option>
                </select>
            </div>
            <div v-if="checkField('grado')" class="grow">
                <span class="uppercase">grado</span>
                <input v-model="store.datos.grado" type="text" class="input focus:outline-none" :class="{'border-red-400':store.errors.hasOwnProperty('grado')}" >
            </div>
        </div>
        <div class="grid xl:flex gap-4 items-center">
            <div v-if="checkField('titulo')" class="grow">
                <span class="uppercase">titulo</span>
                <input v-model="store.datos.titulo" type="text" class="input focus:outline-none" :class="{'border-red-400':store.errors.hasOwnProperty('titulo')}" >
            </div>
            <div v-if="checkField('tipo_establecimiento')" class="grow">
                <span class="uppercase">tipo de establecimiento</span>
                <div class="flex items-center gap-3" :class="{'text-red-400' : store.errors.hasOwnProperty('tipo_establecimiento')}">
                    <span>PUBLICO</span>
                    <Switch class="w-14 h-7 bg-blue-500" :values="['PUBLICO','PRIVADO']" v-model="store.datos.tipo_establecimiento" :error="store.errors.hasOwnProperty('tipo_establecimiento')" />
                    <span>PRIVADO</span>
                </div>
            </div> 
        </div>
    </details>
</template>ñ