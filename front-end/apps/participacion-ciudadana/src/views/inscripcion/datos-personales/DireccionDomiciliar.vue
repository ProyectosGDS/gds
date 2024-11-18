<script setup>
    import { useInscripcionStore } from '@/stores/inscripcion'
    import { watchEffect } from 'vue'

    const store = useInscripcionStore()
    
    watchEffect(() => {
        store.changePais()
        store.changeDepartamento()
    })

    async function checkField(fieldname) {
        const ids_direcciones = store.camposRegistro.filter(item => item.categoria =='direccion domiciliar')
        const result = ids_direcciones.find(item => item.campo == fieldname)
        return result.di_direcciones.includes(store.datos.di_direccion_id)
    }


    
</script>

<template>
    <details :open="true" class="border p-4 rounded-lg border-violet-400">
        <summary>DIRECCIÓN DOMICILIAR </summary>
        <br>
        <div class="flex flex-wrap gap-4">
            <div v-if="checkField('pais_id')" class="grow">
                <span class="uppercase">pais</span>
                <select v-model="store.datos.pais_id" class="input focus:outline-none uppercase" :class="{'border-red-400':store.errors.hasOwnProperty('pais_id')}">
                    <option v-for="pais in store.catalogos.paises" :value="pais.id">{{ pais.nombre }}</option>
                </select>
            </div>
            <div v-if="checkField('departamento_id')" class="grow">
                <span class="uppercase">departamento</span>
                <select v-model="store.datos.departamento_id" class="input focus:outline-none uppercase" :class="{'border-red-400':store.errors.hasOwnProperty('departamento_id')}">
                    <option v-for="departamento in store.catalogos.departamentos" :value="departamento.id">{{ departamento.nombre }}</option>
                </select>
            </div>
            <div v-if="checkField('municipio_id')" class="grow">
                <span class="uppercase">municipio</span>
                <select v-model="store.datos.municipio_id" class="input focus:outline-none uppercase" :class="{'border-red-400':store.errors.hasOwnProperty('municipio_id')}">
                    <option v-for="municipio in store.catalogos.municipios" :value="municipio.id">{{ municipio.nombre }}</option>
                </select>
            </div>
        </div>
        
        <div class="grid xl:flex gap-4">
            <div v-if="checkField('zona_id')" class="grow">
                <span class="uppercase">zona</span>
                <select v-model="store.datos.zona_id" class="input focus:outline-none uppercase" :class="{'border-red-400':store.errors.hasOwnProperty('zona_id')}">
                    <option v-for="zona in store.catalogos.zonas" :value="zona.id">{{ zona.numero }}</option>
                </select>
            </div>
            <div v-if="checkField('grupo_habitacional_id')" class="grow">
                <span class="uppercase">grupo habitacional</span>
                <select v-model="store.datos.grupo_habitacional_id" class="input focus:outline-none uppercase" :class="{'border-red-400':store.errors.hasOwnProperty('grupo_habitacional_id')}">
                    <option v-for="grupoHabitacional in store.catalogos.gruposHabitacionales" :value="grupoHabitacional.id">{{ grupoHabitacional.nombre }}</option>
                </select>
            </div>
            <div v-if="checkField('nombre_grupo_habitacional')" class="grow">
                <span class="uppercase">nombre grupo habitacional</span>
                <input v-model="store.datos.nombre_grupo_habitacional" type="text" class="input focus:outline-none" :class="{'border-red-400':store.errors.hasOwnProperty('nombre_grupo_habitacional')}" >
            </div>
        </div>

        <div class="flex flex-wrap gap-4">
            <div v-if="checkField('calle')" class="grow">
                <span class="uppercase">calle</span>
                <input v-model="store.datos.calle" type="text" class="input focus:outline-none" :class="{'border-red-400':store.errors.hasOwnProperty('calle')}" >
            </div>
            <div v-if="checkField('avenida')" class="grow">
                <span class="uppercase">avenida</span>
                <input v-model="store.datos.avenida" type="text" class="input focus:outline-none" :class="{'border-red-400':store.errors.hasOwnProperty('avenida')}" >
            </div>
            <div v-if="checkField('domicilio')" class="grow">
                <span class="uppercase">domicilio</span>
                <input v-model="store.datos.domicilio" type="text" class="input focus:outline-none" :class="{'border-red-400':store.errors.hasOwnProperty('domicilio')}" >
            </div>
        </div>
    </details>
</template>