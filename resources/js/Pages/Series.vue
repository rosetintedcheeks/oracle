<script setup>
import MainLayout from "@/Layouts/MainLayout.vue";
import LinkList from "@/Components/LinkList.vue";
import {router} from "@inertiajs/vue3";

defineOptions({
  layout: (h, page) => h(MainLayout, {title: "Series"}, [page])
});

const props = defineProps({
  links: null,
  seriesId: null,
  series: null
})
const switchSeries = (id) => {
  router.visit('/series/' + id, {only: ['links', 'seriesId']})
}
</script>

<template>
  <LinkList :links="links" :series="series" :series-id="seriesId" @switch-series="switchSeries"/>
</template>

<style scoped lang="scss">
</style>