<script setup>
import MainLayout from "@/Layouts/MainLayout.vue";
import Tabs from "@/Components/Tabs.vue";
import Tab from "@/Components/Tab.vue";
import TabContent from "@/Components/TabContent.vue";
import {router} from "@inertiajs/vue3";
import {reactive} from "vue";

defineOptions({
  layout: (h, page) => h(MainLayout, {title: "Torrents"}, [page])
});

const props = defineProps({
    linkRoots: null,
    series: null
})

const form = reactive({
  torrentFile: null,
  linkRoot: null,
  series: null,
  seriesName: null
})

const submit = () => {
  router.post('/torrents/upload', form)
}

const seriesNameValid = () => validClass(form.seriesName)
const seriesValid = () => validClass(typeof form.series === 'number' || form.series === 'new');
const linkRootValid = () => validClass(typeof form.linkRoot === 'number')

const validClass = (valid) => valid ? 'is-valid' : 'is-invalid';
</script>

<template>
    <Tabs tab-id="torrents-tab">
      <template #tabs-header>
        <Tab tab-name="upload" active="active">
          Upload
        </Tab>
      </template>
      <template #tabs-content>
        <TabContent tab-name="upload" active="active">
          <div class="mb-3">
            <form method="post" @submit.prevent="submit">
              <div class="row mb-2">
                <div class="col-auto">
                  <label for="formFile" class="form-label">Torrent File</label>
                  <input class="form-control" type="file" id="formFile" @change="form.torrentFile = $event.target.files">
                </div>
              </div>
              <div class="row mb-2">
                <div class="col-auto">
                  <label>Root</label>
                  <select name="link_root" id="link_root_select" v-model="form.linkRoot" class="form-select">
                    <option disabled value="">Please select a root folder</option>
                    <option v-for="root in linkRoots" :value="root.id">
                      {{ root.name }}
                    </option>
                  </select>
                </div>
                <div class="col-auto">
                  <label>Series</label>
                  <select name="series" id="series_select" v-model="form.series" class="form-select">
                    <option disabled value="">Please select a series</option>
                    <option value="new">New Series</option>
                    <template v-for="show in series">
                      <option :value="show.id" v-if="show.link_root_id === form.linkRoot">
                        {{ show.name }}
                      </option>
                    </template>
                  </select>
                </div>
                <div class="col-auto" v-if="form.series === 'new'">
                  <label>Series Name</label>
                  <input type="text" class="form-control" name="new_series_name" v-model="form.seriesName">
                  <div class="invalid-feedback">Please enter the name of the new series</div>
                </div>
              </div>
              <div class="row">
                <div class="col-auto">
                  <button class="btn btn-primary mt-2">Submit</button>
                </div>
              </div>
            </form>
          </div>
        </TabContent>
      </template>
    </Tabs>
</template>

<style scoped lang="scss">
#series_select {
  min-width: 120px;
}
</style>