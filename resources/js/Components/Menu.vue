<script setup>
import {Link, usePage} from '@inertiajs/vue3';
import MenuEntry from "@/Components/MenuEntry.vue";
import Login from "@/Components/Login.vue";

const page = usePage()

</script>

<template>
  <nav class="navbar navbar-expand-md bg-body-primary">
    <div class="container-fluid">
      <Link class="navbar-brand" href="/">ORACLE</Link>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-md-0">
          <MenuEntry link-target="/" entry-name="Home" />
          <MenuEntry link-target="/torrents" entry-name="Torrents" v-if="page.props.auth.user"/>
          <MenuEntry link-target="/series" entry-name="Series" v-if="page.props.auth.user"/>
        </ul>
        <Login/>
      </div>
    </div>
  </nav>
</template>

<style scoped lang="scss">

</style>