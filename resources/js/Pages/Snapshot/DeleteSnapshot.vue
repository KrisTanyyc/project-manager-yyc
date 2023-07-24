<template>
    <inertia-head>
      <title>Delete Snapshot</title>
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
              <span class="font-bold text-3xl">Delete Snapshot</span>
            </div>
            <div class="m-3 mt-10">
              <div class="w-full flex justify-between">
                <div class="w-1/3">
                  <label
                    class="block mt-2 ml-5 text-gray-500 font-bold"
                    for="inline-full-name"
                  >
                    Snapshot Name
                  </label>
                </div>
                <div class="w-2/3">
                  <input
                    value="snapshot name"
                    disabled
                    class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500"
                    id="inline-full-name"
                    type="text"
                  />
                </div>
              </div>
            </div>
  
            <div class="mt-20 mr-10 flex flex-row justify-end">
              <button
                @click="deleteStakeholder()"
                class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded"
                :disabled="isButtonClicked"
              >
                Comfirm Delete
              </button>
              <a
                href="/projects/31?tab=3"
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
      };
    },
    created() {},
    methods: {
      deleteStakeholder() {

       
      },
    },
  });
  </script>
          