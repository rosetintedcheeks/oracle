<script setup>

import {computed} from "vue";

const props = defineProps({
  tabName: String,
  active: Boolean
})

const tabContentId = computed(() => props.tabName + '-tab-content');
const labelledBy = computed(() => props.tabName + '-tab');

const showClass = computed(() => props.active ? 'show active' : '');
</script>

<template>
  <div class="tab-pane fade" :class="showClass" :id="tabContentId" role="tabpanel" :aria-labelledby="labelledBy" tabindex="0">
    <slot />
  </div>
</template>

<style scoped lang="scss">

</style>