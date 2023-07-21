<template>
  <inertia-head>
    <title>Create Stakeholder</title>
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
            <span class="font-bold text-3xl">Create Stakeholder</span>
          </div>
          <div class="m-3 mt-10">
            <div class="w-full flex justify-between">
              <div class="w-1/3">
                <label
                  class="block mt-2 ml-5 text-gray-500 font-bold"
                  for="inline-full-name"
                >
                  Stakeholder Name
                </label>
              </div>
              <div class="w-2/3">
                <input
                  v-model="stakeholder.name"
                  class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500"
                  id="inline-full-name"
                  type="text"
                />
              </div>
            </div>
            <div class="flex justify-center" v-if="'name' in errors">
              <label class="text-red-500">{{ errors["name"] }}</label>
            </div>
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
              :href="'/projects/' + project_id +'?tab=1'"
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
  props: ["project_id"],
  components: {
    NavBar,
    SideMenu,
  },
  data() {
    return {
      stakeholder: {
        name: "",
      },
      errors: [],
      csrf: this.$page.props.csrf_token,
      isButtonClicked: false,
    };
  },
  created() {},
  methods: {
    checkValidation() {
      this.errors = [];
      if (this.stakeholder.name !== "" && this.stakeholder.name !== null) {
        this.createStakeholder();
        this.isButtonClicked = true;
      }
      if (!this.stakeholder.name) {
        this.errors["name"] = "Please enter the stakeholder name";
      }
    },

    createStakeholder() {
      this.errors = [];
      var url = "/api/project/" + this.project_id + "/stakeholder/create",
        method = "post";
      fetch(url, {
        method: method,
        body: JSON.stringify({
          stakeholder_name: this.stakeholder.name,
          project_id: parseInt(this.project_id),
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
            window.location.href = "/projects/" + this.project_id +"?tab=1";
          }
        })
        .catch((error) => {
          console.log("Error creating stakeholder ", error);
        });
    },
  },
});
</script>
    