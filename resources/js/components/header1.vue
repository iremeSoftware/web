<template>
  <div class="w-full fixed block md:hidden text-center h-10  mt-0 pl-[33%] bg-[#ffffff]">
    <img class="w-[80px] h-[40px]" src="https://www.iremeapp.com/logo/logo.png" />
  </div>
    <div class=" w-full  pt-3 md:pl-14 flex fixed top-10 md:top-0  bg-[#ffffff] shadow-lg z-10 ">
        <div class=" w-1/12 ">
            <router-link to="/" href="#home" v-smooth-scroll class="hidden pb-2 md:block">
                <img class=" w-[80px] h-[40px] " src="https://www.iremeapp.com/logo/logo.png" />
            </router-link>
            <button class="block p-2 md:hidden " @click="showMenu()">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" class="w-6 h-6" :class="isShow ? 'hidden':'block'">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 9h16.5m-16.5 6.75h16.5" />
                </svg>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" class="w-6 h-6" :class="isShow ? 'block':'hidden'">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
              </button>
        </div>
        

        <div class="w-7/12 space-x-3 pt-4  hidden md:block ">
            <router-link to="/"  href="#home" v-smooth-scroll>
            <button  class="text-sm pb-4 hover:text-[#0673c3]" :class="fullUrl.split('#')[1] == 'home'?'text-[#0673c3]':''"><p class="flex"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" class="w-5 h-5">
  <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
</svg>


&nbsp;&nbsp;Home</p>
          </button>
          </router-link>

            <router-link to="/" href="#solutions" v-smooth-scroll >
            <button class="text-sm pb-4 hover:text-[#0673c3]"  :class="fullUrl.split('#')[1] == 'solutions'?'text-[#0673c3]':''"><p class="flex">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" class="w-5 h-5">
  <path stroke-linecap="round" stroke-linejoin="round" d="M21 11.25v8.25a1.5 1.5 0 01-1.5 1.5H5.25a1.5 1.5 0 01-1.5-1.5v-8.25M12 4.875A2.625 2.625 0 109.375 7.5H12m0-2.625V7.5m0-2.625A2.625 2.625 0 1114.625 7.5H12m0 0V21m-8.625-9.75h18c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125h-18c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
</svg>



&nbsp;&nbsp;Our services </p>
          </button>
          </router-link>
        

          <router-link to="/" href="#help" v-smooth-scroll>
            <button class="text-sm pb-4 hover:text-[#0673c3]"  :class="fullUrl.split('#')[1] == 'help'?'text-[#0673c3]':''"><p class="flex">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" class="w-5 h-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
              </svg>
&nbsp;&nbsp;Help & Support</p>
          </button>
          </router-link>

          <router-link to="/" href="#pricing" v-smooth-scroll>
            <button class="text-sm pb-4 hover:text-[#0673c3]"  :class="fullUrl.split('#')[1] == 'help'?'text-[#0673c3]':''"><p class="flex">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" class="w-5 h-5">
  <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z" />
</svg>


&nbsp;&nbsp;Pricing</p>
          </button>
          </router-link>
          <router-link to="/" href="#how_it_works" v-smooth-scroll>
            <button class="text-sm pb-4 hover:text-[#0673c3]"  :class="fullUrl.split('#')[1] == 'help'?'text-[#0673c3]':''"><p class="flex">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" class="w-5 h-5">
  <path stroke-linecap="round" stroke-linejoin="round" d="M6 20.25h12m-7.5-3v3m3-3v3m-10.125-3h17.25c.621 0 1.125-.504 1.125-1.125V4.875c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125z" />
</svg>



&nbsp;&nbsp;How it works</p>
          </button>
          </router-link>
          

  <!-- <button class="text-sm pb-4 hover:text-[#0673c3] group ">
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
<div class="w-[200px] h-[100px] absolute bg-white rounded-2xl mt-4 ring-1 ring-[#0673c3] shadow-md group-hover:block hidden">
        <div class="w-4 h-4 bg-white rotate-45 -mt-2 ml-20 border-t-[1px] border-l-[1px] border-[#0673c3] ">
        </div>
        <div class="pt-2 space-y-2">
          <hr>
          <a href="#" class="text-sm">🇬🇧 English</a>
          <hr>
          <a href="#" class="text-sm">🇫🇷 French</a>
          <hr>
          <a href="#" class="text-sm">🇷🇼 Kinyarwanda</a>
        </div>
</div>
</button> -->
        </div>
        <!-- <div class="w-2/12 md:hidden"></div> -->
        <div class="flex space-x-2 md:pl-8">    
            <router-link to="/auth/registration_request"  >
    <button class="h-12 text-sm rounded-lg text-center pl-4 ml-10 w-[150px]"><p class="flex"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" class="w-5 h-5">
  <path stroke-linecap="round" stroke-linejoin="round" d="M19 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM4 19.235v-.11a6.375 6.375 0 0112.75 0v.109A12.318 12.318 0 0110.374 21c-2.331 0-4.512-.645-6.374-1.766z" />
</svg>&nbsp;&nbsp;Register school</p>
          </button>
</router-link>

<div class="border-l-[2px]"></div>

<router-link to="/auth/login">
    <button class="w-[120px] h-8 text-sm rounded-lg text-center bg-[#000000] text-white ml-4 mt-2"><p class="flex pl-5"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" class="w-5 h-5">
  <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
</svg>
&nbsp;&nbsp;Login</p></button>
</router-link></div>
        

      </div>

      <!-- MOBILE SIDEBAR-->
      
      <div class="fixed flex w-full h-full bg-black bg-opacity-40   left-0 top-14 z-0   text-lg text-white" :class="isShow ? 'block': 'hidden'">

        <div class=" w-1/2 h-full pl-8 pt-16  bg-[#0673c3]  rounded-r-xl shadow-xl text-lg text-white " :class="isShow ? 'block': 'hidden'">

          <router-link to="/"  href="#home" v-smooth-scroll>
            <button  class="w-full text-sm pb-4 " :class="fullUrl.split('#')[1] == 'home'?'text-[#ffffff]':''"><p class="flex"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" class="w-5 h-5">
  <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
</svg>


&nbsp;&nbsp;Home</p>
          </button>
          </router-link>

            <router-link to="/" href="#solutions" v-smooth-scroll >
            <button class="w-full text-sm pb-4 "  :class="fullUrl.split('#')[1] == 'solutions'?'text-[#ffffff]':''"><p class="flex"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" class="w-5 h-5">
  <path stroke-linecap="round" stroke-linejoin="round" d="M15.59 14.37a6 6 0 01-5.84 7.38v-4.8m5.84-2.58a14.98 14.98 0 006.16-12.12A14.98 14.98 0 009.631 8.41m5.96 5.96a14.926 14.926 0 01-5.841 2.58m-.119-8.54a6 6 0 00-7.381 5.84h4.8m2.581-5.84a14.927 14.927 0 00-2.58 5.84m2.699 2.7c-.103.021-.207.041-.311.06a15.09 15.09 0 01-2.448-2.448 14.9 14.9 0 01.06-.312m-2.24 2.39a4.493 4.493 0 00-1.757 4.306 4.493 4.493 0 004.306-1.758M16.5 9a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z" />
</svg>


&nbsp;&nbsp;Our services </p>
          </button>
          </router-link>
        

          <router-link to="/" href="#help" v-smooth-scroll>
            <button class="w-full text-sm pb-4 "  :class="fullUrl.split('#')[1] == 'help'?'text-[#ffffff]':''"><p class="flex">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" class="w-5 h-5">
  <path stroke-linecap="round" stroke-linejoin="round" d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9 5.25h.008v.008H12v-.008z" />
</svg>

&nbsp;&nbsp;Help & Support</p>
          </button>
          </router-link>

          <router-link to="/" href="#pricing" v-smooth-scroll>
            <button class="w-full text-sm pb-4 "  :class="fullUrl.split('#')[1] == 'help'?'text-[#ffffff]':''"><p class="flex">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" class="w-5 h-5">
  <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z" />
</svg>


&nbsp;&nbsp;Pricing</p>
          </button>
          </router-link>
          <router-link to="/" href="#how_it_works" v-smooth-scroll>
            <button class="w-full text-sm pb-4 "  :class="fullUrl.split('#')[1] == 'help'?'text-[#ffffff]':''"><p class="flex">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" class="w-5 h-5">
  <path stroke-linecap="round" stroke-linejoin="round" d="M6 20.25h12m-7.5-3v3m3-3v3m-10.125-3h17.25c.621 0 1.125-.504 1.125-1.125V4.875c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125z" />
</svg>



&nbsp;&nbsp;How it works</p>
          </button>
          </router-link>
</div>
<div class="w-1/2 " @click="showMenu()">
</div>




      </div>
  <!-- // MOBILE SIDEBAR-->
</template>
<script>

  export default {
    name: 'header1',
    components:{
    
    },
    data: () => ({
        fullUrl:"",
        windowTop:0,
        isShow:false
      }),
      watch:{
    '$route' (){
      this.fullUrl = window.location.href;
      }
     },
      mounted () {
        window.addEventListener("scroll", this.onScroll);
      },
  created() {
    },
  methods: {
    onScroll(e) {
    this.windowTop = window.top.scrollY ;
    if(this.fullUrl.includes("#") || this.fullUrl.split('/')[3]=='')
    {
    if(this.windowTop == 0 && this.windowTop<692 )
    {
      this.$router.push({
        path:"/",
        hash:"#home"
      })
    }
    else if(this.windowTop > 725 && this.windowTop<1330 )
    {
      this.$router.push({
        path:"/",
        hash:"#solutions"
      })
    }
    else if(this.windowTop > 1359)
    {
      this.$router.push({
        path:"/",
        hash:"#help"
      })
    }
  }
  },

  showMenu()
  {
     this.isShow =! this.isShow;
  }
  },

  }
  </script>