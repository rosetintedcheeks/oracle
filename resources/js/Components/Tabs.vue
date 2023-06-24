<script setup>

const props = defineProps({
    tabHeaderId: String,
    tabContentId: String
})
</script>

<template>
  <article>
    <ul class="nav nav-tabs" :id="tabHeaderId">
      <slot name="tabs-header" />
    </ul>
    <div class="tab-content py-2" :id="tabContentId">
      <slot name="tabs-content" />
    </div>
  </article>
</template>

<style scoped lang="scss">

</style>