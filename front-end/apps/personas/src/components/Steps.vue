<script setup>
import { onMounted, ref } from 'vue'
import DatosPersonales from '../views/DatosPersonales.vue'
import DomicilioResponsable from '../views/DomicilioResponsable.vue'
import Administrativo from '../views/Administrativo.vue'


const steps = ref([
    { 
        index : 1, 
        text : 'Datos personales', 
        name : 'DatosPersonales', 
        active : false 
    },
    { 
        index : 2, 
        text : 'Domicilio responsable', 
        name : 'DomicilioResponsable', 
        active : false 
    },
    { 
        index : 3, 
        text : 'Administrativo', 
        name : 'Administrativo', 
        active : false 
    },
])

const currentComponent = ref('')

const components = {
    DatosPersonales,
    DomicilioResponsable,
    Administrativo
}

const focusStep = (indice) => {
    index.value = indice
    currentComponent.value = steps.value[indice].name
    steps.value.forEach(step => {
        if(step == steps.value[indice]) {
            steps.value.forEach(i => i.index > steps.value[indice].index ? i.active = false : i.active = true)
        }
    })
}

const index = ref(0)

const next = () => {
    if(index.value < steps.value.length - 1){
        index.value ++
        currentComponent.value = steps.value[index.value].name
        steps.value.forEach(step => {
            if(step == steps.value[index.value]) {
                steps.value.forEach(i => i.index > steps.value[index.value].index ? i.active = false : i.active = true)
            }
        })
    }
}

const previus = () => {
    if(index.value >= 1) {
        index.value --
        currentComponent.value = steps.value[index.value].name
        steps.value.forEach(step => {
            if(step == steps.value[index.value]) {
                steps.value.forEach(i => i.index > steps.value[index.value].index ? i.active = false : i.active = true)
            }
        })
    }
}


onMounted(() => {
    currentComponent.value = steps.value[0].name
    steps.value[0].active = true
})

</script>

<template>
<div class="flex justify-center">
    <div @click="focusStep(i)" v-for="(step,i) in steps" class="flex items-center group">
        <span class="h-1 sm:w-20 group-first:hidden" :class="step.active ? 'bg-violet-500' : 'bg-gray-300'"></span>
        <Tool-Tip :message="step.text" class="mt-10 text-gray-400">
            <div class="w-12 h-12 rounded-full text-2xl text-white font-semibold flex items-center justify-center" :class="step.active ? 'bg-violet-500' : 'bg-gray-300'" >
                {{ step.index }}
            </div>        
        </Tool-Tip>
        <span class="h-1 sm:w-16 group-last:hidden" :class="step.active ? 'bg-violet-500' : 'bg-gray-300'"></span>
    </div>
</div>
<br>
<component :is="components[currentComponent]"></component>
<br>
<div class="flex justify-evenly">
    <Button @click="previus" icon="fas fa-arrow-left" class="btn-primary" :disabled="!index > 0" />
    <Button @click="next" icon="fas fa-arrow-right" class="btn-primary" :disabled="!(index < steps.length - 1)" />
</div>
</template>