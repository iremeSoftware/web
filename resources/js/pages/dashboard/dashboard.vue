
<template >
  <div class="w-full flex" >
    <sidebarVue />
    <div class="md:w-5/6">
      <Header2 />
      <div class="pl-[4%] md:pl-[20%] pt-[22%] md:pt-[8%]">
        <h1 class="text-16px md:text-3xl font-semibold text-transparent bg-clip-text bg-gradient-to-l from-[#8fcc53] to-[#0171c0]">
          👋 Welcome to {{ schoolInfo.school_name }}
          </h1>
      </div>
      <div class="w-[99%] ml-4 md:ml-[20%] mt-6 mr-2 grid grid-cols-1 md:grid-cols-4 md:space-x-4 space-y-4 md:space-y-0">
          <div class="p-6 bg-white shadow rounded-2xl">
          <dl class="space-y-2">
            <dt class="flex text-sm font-medium text-gray-500">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
              </svg>
              <p class="mt-1 ml-2">Users</p>
            </dt>

            <dd class="text-5xl font-light md:text-6xl">20</dd>

            <dd class="flex items-center space-x-1 text-sm font-medium text-green-500">
                <span>32k increase</span>

                <svg class="w-7 h-7" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.25 15.25V6.75H8.75"></path>
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 7L6.75 17.25"></path>
                </svg>
            </dd>
         </dl>
        </div>
        <div class="p-6 bg-white shadow rounded-2xl">
        <dl class="space-y-2">
          <dt class="flex text-sm font-medium text-gray-500">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z" />
              </svg>
              <p class="mt-1 ml-2">Students</p>
            </dt>

            <dd class="text-5xl font-light md:text-6xl">200</dd>

            <dd class="flex items-center space-x-1 text-sm font-medium text-red-500">
                <span>7% increase</span>

                <svg class="w-7 h-7" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.25 8.75V17.25H8.75"></path>
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 17L6.75 6.75"></path>
                </svg>
            </dd>
         </dl>
      </div>
      <div class="p-6 bg-white shadow rounded-2xl">
        <dl class="space-y-2">
          <dt class="flex text-sm font-medium text-gray-500">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" class="w-6 h-6">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
            </svg>
              <p class="mt-1 ml-2">Courses</p>
          </dt>

            <dd class="text-5xl font-light md:text-6xl">15</dd>

            <dd class="flex items-center space-x-1 text-sm font-medium text-red-500">
                <span>7% increase</span>

                <svg class="w-7 h-7" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.25 8.75V17.25H8.75"></path>
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 17L6.75 6.75"></path>
                </svg>
            </dd>
         </dl>
      </div>
      <div class="p-6 bg-white shadow rounded-2xl">
        <dl class="space-y-2">
          <dt class="flex text-sm font-medium text-gray-500">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" class="w-6 h-6">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008z" />
            </svg>
              <p class="mt-1 ml-2">Classrooms</p>
          </dt>

          <dd class="text-5xl font-light md:text-6xl">20</dd>

            <dd class="flex items-center space-x-1 text-sm font-medium text-red-500">
                <span>7% increase</span>

                <svg class="w-7 h-7" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.25 8.75V17.25H8.75"></path>
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 17L6.75 6.75"></path>
                </svg>
            </dd>
         </dl>
      </div>
    </div>
      <div class="w-[99%] md:ml-[20%] mt-10 mr-2 p-3 w-full h-[400px] shadow-lg bg-[#ffffff] rounded-2xl">
        <Bar :data="data" :options="options" />
        
      </div>

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
import {setPageTitle} from '../../helpers/set_page_title'
import {
  Chart as ChartJS,
  Title,
  Tooltip,
  Legend,
  BarElement,
  CategoryScale,
  LinearScale
} from 'chart.js'
import { Bar } from 'vue-chartjs'

ChartJS.register(CategoryScale, LinearScale, BarElement, Title, Tooltip, Legend)

export default {
    name:"dashboard",
    components:{
      Alert,
      Header2,
      sidebarVue,
      Bar
   },
   data() {
    return {
      data: {
        labels: ['January', 'February', 'March','April'],
        datasets: [{ data: [40, 20, 12,30] }]
      },
      options: {
        responsive: true
      }
    }
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

    const schoolInfo = computed(() => {
      return store.demoSchoolInfo;
    });

    onMounted(() => {
      setPageTitle('Dashboard')
      if(store.getUserData() && store.current_school())
      {
        currentUser.value = store.userDetails
        currentUser.value.length == 0 && localStorage.getItem("token") == undefined  ? router.push({ path:"/auth/login"}):"";
      }
    });

    return {currentUser,urlPath,getUsers,schoolInfo}
    
  }
}
  </script>
