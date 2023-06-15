<script setup>
import MainLayout from "@/Layouts/MainLayout.vue";

defineOptions({
  layout: (h, page) => h(MainLayout, {title: "Home"}, [page])
});
</script>

<template>
</template>
