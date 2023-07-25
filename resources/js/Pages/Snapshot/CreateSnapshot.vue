<template>
  <title>Create Snapshpt</title>

  <div class="flex flex-row h-full w-full">
    <SideMenu pageIndex="1" />
    <div class="flex flex-col flex-auto bg-white w-4/5 h-screen">
      <NavBar />
      <div class="flex flex-col flex-auto h-4/5 w-full bg-white">
        <div
          class="flex flex-col w-full h-full border-blue-100"
          style="border-width: 20px"
        >
          <div class="mt-5 ml-5">
            <span class="font-bold text-3xl">Create Snapshot</span>
          </div>
          <div class="m-3 mt-10">
            <div class="w-full flex justify-between">
              <div class="w-1/3">
                <label
                  class="block mt-2 ml-5 text-gray-500 font-bold"
                  for="inline-full-name"
                >
                  Snapshot Name
                </label>
              </div>
              <div class="w-2/3">
                <input
                  v-model="snapshotName"
                  class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500"
                  id="inline-full-name"
                  type="text"
                />
              </div>
            </div>
          </div>

          <div v-if="'name' in errors" class="flex justify-center mt-5">
            <label class="text-red-500 text-base">{{ errors["name"] }}</label>
          </div>

          <div class="mt-20 mr-10 flex flex-row justify-end">
            <button
              @click="checkValidation()"
              class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
              :disabled="isButtonClicked"
            >
              Save
            </button>
            <a
              :href="'/projects/' + project.id"
              class="bg-gray-500 ml-5 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded"
            >
              Cancel
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
      
      <script>
import { defineComponent } from "vue";
import NavBar from "../../NavBar/NavBar.vue";
import SideMenu from "../../Menu/Side-Menu.vue";

export default defineComponent({
  props: ["project", "smodules", "actions", "stakeholders", "authorizations"],
  components: {
    NavBar,
    SideMenu,
  },
  data() {
    return {
      data: {},
      csrf: this.$page.props.csrf_token,
      isButtonClicked: false,
      errors: [],
      snapshotName: "",
    };
  },
  created() {
    this.dataInitialization();
  },
  methods: {
    dataInitialization() {
      var modules = [];
      this.smodules.forEach((element) => {
        modules.push(element.name);
      });
      this.data["modules"] = modules;
      this.data["stakeholders"] = this.stakeholders;
      var actions = [];
      this.actions.forEach((element) => {
        var tempArr = [];
        element.forEach((action) => {
          tempArr.push(action.name);
        });
        actions.push(tempArr);
      });
      this.data["actions"] = actions;
      this.data["authorizations"] = this.authorizations;
      console.log(this.data);
    },

    checkValidation() {
      this.errors = [];
      if (this.snapshotName) {
        this.data["name"] = this.snapshotName;
        this.createSnapshot();
        this.isButtonClicked = true;
      }
      if (!this.snapshotName) {
        this.errors["name"] = "Please enter snapshot name";
      }
    },

    createSnapshot() {
      this.errors = [];
      var url = "/api/project/" + this.project.id + "/snapshot/create",
        method = "post";
      fetch(url, {
        method: method,
        body: JSON.stringify({
          name: this.snapshotName,
          data: this.data,
        }),
        headers: {
          "content-type": "application/json",
          "X-CSRF-TOKEN": this.csrf,
        },
      })
        .then((response) => {
          return response.json();
        })
        .then((response) => {
          if (response.success) {
            window.location.href = "/projects/" + this.project.id + "?tab=3";
          }
          console.log(response);
        })
        .catch((error) => console.log(error));
    },
  },
});
</script>
      