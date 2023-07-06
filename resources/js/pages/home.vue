<template >
    <section id="home" class="w-full flex p-10" >
        <div class="w-full md:w-1/2 pt-32">
            <p class="text-[#0673c3] text-[40px] font-extrabold">Welcome to EasyFees - Simplifying School Fee Management </p>
            <p class="text-lg mt-10">Manage & Pay School Fees easily, Efficiently and Effectively with EasyFees</p>
            <div class="flex space-x-10 mt-10">
                <router-link to="/pay" >
                    <button class="w-[180px] md:w-[270px] h-10 text-sm md:text-lg rounded-xl text-center pl-4 text-[#0673c3]  ring-2 ring-[#0673c3] hover:scale-110 "><p class="flex md:pl-5"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-[#0673c3]">
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z" />
                </svg>
                &nbsp;&nbsp;Pay school fees</p>
                        </button>
                </router-link>

                <router-link to="/login">
                    <button class=" w-[180px] md:w-[270px] h-10 text-sm md:text-lg rounded-xl text-center ring-2 ring-[#0673c3] text-[#0673c3] hover:scale-110 "><p class="flex md:pl-5"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-[#0673c3]">
  <path stroke-linecap="round" stroke-linejoin="round" d="M19 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM4 19.235v-.11a6.375 6.375 0 0112.75 0v.109A12.318 12.318 0 0110.374 21c-2.331 0-4.512-.645-6.374-1.766z" />
</svg>

                &nbsp;&nbsp;Register your school</p></button>
                </router-link>
            </div>
           
        </div>
        <div class="w-1/2 hidden md:block" >
            <img src="../../../public/images/landing_page.png" />

        </div>
        
    </section>
    <section id="solutions" class="w-full flex pt-20 pl-10 pr-10 bg-white text-center" >
        <div class=" w-full text-center">
            <h1 class="text-[#0673c3] text-[40px]  font-extrabold pb-6">Solutions </h1>
            <h1 class="text-[#0673c3] text-[25px]  font-bold ">~ For Schools ~</h1>
            <div class="grid grid-cols-3 gap-4 mt-4">
            <div class="w-[300px] h-[300px] text-left">
                <div class="ml-20">
                  <img src="../../../public/images/icons8-graph-report-100.png" >
                </div>

                <p class="text-[#0673c3] text-[30px] "> Report generation </p>
                <p class="text-[18px] mt-3 "> The advanced analytics and report generation facility offers fee receipts, fee payment reports in real time etc.</p>

            </div> 
            <div class="w-[300px] h-[300px] text-left">
                <div class="ml-20">
                  <img src="../../../public/images/icons8-sms-100.png" >
                </div>

                <p class="text-[#0673c3] text-[30px] "> Notifications </p>
                <p class="text-[18px] mt-3 "> Fee management applications provide real-time notification in the form of SMS, email, push notifications etc. which keep the parents informed.</p>

            </div> 
            <div class="w-[300px] h-[300px] text-left">
                <div class="ml-20">
                  <img src="../../../public/images/icons8-money-100.png">
                </div>

                <p class="text-[#0673c3] text-[30px] "> Customize fee structure </p>
                <p class="text-[18px] mt-3 "> The system helps in customizing and setting up a fee structure according to your needs.</p>
            </div> 
            
        </div>
        <h1 class="text-[#0673c3] text-[25px]  font-bold pt-10 ">~ For Parents ~</h1>
        <div class="grid grid-cols-3 gap-4 mt-4">
            <div class="w-[300px] h-[300px] text-left">
                <div class="ml-20">
                  <img src="../../../public/images/icons8-run-100.png">
                </div>

                <p class="text-[#0673c3] text-[30px] "> Quick and hassle-free transactions </p>
                <p class="text-[18px] mt-3 "> Ensuring quick and hassle-free transactions for parents using our school fees management system, and without going to a bank or reporting bank slips.</p>
            </div> 

            <div class="w-[300px] h-[300px] text-left">
                <div class="ml-20">
                  <img src="../../../public/images/icons8-alarm-clock-100.png" >
                </div>

                <p class="text-[#0673c3] text-[30px] "> Real-time access </p>
                <p class="text-[18px] mt-3 "> Real-time access to fee details, payment history, and automated reminders to help parents stay organized and on top of their child's school fees.</p>

            </div> 
            
            <div class="w-[300px] h-[300px] text-left">
                <div class="ml-20">
                  <img src="../../../public/images/icons8-card-payment-100.png" >
                </div>

                <p class="text-[#0673c3] text-[30px] "> Multiple payment options </p>
                <p class="text-[18px] mt-3 "> Enjoy the convenience of multiple payment options, including online banking, mobile wallets, and USSD.</p>

            </div> 
            <div class="h-[100px]"></div>
           
            
        </div>
        </div>
    </section>
</template>
<script>
export default {
  name:"home",
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
