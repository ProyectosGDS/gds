<script setup>
    import { onMounted, ref } from 'vue'
    
    const props = defineProps(['images'])

    const track = ref(null)
    let currentIndex = ref(0);

    function moveCarousel(index) {
      const position = -index * 100 + '%';
      track.value.style.transform = 'translateX(' + position + ')';
    }

    function nextSlide() {
      currentIndex.value = (currentIndex.value + 1) % props.images.length;
      moveCarousel(currentIndex.value);
    }

    function prevSlide() {
      currentIndex.value = (currentIndex.value - 1 + props.images.length) % props.images.length;
      moveCarousel(currentIndex.value);
    }

    onMounted(()=>{
      setInterval(() => {
        nextSlide()
      }, 3000);
    })

</script>

<template>
    <div class="overflow-hidden max-w-full relative ">
        <div ref="track" class="flex transition-transform ease-in-out duration-300">
          <div v-for="(src, index) in props.images" class="flex-none" :style="{ flex: '0 0 100%' }">
            <img :src="src" alt="Carousel Item" :key="index" class="object-cover h-56 lg:h-36 w-full object-center cursor-pointer"/>
        </div>
        </div>

        <button @click="prevSlide"  class="absolute font-black text-white text-2xl top-1/2 left-4 transform -translate-y-1/2">
            <icon icon="fas fa-angle-left" />
        </button>
        <button @click="nextSlide" class="absolute font-black text-white text-2xl top-1/2 right-4 transform -translate-y-1/2">
            <icon icon="fas fa-angle-right" />
        </button>
      </div>
</template> 