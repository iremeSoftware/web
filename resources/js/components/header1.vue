<template>
    <div class=" w-full pt-3 md:pl-14 flex fixed top-0  bg-[#ffffff] shadow-md z-10 ">
        <div class=" w-2/12 ">
            <router-link to="/" href="#home" v-smooth-scroll class="hidden pb-2 md:block">
                <img class=" w-[80px] h-[40px] " src="https://www.iremeapp.com/logo/logo.png" />
            </router-link>
            <button class="block p-2 md:hidden " @click="showMenu()"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6" :class="isShow ? 'hidden':'block'">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 9h16.5m-16.5 6.75h16.5" />
                </svg>

                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6" :class="isShow ? 'block':'hidden'">
  <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
</svg>

              
              </button>
        </div>
        

        <div class="w-8/12 pl-[180px] space-x-3 pt-2  hidden md:block ">
            <router-link to="/"  href="#home" v-smooth-scroll>
            <button @click="showMenu()" class="text-sm pb-4 hover:text-[#0673c3]" :class="fullUrl.split('#')[1] == 'home'?'text-[#0673c3]':''"><p class="flex"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
  <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
</svg>


&nbsp;&nbsp;Home</p>
          </button>
          </router-link>

            <router-link to="/" href="#solutions" v-smooth-scroll >
            <button class="text-sm pb-4 hover:text-[#0673c3]"  :class="fullUrl.split('#')[1] == 'solutions'?'text-[#0673c3]':''"><p class="flex"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
  <path stroke-linecap="round" stroke-linejoin="round" d="M15.59 14.37a6 6 0 01-5.84 7.38v-4.8m5.84-2.58a14.98 14.98 0 006.16-12.12A14.98 14.98 0 009.631 8.41m5.96 5.96a14.926 14.926 0 01-5.841 2.58m-.119-8.54a6 6 0 00-7.381 5.84h4.8m2.581-5.84a14.927 14.927 0 00-2.58 5.84m2.699 2.7c-.103.021-.207.041-.311.06a15.09 15.09 0 01-2.448-2.448 14.9 14.9 0 01.06-.312m-2.24 2.39a4.493 4.493 0 00-1.757 4.306 4.493 4.493 0 004.306-1.758M16.5 9a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z" />
</svg>


&nbsp;&nbsp;Solutions </p>
          </button>
          </router-link>
        

          <router-link to="/" href="#help" v-smooth-scroll>
            <button class="text-sm pb-4 hover:text-[#0673c3]"  :class="fullUrl.split('#')[1] == 'help'?'text-[#0673c3]':''"><p class="flex">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
  <path stroke-linecap="round" stroke-linejoin="round" d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9 5.25h.008v.008H12v-.008z" />
</svg>

&nbsp;&nbsp;FAQ & Support</p>
          </button>
          </router-link>
          

  <button class="text-sm pb-4 hover:text-[#0673c3] group ">
            <p class="flex"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
  <path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 017.843 4.582M12 3a8.997 8.997 0 00-7.843 4.582m15.686 0A11.953 11.953 0 0112 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0121 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0112 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 013 12c0-1.605.42-3.113 1.157-4.418" />
    </svg>
    &nbsp;&nbsp;Change Language&nbsp;
<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="mt-[2px] w-4 h-4 group-hover:hidden">
  <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
</svg>

<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="mt-[2px] w-4 h-4  hidden group-hover:block">
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
</button>


        </div>
        <div class="flex w-4/12 space-x-2 pl-32 md:pl-10">    
            <router-link to="/pay"  >
    <button class="w-40 h-8 text-sm rounded-lg text-center pl-4 bg-[#0673c3] text-white "><p class="flex"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-white">
  <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z" />
</svg>


&nbsp;&nbsp;Pay School fees</p>
          </button>
</router-link>

<router-link to="/login">
    <button class="w-28 h-8 text-sm rounded-lg text-center  bg-[#5fce80] "><p class="flex pl-5"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
  <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
</svg>
&nbsp;&nbsp;Login</p></button>
</router-link></div>
        

      </div>

      <!-- MOBILE SIDEBAR-->
      
      <div class="fixed flex w-full h-full bg-black bg-opacity-40   left-0 top-12 z-0   text-lg text-white" :class="isShow ? 'block': 'hidden'">

        <div class=" w-1/2 h-full p-8 bg-[#0673c3]  rounded-r-xl shadow-xl text-lg text-white " :class="isShow ? 'block': 'hidden'">

        <router-link to="/" href="#home" v-smooth-scroll>
            <button class=" pb-8"><p class="flex"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
</svg>&nbsp;&nbsp;Home</p>
          </button>
          </router-link>
           <br>
          <router-link to="/" href="#solutions" v-smooth-scroll >
            <button class="" ><p class="flex"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M15.59 14.37a6 6 0 01-5.84 7.38v-4.8m5.84-2.58a14.98 14.98 0 006.16-12.12A14.98 14.98 0 009.631 8.41m5.96 5.96a14.926 14.926 0 01-5.841 2.58m-.119-8.54a6 6 0 00-7.381 5.84h4.8m2.581-5.84a14.927 14.927 0 00-2.58 5.84m2.699 2.7c-.103.021-.207.041-.311.06a15.09 15.09 0 01-2.448-2.448 14.9 14.9 0 01.06-.312m-2.24 2.39a4.493 4.493 0 00-1.757 4.306 4.493 4.493 0 004.306-1.758M16.5 9a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z" />
</svg>


&nbsp;&nbsp;Solutions </p>
          </button>
          </router-link>
          <br>

          <router-link to="/" href="#help" v-smooth-scroll>
            <button class="pt-8"><p class="flex">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9 5.25h.008v.008H12v-.008z" />
</svg>

&nbsp;&nbsp;FAQ & Support</p>
          </button>
          </router-link>
<br><br>
          <button class="text-[14px] pb-4 group ">
            <p class="flex"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 017.843 4.582M12 3a8.997 8.997 0 00-7.843 4.582m15.686 0A11.953 11.953 0 0112 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0121 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0112 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 013 12c0-1.605.42-3.113 1.157-4.418" />
    </svg>
    &nbsp;&nbsp;Change Language&nbsp;
<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="mt-[6px] w-4 h-4 group-hover:hidden">
  <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
</svg>

<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="mt-[2px] w-4 h-4  hidden group-hover:block">
  <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
</svg>
</p>
<div class="w-[200px] h-[120px] absolute bg-white rounded-2xl mt-4 ring-1 ring-[#0673c3] text-black shadow-md group-hover:block hidden">
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
</button>
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
    if(this.windowTop == 0 && this.windowTop<479 )
    {
      this.$router.push({
        path:"/",
        hash:"#home"
      })
    }
    else if(this.windowTop > 579 && this.windowTop<1488.5 )
    {
      this.$router.push({
        path:"/",
        hash:"#solutions"
      })
    }
    else if(this.windowTop > 1651)
    {
      this.$router.push({
        path:"/",
        hash:"#help"
      })
    }


    console.log(this.windowTop);
  }
  },

  showMenu()
  {
    
     this.isShow =! this.isShow;
  }
  },

  }
  </script>