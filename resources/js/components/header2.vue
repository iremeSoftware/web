<template>
    <div class="w-full md:w-[85%] h-16 shadow-md bg-white fixed md:ml-[15%] ">
        <div class="flex pl-2 md:pl-10 pt-4">
          <p class="hidden md:block text-[17px] font-semibold">Dashboard</p>
          <div class="text-left">
            <button class="block md:hidden" @click="showLeftMenu()">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
              <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
            </svg>
          </button>
          </div>

          <div class="w-full text-right space-x-4 pr-2">
            <button class=" h-8 w-8 text-center pl-2"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" class="w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
          </svg>
          </button>

            <button class=" h-8 w-8  text-center pl-2" @click="toggleNotification()">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" class="w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
            </svg>
          <span class="absolute bg-red-500 -mt-6 ml-[1px] h-3 w-3 rounded-full text-[8px] text-white">2</span>
          </button>

          
    <button class="w-[150px] h-8 text-sm rounded-lg text-white bg-[#000000]"><p class="flex pl-2 pt-1"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" class="w-6 h-6 pb-1">
  <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
</svg>Invite new user</p></button>

<div class="border-l-[2px]"></div>


          </div>

        </div>
      <div class="z-10 absolute md:ml-[59%] mt-2  w-full md:w-[40%] h-[300px] rounded-xl bg-[#ffffff] border-[2px] border-[#0673c3]  shadow-2xl" :class="notification==true?'block':'hidden'">
          <div class="hidden md:block z-20 w-4 h-4 bg-[#ffffff]  rotate-45 -mt-2 ml-[69%] border-t-[2px] border-l-[2px] border-[#0673c3] "></div>
        </div>
        

      </div>


</template>

<script>

import { ref,computed,onMounted } from 'vue';
import { useRouter } from 'vue-router';
import { useUserStore } from '../stores/auth'



export default{
    name:"Header2",
    setup() {

      const notification = ref(false)
      const store = useUserStore();
      const isMenuClicked = ref(false);



      function showLeftMenu(){
        isMenuClicked.value =! isMenuClicked.value
        return store.isLeftMenuSelected(isMenuClicked.value)         
      }

      function toggleNotification(){
          notification.value =! notification.value
      }

      return {toggleNotification,notification,showLeftMenu,isMenuClicked}
        
    },
}
</script>
