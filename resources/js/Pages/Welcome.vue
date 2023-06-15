<script setup>
import MainLayout from "@/Layouts/MainLayout.vue";

defineOptions({
  layout: (h, page) => h(MainLayout, {title: "Welcome"}, [page])
});
</script>

<template>
</template>
