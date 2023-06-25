<script setup>
import {Link, usePage} from "@inertiajs/vue3";
import {computed} from "vue";

const props = defineProps({
    entryName: String,
    linkTarget: String
});

const active = computed(() => props.linkTarget === usePage().url)

</script>

<template>
  <li class="nav-item rounded mx-1 px-1" :class="{'bg-primary': active, 'bg-body-tertiary': !active}">
    <Link class="nav-link" :href="props.linkTarget" :class="{ 'active': active }">{{ props.entryName }}</Link>
  </li>
</template>

<style scoped lang="scss">
</style>