<script setup>
import {Link} from "@inertiajs/vue3";

const props = defineProps({
    entryName: String,
    linkTarget: String
});
</script>

<template>
  <li class="nav-item bg-body-secondary">
    <Link class="nav-link" :href="props.linkTarget" :class="{ 'active': props.linkTarget === $page.url }">{{ props.entryName }}</Link>
  </li>
</template>

<style scoped lang="scss">

</style>