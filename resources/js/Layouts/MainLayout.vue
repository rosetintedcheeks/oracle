<script setup>

import Menu from "@/Components/Menu.vue";
import {Head} from "@inertiajs/vue3";

const props = defineProps({
  title: String
})
</script>

<template>
  <Head :title="props.title"/>
  <main>
    <header>
      <Menu/>
    </header>
    <slot />
  </main>
</template>

<style scoped lang="scss">

</style>