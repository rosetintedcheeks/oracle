<script setup>
import {computed, ref} from "vue";
import {router} from "@inertiajs/vue3";

const props = defineProps({
  links: null
})

const linkPathUpdate = ref({}); // stores link paths that were changed and need to be uploaded
const linkDeleted = ref({}); // stores link ids that are to be deleted

const updateLink = (event) => {
  const linkId = event.target.dataset.linkId;
  if(typeof linkPathUpdate.value[linkId] == 'undefined') {
    toggleShowButton(linkId, true);
  }
  linkPathUpdate.value[linkId] = event.target.innerText;
}

const linkUndoButtons = ref([]); // references to the reset buttons
const linkDeleteButtons = ref([]); // references to the reset buttons
const linkPathItems = ref([]); // references to the elements that hold the path

const toggleShowButton = (linkId, onOff) => {
  console.log(linkUndoButtons)
  const button = linkUndoButtons.value.find(el => el.dataset.linkId === linkId.toString())
  if(onOff) {
    button.classList.remove('d-none');
  } else {
    button.classList.add('d-none');
  }
}

const resetButton = (id) => {
  toggleShowButton(id, false);
  const linkPath = linkPathItems.value.find(el => el.dataset.linkId === id.toString())
  linkPath.innerText = props.links.find(link => link.id).path;
  delete linkPathUpdate.value[id];
}

const linksPerPage = ref(10);
const linkPage = ref(1); // current page

const pagedLinks = computed(() => props.links.slice(linksPerPage.value * (linkPage.value - 1), linksPerPage.value * linkPage.value))

const deleteLink = (id) => {
  linkDeleted.value[id] = true;
}

const undoDeleteLink = (id) => {
  delete linkDeleted.value[id];
}

const searchText = ref('')
const replaceText = ref('')

const searchReplaceLinkPaths = () => {
  props.links.forEach((link) => {
    if(link.path.match(searchText.value)) {
      if(typeof linkPathUpdate.value[link.id] == 'undefined') linkPathUpdate.value[link.id] = link.path
      linkPathUpdate.value[link.id].replaceAll(new RegExp(searchText.value), replaceText.value);
    }
  });
  console.log(linkPathUpdate.value)
}

const saveChanges = () => {
  router.post('/links', {
    'linkPaths': linkPathUpdate.value,
    'deletedLinks': linkDeleted.value
  });
  linkPathUpdate.value = {};
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
            {{ link.file_name }}
          </div>
          <div class="col" spellcheck="false" contenteditable="true" ref="linkPathItems" @input="updateLink" :data-link-id="link.id" v-if="typeof linkDeleted[link.id] == 'undefined'">
            {{ linkPathUpdate[link.id] ?? link.path }}
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