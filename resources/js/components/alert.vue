<template>
    <div v-if="feedback" class="fixed md:left-[400px] top-20 w-full md:w-[500px] h-[80px] bg-white rounded-2xl shadow-2xl m-2">
        <span class="">
          <button class="md:ml-[480px] -mt-2 bg-white rounded-full" @click="closeFeedback"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
          <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg></button>
        </span>
        <div class=" text-[16px] pl-6 ">
         
          <p class="flex">

           <svg v-if="type == 'success'" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-green-700">
  <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>

    <svg v-if="type == 'danger'" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-red-700">
  <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
</svg>
  &nbsp; {{ message }}</p>
        </div>
      </div>
</template>

<script>
export default {
  name:"Alert",
  props: {
    feedback: Boolean,
    type:String,
    message: String,
    closeMethod: Function
  },
  components:{
},
  setup() {

   },
   methods:{
    closeFeedback() {
       this.closeMethod()
       }
   }
}
</script>
