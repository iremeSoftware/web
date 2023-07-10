<template >
      <div class="w-[100px]">&nbsp;</div>
      <div class=" w-[400px] bg-white pl-8 pt-4 pr-8 pb-4  rounded-3xl mt-[90px] ml-14 md:ml-[450px] text-center shadow-lg">
        <p class=" text-lg font-bold"> Forgot Password?</p>
        <p class=" pt-2 text-sm font-light"> Just enter your email address below and we'll send you a link to reset your password!</p>
        <div class="pt-4 pb-8 space-y-3">
          <p class="pt-2 text-sm font-bold text-left">Email:</p>
          <input type='email' className='w-[330px] h-9 ring-1 ring-[#f6f6f6] rounded-lg     placeholder:p-1 placeholder:font-light  enabled:p-2' placeholder='Enter Email'/>
          

          <button class="w-[330px] h-10 text-sm rounded-lg  font-semibold bg-[#0673c3]"><p class="flex text-center text-white pl-24">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
  <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 5.25a3 3 0 013 3m3 0a6 6 0 01-7.029 5.912c-.563-.097-1.159.026-1.563.43L10.5 17.25H8.25v2.25H6v2.25H2.25v-2.818c0-.597.237-1.17.659-1.591l6.499-6.499c.404-.404.527-1 .43-1.563A6 6 0 1121.75 8.25z" />
</svg>
&nbsp;&nbsp;Reset Password</p>

          </button>
        </div>
      </div>
      <div class="h-[40px]">&nbsp;</div>
    
  </template>
  <script>
  export default {
    name:"resetPassword",
    components:{
  },
    setup() {
  
     }
  }
  </script>
