<script setup>
    import { useDatosPersonalesStore } from '../stores/datos-personales'
    import { useCatalogosStore } from '../stores/catalogos'
    import { onBeforeMount, ref, watchEffect } from 'vue'
    import axios from 'axios';

    const campos = ref([])

    const store = useDatosPersonalesStore()
    const catalogos = useCatalogosStore()

    function fetchCamposRegistro () {
        axios.get('campos-registro')
        .then(response => campos.value = response.data)
        .catch(error => console.error(error.response.data))
    }

    watchEffect(() => {
        store.changePais()
        store.changeDepartamento()
    })

    onBeforeMount(() => {
        fetchCamposRegistro()
        catalogos.fetchEnfermedades()
        catalogos.fetchEscolaridades()
        catalogos.fetchEtnias()
        catalogos.fetchGruposHabitacionales()
        catalogos.fetchPaises()
        catalogos.fetchParentescos()
        catalogos.fetchTipoSangre()
        catalogos.fetchZonas()
    })
</script>

<template>

    <Card class="bg-white p-8">
        <template #header>
            <h1 class="text-xl text-violet-400">Datos generales</h1>
        </template>
        <br>
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-5">

            <Input @keydown="store.verifyCui" option="label" title="cui / dpi" v-model="store.data.cui" :error="store.errors.hasOwnProperty('cui')" maxlength="13" minlength="13" autocomplete="off" />
            <Input option="label" title="nit" v-model="store.data.nit" :error="store.errors.hasOwnProperty('nit')" maxlength="13" minlength="13" autocomplete="off" />
            <Input option="label" title="pasaporte" v-model="store.data.pasaporte" :error="store.errors.hasOwnProperty('pasaporte')"autocomplete="off" />
            
            <Input option="label" title="primer nombre" v-model="store.data.primer_nombre" :error="store.errors.hasOwnProperty('primer_nombre')"autocomplete="off" />
            <Input option="label" title="segundo nombre" v-model="store.data.segundo_nombre" :error="store.errors.hasOwnProperty('segundo_nombre')"autocomplete="off" />
            <Input option="label" title="tercer nombre" v-model="store.data.tercer_nombre" :error="store.errors.hasOwnProperty('tercer_nombre')"autocomplete="off" />
            
            <Input option="label" title="primer apellido" v-model="store.data.primer_apellido" :error="store.errors.hasOwnProperty('primer_apellido')"autocomplete="off" />
            <Input option="label" title="segundo apellido" v-model="store.data.segundo_apellido" :error="store.errors.hasOwnProperty('segundo_apellido')"autocomplete="off" />
            <Input option="label" title="apellido casada" v-model="store.data.apellido_casada" :error="store.errors.hasOwnProperty('apellido_casada')"autocomplete="off" />
        
        </div>
        <div class="grid md:grid-cols-2 gap-5">
            <div class="flex gap-3 items-center justify-center">
                Mujer
                <Switch class="w-14 h-7 bg-blue-500 has-[:checked]:bg-fuchsia-500" :values="['m','h']" v-model="store.data.sexo" :error="store.errors.hasOwnProperty('sexo')" />
                Hombre
            </div>
            <Input option="label" title="Lugar de nacimiento" v-model="store.data.lugar_nacimiento" :error="store.errors.hasOwnProperty('lugar_nacimiento')"autocomplete="off" />
            <Input option="label" title="fecha de nacimiento" type="date" v-model="store.data.fecha_nacimiento" :error="store.errors.hasOwnProperty('fecha_nacimiento')"autocomplete="off" />
            <Select placeholder="GRUPO ÉTNICO" :fields="['id','nombre']" :items="catalogos.etnias" v-model="store.data.grupo_etnico_id" :error="store.errors.hasOwnProperty('grupo_etnico_id')" />
        </div>
    </Card>
    <br>
    <Card class="bg-white p-8">
        <template #header>
            <h1 class="text-xl text-violet-400">Direccion y contacto</h1>
        </template>
        <br>
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-5">
            <Select v-model="store.data.pais_id" placeholder="PAIS" :items="catalogos.paises" :fields="['id','nombre']" :error="store.errors.hasOwnProperty('pais_id')"/>
            <Select v-model="store.data.departamento_id" placeholder="DEPARTAMENTO" :items="catalogos.departamentos" :fields="['id','nombre']" :error="store.errors.hasOwnProperty('departamento_id')"/>
            <Select v-model="store.data.municipio_id" placeholder="MUNICIPIO" :items="catalogos.municipios" :fields="['id','nombre']" :error="store.errors.hasOwnProperty('municipio_id')"/>
            <Select v-model="store.data.zona_id" placeholder="SELECCIONE ZONA" :items="catalogos.zonas" :fields="['id','numero']" format="'Zona ' + item.numero" :sort="false"  :error="store.errors.hasOwnProperty('zona_id')" />
            <Select v-model="store.data.grupo_habitacional_id" placeholder="GRUPO HABITACIONAL" :items="catalogos.gruposHabitacionales" :fields="['id','nombre']" :error="store.errors.hasOwnProperty('grupo_habitacional_id')"/>
            <Input option="label" title="nombre grupo habitacional" v-model="store.data.nombre_grupo_habitacional" :error="store.errors.hasOwnProperty('nombre_grupo_habitacional')" autocomplete="off" />
            <Input option="label" title="dirección" v-model="store.data.direccion" :error="store.errors.hasOwnProperty('direccion')"autocomplete="off" />
            <Input option="label" title="Correo electronico" type="email" v-model="store.data.correo" :error="store.errors.hasOwnProperty('correo')"autocomplete="off" />
            <Input option="label" title="Telefono" type="number" v-model="store.data.telefono" :error="store.errors.hasOwnProperty('telefono')"autocomplete="off" />
            <Input option="label" title="Celular" type="number" v-model="store.data.celular" :error="store.errors.hasOwnProperty('celular')"autocomplete="off" />
        </div>
        <Button @click="store.store()" text="Guardar" icon="fas fa-save" class="btn-primary rounded-full" />
    </Card>
    <br>
    <Card class="bg-white p-8">
        <template #header>
            <h1 class="text-xl text-violet-400">Datos academicos</h1>
        </template>
        <br>
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-5">
            <Input option="label" title="Establecimiento educativo" v-model="store.data.establecimiento_educativo" :error="store.errors.hasOwnProperty('establecimiento_educativo')" autocomplete="off" />
            <Select v-model="store.data.escolaridad_id" placeholder="ESCOLARIDAD" :items="catalogos.escolaridades" :fields="['id','nombre']" :error="store.errors.hasOwnProperty('escolaridad_id')"/>
            <Input option="label" title="Grado" v-model="store.data.grado" :error="store.errors.hasOwnProperty('grado')" autocomplete="off" />
            <Input option="label" title="titulo" v-model="store.data.titulo" :error="store.errors.hasOwnProperty('titulo')" autocomplete="off" />
        </div>
    </Card>
    <br>
    <Card class="bg-white p-8">
        <template #header>
            <h1 class="text-xl text-violet-400">Datos medicos</h1>
        </template>
        <br>
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-5">
            <Select v-model="store.data.tipo_sangre_id" placeholder="TIPO DE SANGRE" :items="catalogos.tipoSangre" :fields="['id','nombre']" :error="store.errors.hasOwnProperty('tipo_sangre_id')"/>
            <Select v-model="store.data.enfermedad_id" placeholder="ENFERMEDADES CRONICAS" :items="catalogos.enfermedades" :fields="['id','nombre']" :error="store.errors.hasOwnProperty('enfermedad_id')"/>
            <Input option="label" title="Alergias a medicamentos o comida" v-model="store.data.alergias" :error="store.errors.hasOwnProperty('alergias')"autocomplete="off" />
            <Input option="label" title="Toma algun medicamento ?" v-model="store.data.medicamento" :error="store.errors.hasOwnProperty('medicamento')"autocomplete="off" />
            <Input option="label" title="dosis medicamento" v-model="store.data.dosis_medicamento" :error="store.errors.hasOwnProperty('dosis_medicamento')"autocomplete="off" />
        </div>
    </Card>
</template>