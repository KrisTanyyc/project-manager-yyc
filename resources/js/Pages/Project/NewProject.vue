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
          <div class="mt-5 mb-5 ml-5 font-bold text-2xl">
            <span>Project: {{ project.name }}</span>
          </div>

          <div class="ml-5">
            <div class="btn-group">
              <button
                type="button"
                :class="getButtonClass(0)"
                @click="switchToTab(0)"
              >
                Project
              </button>
              <button
                type="button"
                :class="getButtonClass(1)"
                @click="switchToTab(1)"
              >
                Stakeholder
              </button>
              <button
                type="button"
                :class="getButtonClass(2)"
                @click="switchToTab(2)"
              >
                Module
              </button>
              <button
                type="button"
                class="border-r-2"
                :class="getButtonClass(3)"
                @click="switchToTab(3)"
              >
                Snapshots
              </button>
            </div>
          </div>
          <div v-if="tab === 0" class="flex flex-col">
            <div class="flex justify-end">
              <a
                type="button"
                class="btn btn-primary mr-2 mb-5 bg-gray-200 text-black py-2 px-4 rounded"
                :href="'/projects'"
                ><fa icon="fa-solid fa-angle-left" class="mr-2" />Back</a
              >
              <a
                type="button"
                class="btn btn-primary mr-2 mb-5 bg-sky-400 text-white font-bold py-2 px-4 rounded"
                :href='"/project/" + project.id + "/snapshot/create"'
                >
                Snapshot
              </a>
              <button
                type="button"
                class="btn btn-primary mr-2 mb-5 bg-sky-400 text-white font-bold py-2 px-4 rounded"
                @click="printPage()"
              >
                Print
              </button>

              <a
                type="button"
                class="btn btn-primary mr-5 mb-5 bg-sky-400 text-white font-bold py-2 px-4 rounded"
                :href="'/project/' + project.id + '/authorizations/edit'"
                >Edit</a
              >
            </div>
            <div class="m-5">
              <table
                id="printTable"
                class="w-full table-fixed border-collapse overflow-x-auto text-sm text-gray-500 dark:text-gray-400"
              >
                <tbody>
                  <tr
                    class="bg-white text-lg font-bold border-b dark:bg-gray-800 dark:border-gray-700"
                  >
                    <th
                      scope="row"
                      rowspan="2"
                      class="w-4/12 px-6 py-4 border whitespace-normal break-normal"
                    >
                      Module
                    </th>
                    <td class="px-6 py-4 border text-center w-2/12" rowspan="2">
                      Action
                    </td>
                    <td
                      class="px-6 py-4 border text-center w-6/12"
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
                      class="px-6 py-4 text-base border font-medium whitespace-normal text-gray-900 dark:text-white"
                    >
                      {{ smodule.name }}
                    </th>
                    <td class="px-6 py-4 text-base text-center">
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
                          <span
                            v-if="check[indexStakeholder]"
                            class="text-base text-stone-950"
                            >✓</span
                          >
                          <span v-else class="text-base text-gray-200">X</span>
                        </li>
                      </ul>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          <div v-if="tab === 1">
            <div class="flex justify-end">
              <a
                type="button"
                class="btn btn-primary mr-5 bg-sky-400 text-white font-bold py-2 px-4 rounded"
                :href="'/project/' + project.id + '/stakeholder/create'"
                >+ Create Stakeholder</a
              >
            </div>
            <StakeholderList
              :stakeholders="project.stakeholders"
              :project_id="project.id"
            />
          </div>
          <div v-if="tab === 2" class="flex flex-col">
            <div class="flex justify-end">
              <a
                type="button"
                class="btn btn-primary mr-5 bg-sky-400 text-white font-bold py-2 px-4 rounded"
                :href="'/project/' + project.id + '/module/create'"
                >+ Create Module</a
              >
            </div>
            <ModuleList :smodules="project.modules" :project_id="project.id" />
          </div>
          <div v-if="tab === 3" class="flex flex-col">
            <div class="flex justify-end">
              <a
                type="button"
                class="btn btn-primary mr-5 bg-gray-200 text-black py-2 px-4 rounded"
                :href="'/projects'"
                ><fa icon="fa-solid fa-angle-left" class="mr-2" />Back</a
              >
            </div>
            <SnapshotList :snapshots="snapshots" :project_id="project.id"/>
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
import SnapshotList from "../Snapshot/ListSnapshot.vue";

export default defineComponent({
  props: ["project", "smodules", "actions", "authorizations", "stakeholders","snapshots"],
  components: {
    NavBar,
    SideMenu,
    StakeholderList,
    ModuleList,
    SnapshotList,
  },
  data() {
    return {
      tab: null,
      lengthofStakeholders: Number,
      lengthofActions: [],
      checkArray: [],
      sortModuleArray: [],
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
  created() {
    this.initialized();
    this.checkAuthorized();
    this.sortModule();
  },
  methods: {
    switchToTab(tabIndex) {
      this.tab = tabIndex;
      const url = `/projects/${this.project.id}?tab=${tabIndex}`;
      history.pushState({ path: url }, "", url);
      if (tabIndex === 0) {
        location.reload();
      }
    },

    getButtonClass(tabNumber) {
      return [
        "btn",
        "btn-outline-secondary",
        "text-base",
        "p-2",
        "w-32",
        "text-gray-600",
        "active:bg-gray-300",
        "active:text-white",
        "border-gray-400",
        "border-l-2 border-t-2 border-b-2",
        {
          "bg-gray-400 text-white border-l-0 border-r-0":
            this.tab === tabNumber,
        },
      ];
    },
    initialized() {
      this.lengthofStakeholders = this.stakeholders.length;
      console.log(this.authorizations.length);
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

    sortModule() {
      for (var item in this.smodules) {
        this.sortModuleArray.push([item, this.smodules[item]]);
      }

      this.sortModuleArray.sort((a, b) => {
        return a[1].order - b[1].order;
      });

      // console.log(this.sortModuleArray[0][1]);

      for (var item in this.sortModuleArray[0]) {
        console.log(item);
      }
    },
  },
});
</script>


  
