<template>
  <div class="flex flex-none h-1/7 w-full bg-white justify-end p-5">
    <div>
      <button
        @click="open = !open"
        id="dropdownDefaultButton"
        data-dropdown-toggle="dropdown"
        class="inline-flex items-center p-2 ml-3 mt-3 text-sm text-gray-500 rounded-lg hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
        type="button"
      >
        <fa icon="fa-solid fa-user mr-2" style="color: deepskyblue" />
        <span class="ml-5">{{ user.name }}</span>
      </button>
    </div>
    <div
      v-if="open"
      id="dropdown"
      class="top-20 absolute z-10 right-5 bg-white divide-y divide-gray-600 rounded-lg shadow w-44 dark:bg-gray-700"
    >
      <ul
        class="py-2 text-sm text-gray-700 dark:text-gray-200"
        aria-labelledby="dropdownDefaultButton"
      >
        <li>
          <button
            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"
          >
            <p>
              <fa
                icon="fa-solid fa-power-off"
                class="mr-1"
                style="color: deepskyblue"
              />
              Change Password
            </p>
          </button>
        </li>
        <li>
          <button
            @click="userLogout"
            class="w-full text-left px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"
          >
            <p>
              <fa
                icon="fa-solid fa-power-off"
                class="mr-1"
                style="color: deepskyblue"
              />
              Logout
            </p>
          </button>
        </li>
      </ul>
    </div>
  </div>
</template>
    
    <script>
import { defineComponent } from "vue";

export default defineComponent({
  props: ["user"],

  components: {},

  data() {
    return {
      open: false,
      csrf: this.$page.props.csrf_token,
      user: this.$page.props.user,
    };
  },

  methods: {
    userLogout() {
      var url = "/logout",
        method = "delete";

      fetch(url, {
        method: method,
        headers: {
          "content-type": "application/json",
          "X-CSRF-TOKEN": this.csrf,
        },
      })
        .then((response) => {
          return response.json();
        })
        .then((data) => {
          if (data.success) {
            window.location.href = "/login";
          }
        })
        .catch((error) => {
          console.log(error);
        });
    },
  },
});
</script>
    