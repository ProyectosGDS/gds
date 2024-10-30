<script setup>
    import Calendar from '@/components/Calendar.vue'

    const events = [
        {
            title : 'Evento 1', 
            description : 'Esta es la descripcion del evento 1',
            date : {
                start : '2024-10-01',
                end : '2024-10-01'
            },
            time : {
                start : '09:30',
                end : '10:30'
            }
        },
        {
            title : 'Evento 2', 
            description : 'Esta es la descripcion del evento 1',
            date : {
                start : '2024-10-01',
                end : '2024-10-01'
            },
            time : {
                start : '09:30',
                end : '10:30'
            }
        },
        {
            title : 'Evento 3', 
            description : 'Esta es la descripcion del evento 1',
            date : {
                start : '2024-10-01',
                end : '2024-10-01'
            },
            time : {
                start : '09:30',
                end : '10:30'
            }
        },
        {
            title : 'Evento 4', 
            description : 'Esta es la descripcion del evento 1',
            date : {
                start : '2024-10-01',
                end : '2024-10-01'
            },
            time : {
                start : '09:30',
                end : '10:30'
            }
        },
        {
            title : 'Evento 2', 
            description : 'Esta es la descripcion del evento 1',
            date : {
                start : '2024-10-16',
                end : '2024-10-16'
            },
            time : {
                start : '09:30',
                end : '10:30'
            }
        },
        {
            title : 'Evento 3', 
            description : 'Esta es la descripcion del evento 1',
            date : {
                start : '2024-10-16',
                end : '2024-10-16'
            },
            time : {
                start : '09:30',
                end : '10:30'
            }
        },
        {
            title : 'Evento 4', 
            description : 'Esta es la descripcion del evento 1',
            date : {
                start : '2024-10-16',
                end : '2024-10-16'
            },
            time : {
                start : '09:30',
                end : '10:30'
            }
        },
]
</script>

<template>
    <h1 class="text-2xl text-gray-500 font-semibold">Eventos</h1>
    <br>
    <Calendar :events="events" />
</template>