<script setup>
import {usePage} from "@inertiajs/vue3";
import {computed} from "vue";

const page = usePage()

const user = computed(() => page.props.auth.user)
</script>

<template>
  <div class="d-flex">
    <div v-if="user != null" class="d-flex align-items-center me-1">
      <img :src="user.avatar" style="width:40px" />
      <div class="ms-3">{{ user.name }}</div>
      <a href="/logout" role="button" class="btn btn-secondary ms-3">Logout</a>
    </div>
    <a href="/login" role="button" class="btn btn-primary" v-else>Login</a>
  </div>
</template>

<style scoped lang="scss">

</style>