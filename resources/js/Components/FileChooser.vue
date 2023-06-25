<script setup>

import {router} from "@inertiajs/vue3";

const props = defineProps({
  links: null
})

const emit = defineEmits([
    'submitChoices'
])

const submitChoices = (event) => {
  let choices = event.target.querySelectorAll('input[name^=choices]');
  choices = Array.from(choices, (el) => {
      if(el.checked) {
        return el.name.replace('choices', '')
      } else {
        return false
      }
  });
  choices = choices.filter(el => el);
  router.post('/torrents/choose', {
    choices: choices
  });
}

</script>

<template>
  <form @submit.prevent="submitChoices">
    <button type="submit" class="btn btn-primary mb-3">Save Choices</button>
    <div class="form-check form-switch py-3 bg-body-secondary" v-for="file in links">
      <input class="form-check-input" type="checkbox" :name="'choices' + file.id" :id="'choices' + file.id" value="1" checked/>
      <label class="form-check-label" :for="'choices' + file.id">
        {{ file.path }}
      </label>
    </div>
  </form>
</template>

<style scoped lang="scss">

</style>