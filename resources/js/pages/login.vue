<template >
      <div class="w-[100px]">&nbsp;</div>
      <div class=" w-[400px] bg-white p-8  rounded-3xl mt-[90px] ml-14 md:ml-[450px] text-center shadow-lg">
        <p class=" text-lg font-bold"> User Login</p>
        <p class=" pt-2 text-sm font-light"> Are you already registered? please login to use the system</p>
        <div class="pt-4 space-y-3">
          <p class="pt-2 text-sm font-bold text-left">Email:</p>
          <input type='text' className='w-[330px] h-9 ring-1 ring-[#f6f6f6] rounded-lg     placeholder:p-1 placeholder:font-light  enabled:p-2' placeholder='Enter Email'/>
          <p class="pt-2 text-sm font-bold text-left">Password:</p>
          <input type='password' className='w-[330px] h-9 ring-1 ring-[#f6f6f6] rounded-lg    placeholder:p-1 placeholder:font-light  enabled:p-2' placeholder='Enter Password'/>
          <p class=" pt-4 pb-3 text-sm font-light text-left"> Having trouble in sign in? <router-link to="/resetPassword"><a href="#" class=" text-sm font-bold  hover:text-[#0673c3]">Reset Password </a></router-link></p>
        
          <button class="w-[330px] h-10 text-sm rounded-lg  font-semibold bg-[#0673c3]"><p class="flex text-center text-white pl-[130px]">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
  <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
</svg>&nbsp;&nbsp;Sign in</p>

          </button>
         
        </div>
      </div>
      <div class="h-[40px]">&nbsp;</div>
    
  </template>
  <script>
  export default {
    name:"login",
    components:{
  },
    setup() {
  
     }
  }
  </script>
  <style>
  @font-face {
    font-family: 'Rubik';
    src:  url("../../public/fonts/Rubik/Rubik-VariableFont_wght.ttf") format('truetype');
  }
</style>
