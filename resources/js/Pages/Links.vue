<script setup>
import MainLayout from "@/Layouts/MainLayout.vue";
import LinkList from "@/Components/LinkList.vue";

defineOptions({
  layout: (h, page) => h(MainLayout, {title: "Links"}, [page])
});

const props = defineProps({
  links: null
})
</script>

<template>
  <LinkList :links="links" />
</template>

<style scoped lang="scss">
</style>