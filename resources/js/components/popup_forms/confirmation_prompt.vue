<template>
    <ModalPopUp height="100">
        <template v-slot:title>
            {{ popupDetails.popup_title }}
            </template>
            <template v-slot:contents>
                 <p class="text-lg">
                    {{ popupDetails.popup_message }}
                 </p>
            </template>
            <template v-slot:buttons>
    <button  class="w-full pl-[18%] md:pl-0 md:w-[30%] h-10 text-sm rounded-lg  font-semibold bg-[#000000]" @click="popupAction" ><p class="flex text-center text-white pl-[20%]">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
</svg>&nbsp;&nbsp;<font class='pt-[3px]'>Yes please!</font></p></button>
 </template>
</ModalPopUp>
</template>

<script>
import { useUserStore } from '../../stores/auth'
import ModalPopUp from './../ModalPopUp.vue'

export default {
    name:"confirmationPrompt",
    components:{
      ModalPopUp
    },
    props: {
        popupDetails:Map,
        popupAction:Function
    },
    setup() {
    const store = useUserStore();

    function logout(){
      if(store.logout())
      {
         localStorage.removeItem('token')
         window.location.href="/auth/login";
      }
    }
    return {logout}

  },
}
</script>