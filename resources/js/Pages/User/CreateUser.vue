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
                  Name
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

            <div class="flex justify-center" v-if="'name' in errors">
              <label class="text-red-500">{{ errors["name"] }}</label>
            </div>

            <div class="w-full flex justify-between mt-5">
              <div class="w-1/3">
                <label
                  class="block mt-2 ml-5 text-gray-500 font-bold"
                  for="inline-full-name"
                >
                  Email
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

            <div class="flex justify-center" v-if="'email' in errors">
              <label class="text-red-500">{{ errors["email"] }}</label>
            </div>
            <div class="w-full flex justify-between mt-5">
              <div class="w-1/3">
                <label
                  class="block mt-2 ml-5 text-gray-500 font-bold"
                  for="inline-full-name"
                >
                  Password
                </label>
              </div>
              <div class="w-2/3">
                <input
                  v-model="user.password"
                  class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500"
                  id="inline-full-name"
                  type="password"
                />
              </div>
            </div>
            <div class="flex justify-center" v-if="'password' in errors">
              <label class="text-red-500">{{ errors["password"] }}</label>
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
import multiselect from "@vueform/multiselect";

export default defineComponent({
  props: ["data"],
  components: {
    NavBar,
    SideMenu,
    multiselect,
  },
  data() {
    return {
      user: {
        name: "",
        email: "",
        password: "",
        role_id: [],
      },
      value: null,
      roles: [],
      userlist: [],
      errors: [],
      csrf: this.$page.props.csrf_token,
      isButtonClicked: false,
    };
  },
  created() {
    this.fetchRole();
    this.fetchUser();
  },
  methods: {
    fetchRole() {
      fetch("/api/displayRolesName")
        .then((response) => response.json())
        .then((response) => {
          this.roles = response.data;
          console.log(this.roles);
        })
        .catch((error) => console.log(error));
    },
    fetchUser() {
      fetch("/api/listUserCreate")
        .then((response) => {
          return response.json();
        })
        .then((response) => {
          this.userlist = response.data;
          console.log(this.userlist);
        })
        .catch((error) => console.log(error));
    },
    checkValidation() {
      this.user.role_id = this.value;
      this.errors = [];
      if (this.user.name && this.user.email && this.user.password) {
        if (this.userlist.some((user) => user.email === this.user.email)) {
          const alertTitle = "Email already existes!";
          const alertMessage =
            "Failed to create user. Please try again with a different email address.";
          window.alert(alertTitle + "\n\n" + alertMessage);
          window.location.reload();
        } else {
          this.CreateUser();
          this.isButtonClicked = true;
        }
      }
      if (!this.user.name) {
        this.errors["name"] = "Please enter the user name";
      }
      if (!this.user.email) {
        this.errors["email"] = "Please enter the user email";
      }
      if (!this.user.password) {
        this.errors["password"] = "Please enter the user password";
      }
    },
    CreateUser() {
      this.errors = [];
      var url = "/api/createUsers",
        method = "post";
      fetch(url, {
        method: method,
        body: JSON.stringify({
          name: this.user.name,
          email: this.user.email,
          password: this.user.password,
          role_id: this.user.role_id,
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
          console.log("Error creating user ", error);
        });
    },
  },
});
</script>

<style src="@vueform/multiselect/themes/default.css"></style>

    
