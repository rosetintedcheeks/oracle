<script setup>
import {computed, ref} from "vue";
import {router} from "@inertiajs/vue3";

const props = defineProps({
  links: null,
  series: null,
  seriesId: null,
})

defineEmits(['switchSeries'])

const linkFileNameUpdate = ref({}); // stores link file name that were changed and need to be uploaded
const linkDeleted = ref({}); // stores link ids that are to be deleted



const linkUndoButtons = ref([]); // references to the reset buttons
const linkDeleteButtons = ref([]); // references to the reset buttons
const linkFileNames = ref([]); // references to the elements that hold the link file name

const updateLinks = () => {
  const linkId = event.target.dataset.linkId;
  if(typeof linkFileNameUpdate.value[linkId] == 'undefined') {
    toggleShowButton(linkId, true);
  }

}

const toggleShowButton = (linkId, onOff) => {
  const button = linkUndoButtons.value.find(el => el.dataset.linkId === linkId.toString())
  if(onOff) {
    button.classList.remove('d-none');
  } else {
    button.classList.add('d-none');
  }
}

const resetButton = (id) => {
  toggleShowButton(id, false);
  const linkPath = linkFileNames.value.find(el => el.dataset.linkId === id.toString())
  linkPath.innerText = props.links.find(link => link.id).path;
  delete linkFileNameUpdate.value[id];
}

const linksPerPage = ref(10);
const linkPage = ref(1); // current page

const pagedLinks = computed(() => {
  let links = props.links;
  links = links.slice(linksPerPage.value * (linkPage.value - 1), linksPerPage.value * linkPage.value)
  return links;
})

const deleteLink = (id) => {
  linkDeleted.value[id] = true;
}

const undoDeleteLink = (id) => {
  delete linkDeleted.value[id];
}

const searchText = ref('')
const replaceText = ref('')

const saveChanges = () => {
  for(const el of linkFileNames.value) {
    const link = props.links.find(link => link.id == el.dataset.linkId)
    if(typeof link == 'undefined') {
      continue;
    }
    if(link.file_name !== el.innerText) {
      linkFileNameUpdate.value[link.id] = el.innerText;
    }
  }
  router.post('/links', {
    'linkFileNames': linkFileNameUpdate.value,
    'deletedLinks': linkDeleted.value,
    'seriesId': props.seriesId
  });
  linkFileNameUpdate.value = {};
  linkDeleted.value = {};
  pagedLinks.value.forEach((link) => {
    toggleShowButton(link.id, false)
  });
}
</script>

<template>
  <div class="row mb-2 position-relative">
    <div class="col-sm-6">
      <div class="row">
        <div class="col-auto">
          <button class="btn btn-primary" @click="saveChanges">Save Changes</button>
        </div>
        <div class="col d-flex">
          <input type="text" class="form-control" style="max-width: 100px" id="linkPerPage" :value="linksPerPage" @input="linksPerPage = $event.target.value >= 10 ? $event.target.value : 10" />
          <label for="linkPerPage" class="mt-2 ms-2">per page</label>
        </div>
        <div class="col d-flex">
          <label for="series_select" class="mt-2 ms-2">Series</label>
          <select name="series" id="series_select" :value="seriesId" @input="$emit('switchSeries', $event.target.value)" class="form-select">
            <option disabled value="">Please select a series</option>
            <template v-for="show in series">
              <option :value="show.id">
                {{ show.name }}
              </option>
            </template>
          </select>
        </div>
      </div>
    </div>
    <div class="col-sm-6 d-flex gap-2">
      <input type="text" id="regex-search" class="form-control" placeholder="Search" v-model="searchText"/>
      <input type="text" id="regex-replace" class="form-control" placeholder="Replace" v-model="replaceText"/>
      <button class="btn btn-primary disabled" @click="searchReplaceLinkPaths"><i class="bi-arrow-left-right" /></button>
      <i class="bi-info-circle pt-2" style="z-index:999" data-bs-toggle="tooltip" data-bs-title="Search and replace paths using a string or regex"/>
    </div>
  </div>
  <ul class="list-group">
    <template v-for="link in pagedLinks" :key="link.id">
      <li class="list-group-item" >
        <div class="row">
          <div class="col">
            {{ link.path }}
          </div>
          <div class="col" spellcheck="false" contenteditable="true" ref="linkFileNames" @input="updateLinks" :data-link-id="link.id" v-if="typeof linkDeleted[link.id] == 'undefined'">
            {{ linkFileNameUpdate[link.id] ?? link.file_name }}
          </div>
          <div class="col" v-else>
            Deleted... <a href="" @click.prevent="undoDeleteLink(link.id)">undo?</a>
          </div>
          <div class="col-auto ms-1">
            <i class="bi-backspace position-absolute end-0 mx-1 d-none" ref="linkUndoButtons" @click="resetButton(link.id)" :data-link-id="link.id" />
            <i class="bi-trash position-absolute end-0 bottom-0 mx-1" ref="linkDeleteButtons" @click="deleteLink(link.id)" :data-link-id="link.id"/>
          </div>
        </div>
      </li>
    </template>
  </ul>
  <nav aria-label="Link list navigation">
    <ul class="pagination justify-content-center mt-3">
      <li class="page-item"><a class="page-link" :class="{'disabled': linkPage <= 1}" @click="linkPage--">Previous</a></li>
      <li class="page-item" v-for="page in Math.ceil(links.length / linksPerPage)"><a class="page-link" style="cursor: pointer" :class="{'active': page === linkPage}" @click="linkPage = page">{{ page }}</a></li>
      <li class="page-item"><a class="page-link" :class="{'disabled': linkPage >= Math.ceil(links.length / linksPerPage)}" @click="linkPage++">Next</a></li>
    </ul>
  </nav>
</template>

<style scoped lang="scss">

</style>