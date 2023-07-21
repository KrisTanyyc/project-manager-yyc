<template>
  <inertia-head>
    <title>Update Action</title>
  </inertia-head>

  <div class="flex flex-row h-full w-full">
    <SideMenu pageIndex="1"/>
    <div class="flex flex-col flex-auto bg-white w-4/5 h-screen">
      <NavBar />
      <div class="flex flex-col flex-auto h-4/5 w-full bg-white">
        <div
          class="flex flex-col w-full h-full border-blue-100"
          style="border-width: 20px"
        >
          <div class="mt-5 ml-5">
            <span class="font-bold text-3xl">Update Action</span>
          </div>
          <div class="m-3 mt-10">
            <div class="w-full flex justify-between">
              <div class="w-1/3">
                <label
                  class="block mt-2 ml-5 text-gray-500 font-bold"
                  for="inline-full-name"
                >
                  Action Name
                </label>
              </div>
              <div class="w-2/3">
                <input
                  v-model="action.name"
                  class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500"
                  id="inline-full-name"
                  type="text"
                />
              </div>
            </div>
          </div>

          <div class="flex justify-center" v-if="'action' in errors">
            <label class="text-red-500">{{ errors["action"] }}</label>
          </div>

          <div class="pt-5 mr-10 flex flex-row justify-end">
            <button
              @click="checkValidation()"
              class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
              :disabled="isButtonClicked"
            >
              Save
            </button>
            <a
              :href="
                '/project/' +
                project_id +
                '/module/' +
                data.module_id +
                '/actions'
              "
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
  props: ["data", "project_id"],
  components: {
    NavBar,
    SideMenu,
  },
  data() {
    return {
      action: this.data,
      errors: [],
      csrf: this.$page.props.csrf_token,
      isButtonClicked: false,
    };
  },
  created() {},
  methods: {
    checkValidation() {
      this.errors = [];
      if (this.action.name !== "" && this.action.name !== null) {
        this.updateAction();
        this.isButtonClicked = true;
      }
      if (!this.action.name) {
        this.errors["action"] = "Please enter the action name";
      }
    },

    updateAction() {
      this.errors = [];
      var url =
          "/api/module/" +
          this.data.module_id +
          "/action/" +
          this.data.id +
          "/update",
        method = "put";
      fetch(url, {
        method: method,
        body: JSON.stringify({
          action_name: this.action.name,
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
            window.location.href =
              "/project/" +
              this.project_id +
              "/module/" +
              this.data.module_id +
              "/actions";
          }
        })
        .catch((error) => console.log("Error updating action: ", error));
    },
  },
});
</script>
      