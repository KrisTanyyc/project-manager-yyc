<template>
  <inertia-head>
    <title>Snapshot</title>
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
            <span>Project:{{ project.name }}/{{ snapshot.name }} </span>
          </div>
          <div class="flex justify-end">
            <a
              type="button"
              class="btn btn-primary mr-2 mb-5 bg-gray-200 text-black py-2 px-4 rounded"
              :href="'/projects/' + project.id + '?tab=3'"
              ><fa icon="fa-solid fa-angle-left" class="mr-2" />Back</a
            >
            <button
              type="button"
              class="btn btn-primary mr-5 mb-5 bg-sky-400 text-white font-bold py-2 px-4 rounded"
              @click="printPage()"
            >
              Print
            </button>
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
                    {{ smodule }}
                  </th>
                  <td class="px-6 py-4 text-base text-center">
                    <ul>
                      <li
                        v-for="(action, indexAction) in actions[index]"
                        :key="indexAction"
                      >
                        {{ action }}
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
      </div>
    </div>
  </div>
</template>
      
      <script>
import { defineComponent } from "vue";
import NavBar from "../../NavBar/NavBar.vue";
import SideMenu from "../../Menu/Side-Menu.vue";

export default defineComponent({
  props: ["project", "snapshot"],
  components: {
    NavBar,
    SideMenu,
  },
  data() {
    return {
      lengthofStakeholders: 0,
      lengthofActions: [],
      checkArray: [],
      sortModuleArray: [],
      smodules: this.snapshot["data"]["modules"],
      actions: this.snapshot["data"]["actions"],
      authorizations: this.snapshot["data"]["authorizations"],
      stakeholders: this.snapshot["data"]["stakeholders"],
    };
  },
  mounted() {},
  created() {
    this.initialized();
    this.checkAuthorized();
  },
  methods: {
    initialized() {
      this.lengthofStakeholders = this.stakeholders.length;
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
  },
});
</script>
  

    
  