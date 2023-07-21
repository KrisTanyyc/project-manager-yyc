<template>
  <inertia-head>
    <title>{{ data.name }}</title>
  </inertia-head>

  <div class="flex flex-row h-full w-full">
    <SideMenu />
    <div class="flex flex-col flex-auto bg-white w-4/5 h-screen">
      <NavBar />
      <div class="flex flex-col h-auto w-full bg-white">
        <div
          class="flex flex-col w-full h-full border-blue-100"
          style="border-width: 20px"
        >
          <div class="mt-3 mb-5">
            <a
              type="button"
              class="btn btn-primary ml-5 bg-gray-400 text-black font-bold py-2 px-4 rounded"
              :href="'/projects'"
              >Back</a
            >
          </div>

          <div class="ml-5">
            <div class="btn-group">
              <button
                type="button"
                class="btn btn-outline-secondary border-2 text-lg p-2 text-gray-600 focus:bg-gray-300 focus:text-white"
                :class="{ focus: tab === 0 }"
                @click="switchToTab(0)"
              >
                Project
              </button>
              <button
                type="button"
                class="btn btn-outline-secondary border-2 text-lg p-2 text-gray-600 focus:bg-gray-300 focus:text-white"
                :class="{ focus: tab === 1 }"
                @click="switchToTab(1)"
              >
                Stakeholder
              </button>
              <button
                type="button"
                class="btn btn-outline-secondary border-2 text-lg p-2 text-gray-600 focus:bg-gray-300 focus:text-white"
                :class="{ focus: tab === 2 }"
                @click="switchToTab(2)"
              >
                Module
              </button>
            </div>
          </div>
          <div v-if="tab === 0">
            <div>
              <button
                type="button"
                class="btn btn-primary float-right mr-5 mb-5 bg-sky-400 text-white font-bold py-2 px-4 rounded"
                @click="printPage()"
              >
                Print
              </button>
            </div>
            <div>
              <a
                type="button"
                class="btn btn-primary float-right mr-5 mb-5 bg-sky-400 text-white font-bold py-2 px-4 rounded"
                :href="'/project/' + data.id + '/authorizations/edit'"
                >Edit</a
              >
            </div>
            <table id="printTable"
              class="w-11/12 ml-5 mt-5 table-fixed text-sm text-gray-500 dark:text-gray-400"
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
                    {{ data.name }}
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
                        v-for="(check, indexCheck) in checkArray[index]"
                        :key="indexCheck"
                      >
                        <span v-if="check[indexStakeholder]" class="text-black">✔</span>
                        <span v-else>❌</span>
                      </li>
                    </ul>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <div v-if="tab === 1">
            <div class="mb-5">
              <a
                type="button"
                class="btn btn-primary float-right mb-5 mr-2 bg-sky-400 text-white font-bold py-2 px-4 rounded"
                :href="'/project/' + data.id + '/stakeholder/create'"
                >+ Create Stakeholder</a
              >
            </div>
            <StakeholderList :project_id="data.id" />
          </div>
          <div v-if="tab === 2">
            <div class="mb-5">
              <a
                type="button"
                class="btn btn-primary float-right mb-5 mr-2 bg-sky-400 text-white font-bold py-2 px-4 rounded"
                :href="'/project/' + data.id + '/module/create'"
                >+ Create Module</a
              >
            </div>
            <ModuleList :project_id="data.id" />
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
import StakeholderList from "../Stakeholder/ListStakeholder.vue";
import ModuleList from "../Module/ListModule.vue";

export default defineComponent({
  props: ["data","user"],
  components: {
    NavBar,
    SideMenu,
    StakeholderList,
    ModuleList,
  },
  data() {
    return {
      tab: null,
      smodules: [],
      stakeholders: [],
      lengthofStakeholders: Number,
      lengthofActions: [],
      actions: [],
      authorizations: [],
      checkArray: [],
    };
  },
  mounted() {
    const urlParams = new URLSearchParams(window.location.search);
    const tab = urlParams.get("tab");
    if (tab !== null) {
      this.tab = parseInt(tab);
    } else {
      this.tab = 0; // set default tab index
    }
  },
  async created() {
    await this.fetchModule();
    await this.fetchStakeholder();
    await this.fetchAction();
    await this.fetchAuthorization();
  },
  methods: {
    switchToTab(tabIndex) {
      this.tab = tabIndex;
      const url = `/project/1?tab=${tabIndex}`;
      history.pushState({ path: url }, "", url);
    },

    async fetchModule() {
      var url = "/api/project/" + this.data.id + "/listModules";
      return fetch(url)
        .then((response) => {
          return response.json();
        })
        .then((response) => {
          this.smodules = response.data;
          this.smodules.sort((a, b) => {
            return a.id - b.id;
          });
        })
        .catch((error) => console.log("Error getting modules ", error));
    },

    async fetchStakeholder() {
      var url = "/api/project/" + this.data.id + "/listStakeholders";
      return fetch(url)
        .then((response) => {
          return response.json();
        })
        .then((response) => {
          this.stakeholders = response.data;
          this.lengthofStakeholders = this.stakeholders.length;
          this.stakeholders.sort((a, b) => {
            return a.id - b.id;
          });
        })
        .catch((error) => console.log("Error getting stakeholders ", error));
    },

    async fetchAction() {
      for (const smodule of this.smodules) {
        var url =
          "/api/project/" + this.data.id + "/module/" + smodule.id + "/actions";
        await fetch(url)
          .then((response) => {
            return response.json();
          })
          .then((response) => {
            this.actions.push(response.data);
            this.actions.sort((a, b) => {
              return a.id - b.id;
            });
          })
          .catch((error) => console.log("Error getting actions ", error));
      }
    },

    async fetchAuthorization() {
      for (let i = 0; i < this.actions.length; i++) {
        this.authorizations[i] = [];
        for (const action of this.actions[i]) {
          var url = "/api/action/" + action.id + "/authorization";
          await fetch(url)
            .then((response) => {
              return response.json();
            })
            .then((response) => {
              this.authorizations[i].push(response);
              this.authorizations.sort((a, b) => {
                return a.id - b.id;
              });
            })
            .catch((error) =>
              console.log("Error getting authorization ", error)
            );
        }
      }
      this.checkAuthorized();
    },

    checkAuthorized() {
      for (let i = 0; i < this.authorizations.length; i++) {
        this.checkArray[i] = [];
        this.authorizations[i].forEach((authorization) => {
          var tempArray = [];
          this.stakeholders.map((x) => {
            if (authorization.includes(x.id)) {
              tempArray.push(true);
            } else {
              tempArray.push(false);
            }
          });
          this.checkArray[i].push(tempArray);
        });
      }
      console.log(this.actions[0]);
    },
    printPage() {
      var divElements = document.getElementById("printTable");
      var newWin = window.open("/print");
      newWin.addEventListener("load", function () {
        newWin.document.getElementById("printTable").innerHTML =
          divElements.innerHTML;
        newWin.print();
      });
    },
  },
});
</script>
  