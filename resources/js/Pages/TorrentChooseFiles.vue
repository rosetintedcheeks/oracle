<script setup>
import MainLayout from "@/Layouts/MainLayout.vue";
import FileChooser from "@/Components/FileChooser.vue";

defineOptions({
  layout: (h, page) => h(MainLayout, {title: "Torrents"}, [page])
});
const props = defineProps({
  links: null
})

</script>

<template>
  <FileChooser :links="links" />
</template>

<style scoped lang="scss">

</style>