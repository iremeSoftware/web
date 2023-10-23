
<template >
  <div class="w-full flex" >
    <sidebarVue />
    <div class="w-full md:w-5/6">
      <Header2 />
      <div class="pl-2 md:pl-[20%] pt-[22%] md:pt-[8%]">
        <!-- <h1 class="text-16px md:text-3xl font-semibold text-transparent bg-clip-text bg-gradient-to-l from-[#8fcc53] to-[#0171c0]">
          👋 Welcome to {{ getUsers.school_name }}
          </h1> -->
          <p class="flex text-16px md:text-2xl font-semibold">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 mt-1">
                <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z" />
              </svg> &nbsp;&nbsp;Manage Students
          </p>
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
import { onMounted,ref,computed,watch } from 'vue'
import { useRouter,useRoute } from 'vue-router'

export default {
    name:"studentsPage",
    components:{
      Alert,
      Header2,
      sidebarVue
   },
  setup() {
    const store = useUserStore();
    const currentUser = ref([]);
    const urlPath = window.location.origin
    const router = useRouter()
    const route = useRoute()


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

    watch(route,() => {
      this.fullUrl = window.location.href;
     })

    onMounted(() => {
      setPageTitle('Students')
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
