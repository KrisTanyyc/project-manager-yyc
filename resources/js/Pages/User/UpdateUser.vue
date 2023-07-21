<template>
  <inertia-head>
    <title>Update User</title>
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
            <span class="font-bold text-3xl">Update User</span>
          </div>
          <div class="m-3 mt-10">
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
                  v-model="user.name"
                  class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500"
                  id="inline-full-name"
                  type="text"
                />
              </div>
            </div>
          </div>

          <div v-if="'name' in errors" class="flex justify-center">
            <label class="text-red-500 text-base">{{ errors["name"] }}</label>
          </div>

          <div class="m-3 mt-10">
            <div class="w-full flex justify-between">
              <div class="w-1/3">
                <label
                  class="block mt-2 ml-5 text-gray-500 font-bold"
                  for="inline-full-name"
                >
                  User Email
                </label>
              </div>
              <div class="w-2/3">
                <input
                  v-model="user.email"
                  class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500"
                  id="inline-full-name"
                  type="text"
                />
              </div>
            </div>
          </div>

          <div v-if="'email' in errors" class="flex justify-center">
            <label class="text-red-500 text-base">{{ errors["email"] }}</label>
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
              href="/users"
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
  props: ["data"],
  components: {
    NavBar,
    SideMenu,
  },
  data() {
    return {
      user: this.data,
      errors: [],
      csrf: this.$page.props.csrf_token,
      isButtonClicked: false,
    };
  },
  created() {},
  methods: {
    checkValidation() {
      this.errors = [];
      if (
        this.user.name !== "" &&
        this.user.name !== null &&
        this.user.email !== "" &&
        this.user.email !== null
      ) {
        this.updateUser();
        this.isButtonClicked = true;
      }
      if (!this.user.name) {
        this.errors["name"] = "Please enter the user name";
      }
      if (!this.user.email) {
        this.errors["email"] = "Please enter the user email";
      }
    },

    updateUser() {
      this.errors = [];
      var url = "/api/updateUser/" + this.user.id,
        method = "put";
      fetch(url, {
        method: method,
        body: JSON.stringify({
          name: this.user.name,
          email: this.user.email,
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
            window.location.href = "/users";
          }
        })
        .catch((error) => {
          console.log("Error updating users, ", error);
        });
    },
  },
});
</script>
      