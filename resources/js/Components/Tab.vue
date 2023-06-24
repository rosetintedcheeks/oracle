<script setup>

import {computed} from "vue";

const props = defineProps({
    tabName: String,
    active: Boolean
})

const activeClass = computed(() => props.active ? "active" : "")
const selected = computed(() => props.active ? "true" : "false")
const tabId = computed(() => props.tabName + '-tab')
const targetPaneSelector = computed(() => "#" + props.tabName + '-tab-content')
const ariaControls = computed(() => props.tabName + '-tab-content')
</script>

<template>
  <li class="nav-item" role="presentation">
    <button class="nav-link" :class="activeClass" :id="tabId" data-bs-toggle="tab" :data-bs-target="targetPaneSelector" type="button" role="tab" :aria-controls="ariaControls" :aria-selected="selected">
      <slot />
    </button>
  </li>
</template>

<style scoped lang="scss">

</style>