
<template >
  <div class="w-full flex" >
    <sidebarVue />
    <div class="md:w-5/6">
      <Header2 />
      <div class="pl-[10%] md:pl-[20%] pt-[22%] md:pt-[8%]">
        <h1 class="text-16px md:text-3xl font-semibold text-transparent bg-clip-text bg-gradient-to-l from-[#8fcc53] to-[#0171c0]">
          👋 Welcome to {{ getUsers.school_name }}
          </h1>
      </div>
      <div class="md:ml-[19%] mt-10 mr-2 w-full h-[400px] shadow-lg bg-[#ffffff] rounded-2xl"></div>

       </div>
  </div>
  </template>

<script>
import Alert from '../../components/alert.vue'
import Header2 from '../../components/header2.vue'
import sidebarVue from '../../components/sidebar.vue'
import { useUserStore } from '../../stores/auth'
import { onMounted,ref,computed } from 'vue'
import { useRouter } from 'vue-router'

export default {
    name:"dashboard",
    components:{
      Alert,
      Header2,
      sidebarVue
   },
  setup() {
    const store = useUserStore();
    const currentUser = ref([]);
    const urlPath = window.location.origin;
    const router = useRouter();

    const getUsers = computed(() => {
      currentUser.value = store.userDetails
     return currentUser.value;
    });

    function setPageTitle(newTitle){
      if (document.title != newTitle) {
          document.title = ""
          document.title = import.meta.env.VITE_APP_NAME +' - '+ newTitle
      }
    }

    onMounted(() => {
      setPageTitle('Dashboard')
      if(store.getUserData())
      {
        currentUser.value = store.userDetails
        currentUser.value.length == 0 && localStorage.getItem("token") == undefined  ? router.push({ path:"/auth/login"}):"";
      }
    });

    return {currentUser,urlPath,getUsers}
    
  }
}
  </script>
