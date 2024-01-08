<template>
    <button class="text-sm pb-4 group ">
            <p class="flex"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" class="w-5 h-5">
  <path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 017.843 4.582M12 3a8.997 8.997 0 00-7.843 4.582m15.686 0A11.953 11.953 0 0112 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0121 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0112 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 013 12c0-1.605.42-3.113 1.157-4.418" />
    </svg>
    &nbsp;&nbsp;Change Language&nbsp;
<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" class="mt-[2px] w-4 h-4 group-hover:hidden">
  <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
</svg>

<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" class="mt-[2px] w-4 h-4  hidden group-hover:block">
  <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
</svg>
</p>
<div class="w-[200px] h-[80px] absolute bg-white rounded-2xl mt-4 ring-1 ring-[#0673c3] shadow-md group-hover:block hidden">
        <div class="w-4 h-4 bg-white rotate-45 -mt-2 ml-20 border-t-[1px] border-l-[1px] border-[#0673c3] ">
        </div>
        <div class="pt-2 space-y-2">
          <hr>
          <a href="#" class="text-sm">🇬🇧 English</a>
          <hr>
          <a href="#" class="text-sm">🇫🇷 French</a>
        </div>
</div>
</button>
</template>

<script>
export default {
  name:"ChangeLanguage",
  props: {
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
