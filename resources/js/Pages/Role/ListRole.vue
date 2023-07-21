<template>
  <inertia-head>
    <title>Roles</title>
  </inertia-head>

  <div class="flex flex-row h-full w-full">
    <SideMenu pageIndex="3"/>
    <div class="flex flex-col flex-auto bg-white w-4/5 h-screen">
      <NavBar />
      <div class="flex flex-col h-auto w-full bg-white">
        <div
          class="flex flex-col w-full h-full border-blue-100"
          style="border-width: 20px"
        >
          <div class="flex flex-col">
            <div class="mt-5 ml-5">
              <span class="font-bold text-3xl">Roles</span>
            </div>

            <div class="mt-3 mr-5 flex justify-end">
              <a
                type="button"
                class="btn btn-primary bg-sky-400 text-white font-bold py-2 px-4 rounded"
                :href="'/role/create'"
              >
                + Create Role
              </a>
            </div>

            <div class="m-5">
              <table
                class="w-full table-auto overflow-x-auto text-sm text-gray-500 dark:text-gray-400"
              >
                <thead
                  class="text-base font-bold border text-gray-700 uppercase text-left dark:bg-gray-700 dark:text-gray-400"
                >
                  <tr>
                    <td class="px-6 py-3 border">#</td>
                    <td class="px-6 py-3 border">Name</td>
                    <td class="px-6 py-3 border">Action</td>
                  </tr>
                </thead>
                <tbody>
                  <tr
                    v-for="(role, index) in roles"
                    :key="index"
                    class="bg-white text-sm text-gray-800 border-b dark:bg-gray-800 dark:border-gray-700"
                  >
                    <td class="px-6 py-4 w-3 border">{{ index + 1 }}</td>
                    <td class="px-6 py-4 border">{{ role.name }}</td>
                    <td class="px-6 py-4 border">
                      <a
                        type="button"
                        class="btn btn-primary mr-2 bg-white text-gray-500 py-2 px-4 rounded border-2 border-gray-300"
                        :href="'/role/' + role.id + '/update'"
                        >Edit</a
                      >
                      <a
                        type="button"
                        class="btn btn-primary mr-2 bg-white text-red-500 py-2 px-4 rounded border-2 border-red-500"
                        :href="'/role/' + role.id + '/delete'"
                        >Delete</a
                      >
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
  
  <script>
import { defineComponent } from "vue";
import { VueDraggableNext } from "vue-draggable-next";
import NavBar from "../../NavBar/NavBar.vue";
import SideMenu from "../../Menu/Side-Menu.vue";

export default defineComponent({
  props: ["roles_array"],
  components: {
    NavBar,
    SideMenu,
    draggable: VueDraggableNext,
  },
  data() {
    return {
      roles: [],
      csrf: this.$page.props.csrf_token,
      lengthOfRoles: 0,
    };
  },
  created() {
    this.sortRole();
  },
  methods: {
    sortRole() {
      this.roles = this.roles_array.data;
      this.roles.sort((a, b) => {
        return a.id - b.id;
      });
    },
  },
});
</script>
  