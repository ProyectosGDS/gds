<script setup>
    import { useInscripcionStore } from '@/stores/inscripcion'
    import { useCursosStore } from '@/stores/cursos'
    import { computed, onBeforeMount, watchEffect } from 'vue'

    const store = useInscripcionStore()
    const cursoStore = useCursosStore()

    watchEffect(() => {
        store.changePais()
        store.changeDepartamento()
    })

    function checkField(fieldname) {
        const direcciones = store.camposRegistro.find(item => item.campo === fieldname ).di_direcciones
       return direcciones.includes(store.datos.di_direccion_id)
    }


    onBeforeMount(() => {

        store.datos.di_direccion_id = cursoStore.curso.programa.di_direccion_id
        
        const storedCatalogos = localStorage.getItem('catalogos')
        const storedCamposRegistro = localStorage.getItem('campos-registro')
        
        if (storedCatalogos) {
            store.catalogos = JSON.parse(storedCatalogos)
        }
        
        if (storedCamposRegistro) {
            store.camposRegistro = JSON.parse(storedCamposRegistro)
        }
        
    })


</script>

<template>
    <div class="grid gap-4 text-violet-400" >
        <details :open="true" class="border p-4 rounded-lg border-violet-400">
            <summary>DATOS GENERALES</summary>
            <br>
            <div class="flex flex-wrap gap-4">
                <div v-if="checkField('cui')" class="grow">
                    <span class="uppercase">cui/dpi</span>
                    <input v-model="store.datos.cui" type="text" maxlength="13" minlength="13" class="input focus:outline-none" :class="{'border-red-400':store.errors.hasOwnProperty('cui')}" required >
                </div>
                <div v-if="checkField('nit')" class="grow">
                    <span class="uppercase">nit</span>
                    <input v-model="store.datos.nit" type="text" maxlength="13" minlength="13" class="input focus:outline-none" :class="{'border-red-400':store.errors.hasOwnProperty('nit')}" >
                </div>
                <div v-if="checkField('pasaporte')" class="grow">
                    <span class="uppercase">pasaporte</span>
                    <input v-model="store.datos.pasaporte" type="text" class="input focus:outline-none" :class="{'border-red-400':store.errors.hasOwnProperty('pasaporte')}" >
                </div>
            </div>
    
            <div class="flex flex-wrap gap-4">
                <div v-if="checkField('primer_nombre')" class="grow">
                    <span class="uppercase">primer nombre</span>
                    <input v-model="store.datos.primer_nombre" type="text" class="input focus:outline-none" :class="{'border-red-400':store.errors.hasOwnProperty('primer_nombre')}" >
                </div>
                <div v-if="checkField('segundo_nombre')" class="grow">
                    <span class="uppercase">segundo nombre</span>
                    <input v-model="store.datos.segundo_nombre" type="text" class="input focus:outline-none" :class="{'border-red-400':store.errors.hasOwnProperty('segundo_nombre')}" >
                </div>
                <div v-if="checkField('tercer_nombre')" class="grow">
                    <span class="uppercase">tercer nombre</span>
                    <input v-model="store.datos.tercer_nombre" type="text" class="input focus:outline-none" :class="{'border-red-400':store.errors.hasOwnProperty('tercer_nombre')}" >
                </div>
            </div>
    
            <div class="flex flex-wrap gap-4">
                <div v-if="checkField('primer_apellido')" class="grow">
                    <span class="uppercase">primer apellido</span>
                    <input v-model="store.datos.primer_apellido" type="text" class="input focus:outline-none" :class="{'border-red-400':store.errors.hasOwnProperty('primer_apellido')}" >
                </div>
                <div v-if="checkField('segundo_apellido')" class="grow">
                    <span class="uppercase">segundo apellido</span>
                    <input v-model="store.datos.segundo_apellido" type="text" class="input focus:outline-none" :class="{'border-red-400':store.errors.hasOwnProperty('pasaporte')}" >
                </div>
                <div v-if="checkField('apellido_casada')" class="grow">
                    <span class="uppercase">apellido de casada</span>
                    <input v-model="store.datos.apellido_casada" type="text" class="input focus:outline-none" :class="{'border-red-400':store.errors.hasOwnProperty('pasaporte')}" >
                </div>
            </div>
    
            <div class="flex flex-wrap gap-4">
                <div v-if="checkField('sexo')" class="grow">
                    <span class="uppercase">sexo</span>
                    <div class="flex items-center gap-3">
                        <Icon icon="fas fa-person-dress" class="text-fuchsia-500 text-5xl" />
                        <Switch class="w-14 h-7 bg-blue-500 has-[:checked]:bg-fuchsia-500" :values="['m','h']" v-model="store.datos.sexo" :error="store.errors.hasOwnProperty('sexo')" />
                        <Icon icon="fas fa-person" class="text-blue-500 text-5xl" />
                    </div>
                </div>
                <div v-if="checkField('fecha_nacimiento')" class="grow">
                    <span class="uppercase">fecha nacimiento</span>
                    <input v-model="store.datos.fecha_nacimiento" type="date" class="input focus:outline-none" :class="{'border-red-400':store.errors.hasOwnProperty('fecha_nacimiento')}" >
                </div>
                <div v-if="checkField('etnia_id')" class="grow">
                    <span class="uppercase">etnia</span>
                    <select v-model="store.datos.etnia_id" class="input focus:outline-none uppercase" :class="{'border-red-400':store.errors.hasOwnProperty('etnia_id')}">
                        <option v-for="etnia in store.catalogos.etnias" :value="etnia.id">{{ etnia.nombre }}</option>
                    </select>
                </div>
                <div v-if="checkField('lugar_nacimiento')" class="grow">
                    <span class="uppercase">lugar de nacimiento</span>
                    <input v-model="store.datos.lugar_nacimiento" type="text" class="input focus:outline-none" :class="{'border-red-400':store.errors.hasOwnProperty('lugar_nacimiento')}" >
                </div>
            </div>
        </details>

        <details class="border p-4 rounded-lg border-violet-400">
            <summary>DIRECCIÓN</summary>
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
    </div>
    {{ store.datos }}
</template>