<template>
  <inertia-head>
    <title>Create User</title>
  </inertia-head>

  <div class="flex flex-row h-full w-full">
    <SideMenu pageIndex="2"/>
    <div class="flex flex-col flex-auto bg-white w-4/5 h-screen">
      <NavBar />
      <div class="flex flex-col flex-auto h-4/5 w-full bg-white">
        <div
          class="flex flex-col w-full h-full border-blue-100"
          style="border-width: 20px"
        >
          <div class="mt-5 ml-5">
            <span class="font-bold text-3xl">Create User</span>
          </div>
          <div class="mt-3 mr-3">
            <div class="w-full flex justify-between">
              <div class="w-1/3">
                <label
                  class="block mt-2 ml-5 text-gray-500 font-bold"
                  for="inline-full-name"
                >
                  User Name
                </label>
              </div>
              <div class="w-2/3">
                <input
                  :value="user.name"
                  disabled
                  class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500"
                  id="inline-full-name"
                  type="text"
                />
              </div>
            </div>

            <div class="w-full flex justify-between mt-5">
              <div class="w-1/3">
                <label
                  class="block mt-2 ml-5 text-gray-500 font-bold"
                  for="inline-full-name"
                >
                  Role
                </label>
              </div>
              <div class="w-2/3">
                <multiselect
                  v-model="value"
                  mode="tags"
                  placeholder="Select roles"
                  track-by="name"
                  label="name"
                  :close-on-select="false"
                  :options="roles"
                  class="multiselect-blue"
                />
              </div>
            </div>
          </div>

          <div class="mt-10 mr-10 flex flex-row justify-end">
            <button
              @click="checkValidation()"
              class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
              :disabled="isButtonClicked"
            >
              Save
            </button>
            <a
              :href="'/user/' + user.id + '/roles'"
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
import multiselect from "@vueform/multiselect";

export default defineComponent({
  props: ["user"],
  components: {
    NavBar,
    SideMenu,
    multiselect,
  },
  data() {
    return {
      value: null,
      roles: [],
      errors: [],
      csrf: this.$page.props.csrf_token,
      isButtonClicked: false,
    };
  },
  created() {
    this.fetchUserAssignRoles();
  },
  methods: {
    fetchUserAssignRoles() {
      this.isButtonClicked = true;
      var url = "/api/displayAssignRole/" + this.user.id;
      fetch(url)
        .then((response) => {
          return response.json();
        })
        .then((response) => {
          this.roles = response.data;
          console.log(this.roles);
        })
        .catch((error) => console.log(error));
    },

    checkValidation() {
      this.errors = [];
      if (this.value === null) {
        this.errors["role"] = "Please choose role";
      } else {
        this.assignRole();
      }
    },

    assignRole() {
      this.errors = [];
      var url = "/api/assignUserRole",
        method = "post";
      fetch(url, {
        method: method,
        body: JSON.stringify({
          user_id: this.user.id,
          roles_id: this.value,
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
            window.location.href = "/user/" + this.user.id + "/roles";
          }
        })
        .catch((error) => console.log(error));
    },
  },
});
</script>
      