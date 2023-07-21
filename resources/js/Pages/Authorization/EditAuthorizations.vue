<template>
  <inertia-head>
    <title>{{ project.name }}</title>
  </inertia-head>

  <div class="flex flex-row h-full w-full">
    <SideMenu pageIndex="1" />
    <div class="flex flex-col flex-auto bg-white w-4/5 h-screen">
      <NavBar />
      <div class="flex flex-col h-auto w-full bg-white">
        <div
          class="flex flex-col w-full h-full border-blue-100"
          style="border-width: 20px"
        >
          <div class="flex flex-col">
            <div class="flex justify-end pt-10">
              <a
                type="button"
                class="btn btn-primary mr-2 mb-5 bg-gray-200 text-black py-2 px-4 rounded"
                :href="'/projects'"
                ><fa icon="fa-solid fa-angle-left" class="mr-2" />Back</a
              >
              <button
                type="button"
                class="btn btn-primary float-right mr-5 mb-5 bg-sky-400 text-white font-bold py-2 px-4 rounded"
                @click="updateAuthorization()"
                :disabled="isButtonClicked"
              >
                Save
              </button>
            </div>
            <div class="ml-5 mr-5">
              <table
                class="w-full table-fixed overflow-x-auto text-sm text-gray-500 dark:text-gray-400"
              >
                <thead
                  class="text-2xl text-gray-700 font-bold align-middle uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400"
                >
                  <tr>
                    <th
                      :colspan="2 + lengthofStakeholders"
                      scope="col"
                      class="px-6 py-3"
                    >
                      {{ project.name }}
                    </th>
                  </tr>
                </thead>
                <tbody>
                  <tr
                    class="bg-white text-lg font-bold border-b dark:bg-gray-800 dark:border-gray-700"
                  >
                    <th scope="row" rowspan="2" class="px-6 py-4 border">
                      Module
                    </th>
                    <td class="px-6 py-4 border text-center" rowspan="2">
                      Action
                    </td>
                    <td
                      class="px-6 py-4 border text-center"
                      :colspan="lengthofStakeholders"
                    >
                      Stakeholder
                    </td>
                  </tr>
                  <tr
                    class="bg-white text-center border-b dark:bg-gray-800 dark:border-gray-700"
                  >
                    <td
                      class="px-3 py-2 border"
                      v-for="(stakeholder, index) in stakeholders"
                      :key="index"
                    >
                      {{ stakeholder.name }}
                    </td>
                  </tr>
                  <tr
                    v-for="(smodule, index) in smodules"
                    :key="index"
                    class="bg-white border-b dark:bg-gray-800 dark:border-gray-700"
                  >
                    <th
                      scope="row"
                      class="px-6 py-4 border font-medium text-gray-900 whitespace-nowrap dark:text-white"
                    >
                      {{ smodule.name }}
                    </th>
                    <td class="px-6 py-4 text-center">
                      <ul>
                        <li
                          v-for="(action, indexAction) in actions[index]"
                          :key="indexAction"
                        >
                          {{ action.name }}
                        </li>
                      </ul>
                    </td>
                    <td
                      class="px-6 py-4 text-center border"
                      v-for="(stakeholder, indexStakeholder) in stakeholders"
                      :key="indexStakeholder"
                    >
                      <ul>
                        <li
                          v-for="(action, indexAction) in actions[index]"
                          :key="indexAction"
                        >
                          <input
                            id="default-checkbox"
                            type="checkbox"
                            :value="stakeholder.id"
                            v-model="editChoose[action.id][stakeholder.id]"
                            class="w-4 h-4 text-indigo-600 form-checkbox bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                          />
                        </li>
                      </ul>
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
      lengthofStakeholders: Number,
      lengthofActions: [],
      checkArray: [],
      editChoose: {},
      csrf: this.$page.props.csrf_token,
      isButtonClicked: false,
      authorized: [
        {
          actionId: Number,
          stakeholderId: Number,
          checked: false,
        },
      ],
    };
  },
  mounted() {},
  created() {
    this.initializeObject();
  },
  methods: {
    initializeObject() {
      this.lengthofStakeholders = this.stakeholders.length;
      for (let i = 0; i < this.actions.length; i++) {
        this.actions[i].forEach((action) => {
          this.editChoose[action.id] = {};
          for (let j = 0; j < this.lengthofStakeholders; j++) {
            this.editChoose[action.id][this.stakeholders[j].id] = false;
          }
        });
      }

      for (let i = 0; i < this.actions.length; i++) {
        for (let j = 0; j < this.actions[i].length; j++) {
          var tempAuth = this.authorizations[i];
          var tempAct = this.actions[i];
          tempAuth[j].map((x) => {
            this.editChoose[tempAct[j].id][x] = true;
          });
        }
      }
    },

    updateAuthorization() {
      // for (const actionId in this.editChoose) {
      //   console.log(`action ID: ${actionId}: ${this.editChoose[actionId]}`);
      // }
      this.isButtonClicked = true;
      var url = "/api/project/" + this.project.id + "/authorization/update",
        method = "post";
      fetch(url, {
        method: method,
        body: JSON.stringify({
          checkedArray: this.editChoose,
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
            window.location.href = "/projects/" + this.project.id;
          }
        })
        .catch((error) => console.log(error));
    },
  },
});
</script>
    