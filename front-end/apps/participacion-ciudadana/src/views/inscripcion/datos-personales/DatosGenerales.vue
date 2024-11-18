<script setup>
    import { useInscripcionStore } from '@/stores/inscripcion'
    
    const store = useInscripcionStore()

    function checkField(fieldname) {
        const ids_direcciones = store.camposRegistro.filter(item => item.categoria =='datos personales')
        const result = ids_direcciones.find(item => item.campo == fieldname)
        return result.di_direcciones.includes(store.datos.di_direccion_id)
    }

    function verifyCui() {
        const cui = store.cui;

        if(!cui){
            store.errors = { cui: ['Ingrese cui'] }
            store.success = false
            return false 
        }

        if (cui.length !== 13 || !/^[0-9]{4}\s?[0-9]{5}\s?[0-9]{4}$/.test(cui)) {
            store.errors = { cui: ['cui invalido'] }
            store.success = false
            return false
        }

        const cleanCui = cui.replace(/\s/g, '');
        const depto = parseInt(cleanCui.substring(9, 11), 10);
        const muni = parseInt(cleanCui.substring(11, 13), 10);
        const numero = cleanCui.substring(0, 8);
        const verificador = parseInt(cleanCui.substring(8, 9), 10);

        const munisPorDepto = [
            { id: 1, cantidad: 17 }, { id: 2, cantidad: 8 }, { id: 3, cantidad: 16 },
            { id: 4, cantidad: 16 }, { id: 5, cantidad: 13 }, { id: 6, cantidad: 14 },
            { id: 7, cantidad: 19 }, { id: 8, cantidad: 8 }, { id: 9, cantidad: 24 },
            { id: 10, cantidad: 21 }, { id: 11, cantidad: 9 }, { id: 12, cantidad: 30 },
            { id: 13, cantidad: 32 }, { id: 14, cantidad: 21 }, { id: 15, cantidad: 8 },
            { id: 16, cantidad: 17 }, { id: 17, cantidad: 14 }, { id: 18, cantidad: 5 },
            { id: 19, cantidad: 11 }, { id: 20, cantidad: 11 }, { id: 21, cantidad: 7 },
            { id: 22, cantidad: 17 }
        ];

        if (depto === 0 || muni === 0 || depto > munisPorDepto.length || muni > munisPorDepto[depto - 1].cantidad) {
            store.errors = { cui: ['cui invalido'] }
            store.success = false
            return false
        }

        const total = numero.split('').reduce((acc, digit, index) => acc + digit * (index + 2), 0)


        if (total % 11 === verificador) {
            store.fetchBeneficiarioUnico(cleanCui)
            store.success = true
            return true
        }

        store.errors = { cui: ['cui invalido'] }
        store.success = false
        return false
    }

</script>

<template>
    <div>
        <div>
            <span class="uppercase">Busqueda por cui</span>
            <div class="flex items-center justify-between gap-2">
                <input @keyup.enter="verifyCui()" @keyup="verifyCui()" v-model="store.cui" placeholder="Ingrese cui" autofocus type="search" maxlength="13" minlength="13" class="input focus:outline-none" :class="{'focus:border-red-400 border-red-400':store.errors.hasOwnProperty('cui'), 'focus:border-green-500 border-gree-500' : store.success }" required >
                <Button @click="verifyCui()" text="Buscar cui" icon="fas fa-search" class="btn-primary rounded-lg text-nowrap" :loading="store.loading.searchBeneficiario" />
            </div>
        </div>
        <span v-if="store.errors.hasOwnProperty('cui')" class="text-red-400 text-xs uppercase">
            {{ store.errors?.cui[0] }}
        </span>
        <br>
        <details :open="true" class="border p-4 rounded-lg border-violet-400">
            <summary>DATOS GENERALES</summary>
            <br>
            <div class="flex flex-wrap gap-4">
                <div class="grow">
                    <span class="uppercase">cui</span>
                    <input v-model="store.datos.cui" type="text" maxlength="13" minlength="13" class="input focus:outline-none" :class="{'border-red-400':store.errors.hasOwnProperty('cui')}">
                </div>
                <div v-if="checkField('nit')" class="grow">
                    <span class="uppercase">nit</span>
                    <input v-model="store.datos.nit" type="text" maxlength="13" minlength="13" class="input focus:outline-none">
                </div>
                <div v-if="checkField('pasaporte')" class="grow">
                    <span class="uppercase">pasaporte</span>
                    <input v-model="store.datos.pasaporte" type="text" class="input focus:outline-none" >
                </div>
            </div>
    
            <div class="flex flex-wrap gap-4">
                <div v-if="checkField('primer_nombre')" class="grow">
                    <span class="uppercase">primer nombre</span>
                    <input v-model="store.datos.primer_nombre" type="text" class="input focus:outline-none" :class="{'border-red-400':store.errors.hasOwnProperty('primer_nombre')}" >
                </div>
                <div v-if="checkField('segundo_nombre')" class="grow">
                    <span class="uppercase">segundo nombre</span>
                    <input v-model="store.datos.segundo_nombre" type="text" class="input focus:outline-none" >
                </div>
                <div v-if="checkField('tercer_nombre')" class="grow">
                    <span class="uppercase">tercer nombre</span>
                    <input v-model="store.datos.tercer_nombre" type="text" class="input focus:outline-none" >
                </div>
            </div>
    
            <div class="flex flex-wrap gap-4">
                <div v-if="checkField('primer_apellido')" class="grow">
                    <span class="uppercase">primer apellido</span>
                    <input v-model="store.datos.primer_apellido" type="text" class="input focus:outline-none" :class="{'border-red-400':store.errors.hasOwnProperty('primer_apellido')}" >
                </div>
                <div v-if="checkField('segundo_apellido')" class="grow">
                    <span class="uppercase">segundo apellido</span>
                    <input v-model="store.datos.segundo_apellido" type="text" class="input focus:outline-none" >
                </div>
                <div v-if="checkField('apellido_casada')" class="grow">
                    <span class="uppercase">apellido de casada</span>
                    <input v-model="store.datos.apellido_casada" type="text" class="input focus:outline-none" >
                </div>
            </div>
    
            <div class="flex flex-wrap gap-4">
                <div v-if="checkField('sexo')" class="grow">
                    <span class="uppercase">sexo</span>
                    <div class="flex items-center gap-3">
                        <Icon icon="fas fa-person-dress" class="text-fuchsia-500 text-5xl" />
                        <Switch class="w-14 h-7 bg-blue-500 has-[:checked]:bg-fuchsia-500" :values="['F','M']" v-model="store.datos.sexo" :error="store.errors.hasOwnProperty('sexo')" />
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

    </div>
</template>