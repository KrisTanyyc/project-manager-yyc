<template>
  <div class="flex flex-col flex-none bg-white h-screen " :class="width">
    <div class="flex justify-between w-full h-14 mt-5">
      <div class="ml-5">
        <img
          class="w-32"
          src="../../../public/asset1/images/taxPOD-logo.png"
          alt="YYC Logo"
          :class="hidden"
        />
      </div>
      <div class="mr-5 ml-5">
        <button @click="toggleSideMenu()">
          <fa icon="fa-solid fa-bars" class="w-15 h-5 mt-5" />
        </button>
      </div>
    </div>
    <div class="w-full h-14 py-10 ml-3" :class="hidden">
      <div>
        <p class="font-bold text-base">{{ user.name }}</p>
        <p class="text-sm text-gray-600">Welcome</p>
      </div>
    </div>
    <div class="w-full h-14 mt-10 ml-7" :class="hidden">
      <p class="text-sm text-gray-600">Menu</p>
    </div>
    <div class="flex flex-col w-full h-full" :class="marginForDiv">
      <a href="/projects" :class="changeColor('1')">
        <fa
          icon="fa-solid fa-file"
          class="mx-3 text-lg"
          style="color: gray"
        /><span class="font-bold text-lg ml-2" :class="hidden">Project</span>
      </a>

      <a href="/users" :class="changeColor('2')">
        <fa
          icon="fa-solid fa-user"
          class="mx-3 text-lg"
          style="color: gray"
        /><span class="font-bold text-lg ml-2" :class="hidden">User</span>
      </a>

      <a href="/roles" :class="changeColor('3')">
        <fa
          icon="fa-solid fa-users"
          class="mx-3 text-lg"
          style="color: gray"
        /><span class="font-bold text-lg" :class="hidden">Role</span>
      </a>
    </div>
  </div>
</template>
    
    <script>
import { defineComponent } from "vue";

export default defineComponent({
  props: ["user", "pageIndex"],
  components: {},
  data() {
    return {
      open: false,
      width: "w-20 sm:w-1/5",
      hidden: "hidden sm:inline",
      marginForDiv: "mt-10 sm:mt-0",
      user: this.$page.props.user,
    };
  },
  created() {},
  methods: {
    toggleSideMenu() {
      if (this.open) {
        this.open = !this.open;
        this.width = "w-20 sm:w-20";
        this.hidden = "hidden sm:hidden";
        this.marginForDiv = " mt-10 sm:mt-10";
      } else {
        this.open = !this.open;
        this.width = "w-20 sm:w-1/5";
        this.hidden = "hidden sm:inline";
        this.marginForDiv = " mt-10 sm:mt-0";
      }
    },

    changeColor(num) {
      if (this.pageIndex === num) {
        return ["hover:bg-slate-300", "pl-5", "py-2", "mb-1", "bg-slate-300"];
      } else {
        return ["hover:bg-slate-300", "pl-5", "py-2", "mb-1", "bg-slate-50"];
      }
    },
  },
});
</script>
    