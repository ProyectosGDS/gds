<script setup>
    import { useInscripcionStore } from '@/stores/inscripcion'


    const store = useInscripcionStore()

    function checkField(fieldname) {
        const ids_direcciones = store.camposRegistro.filter(item => item.categoria =='contacto emergencia')
        const result = ids_direcciones.find(item => item.campo == fieldname)
        return result.di_direcciones.includes(store.datos.di_direccion_id)
    }

    
</script>

<template>
    <details :open="true" class="border p-4 rounded-lg border-violet-400">
        <summary>DATOS EMERGENCIA</summary>
        <br>
        <div class="flex flex-wrap gap-4">
            <div  v-if="checkField('cui')" class="grow">
                <span class="uppercase">cui</span>
                <input v-model="store.datos.emergencia.cui" type="text" maxlength="13" minlength="13" class="input focus:outline-none" :class="{'border-red-400':store.errors.hasOwnProperty('emergencia.cui')}">
            </div>
            <div v-if="checkField('nombre')" class="grow">
                <span class="uppercase">nombre</span>
                <input v-model="store.datos.emergencia.nombre" type="text" class="input focus:outline-none" :class="{'border-red-400':store.errors.hasOwnProperty('emergencia.nombre')}" >
            </div>
            <div v-if="checkField('sexo')" class="grow">
                <span class="uppercase">sexo</span>
                <div class="flex items-center gap-3">
                    <Icon icon="fas fa-person-dress" class="text-fuchsia-500 text-5xl" />
                    <Switch class="w-14 h-7 bg-blue-500 has-[:checked]:bg-fuchsia-500" :values="['F','M']" v-model="store.datos.emergencia.sexo" :error="store.errors.hasOwnProperty('emergencia.sexo')" />
                    <Icon icon="fas fa-person" class="text-blue-500 text-5xl" />
                </div>
            </div>
        </div>

        <div class="flex flex-wrap gap-4">
            <div v-if="checkField('zona_id')" class="grow">
                <span class="uppercase">zona</span>
                <select v-model="store.datos.emergencia.zona_id" class="input focus:outline-none uppercase" :class="{'border-red-400':store.errors.hasOwnProperty('emergencia.zona_id')}">
                    <option v-for="zona in store.catalogos.zonas" :value="zona.id">{{ zona.numero }}</option>
                </select>
            </div>
            <div v-if="checkField('direccion_domiciliar')" class="grow">
                <span class="uppercase">dirección domiciliar</span>
                <input v-model="store.datos.emergencia.direccion_domiciliar" type="text" class="input focus:outline-none" :class="{'border-red-400':store.errors.hasOwnProperty('emergencia.direccion_domiciliar')}" >
            </div>
        </div>

        <div class="flex flex-wrap gap-4">
            <div v-if="checkField('celular')" class="grow">
                <span class="uppercase">celular</span>
                <input v-model="store.datos.emergencia.celular" type="number" class="input focus:outline-none" :class="{'border-red-400':store.errors.hasOwnProperty('emergencia.celular')}" >
            </div>
            <div v-if="checkField('correo')" class="grow">
                <span class="uppercase">correo</span>
                <input v-model="store.datos.emergencia.correo" type="email" class="input focus:outline-none" :class="{'border-red-400':store.errors.hasOwnProperty('emergencia.correo')}" >
            </div>
            <div v-if="checkField('parentesco_id')" class="grow">
                <span class="uppercase">Parentesco</span>
                <select v-model="store.datos.emergencia.parentesco_id" class="input focus:outline-none uppercase" :class="{'border-red-400':store.errors.hasOwnProperty('emergencia.parentesco_id')}">
                    <option v-for="parentesco in store.catalogos.parentescos" :value="parentesco.id">{{ parentesco.nombre }}</option>
                </select>
            </div>
        </div>
    </details>
</template>