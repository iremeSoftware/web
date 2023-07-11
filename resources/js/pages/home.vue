<template >
    <section id="home" class="w-full flex p-10" >
        <div class="w-full md:w-1/2 pt-32">
            <p class="text-[#0673c3] text-[40px] font-extrabold">Welcome to EasyFees - Simplifying School Fee Management </p>
            <p class="text-lg mt-10">Manage &amp; Pay School Fees easily, Efficiently and Effectively with EasyFees</p>
            <div class="flex space-x-10 mt-10">
                <router-link to="/pay" >
                    <button class="w-[180px] md:w-[270px] h-10 text-sm md:text-lg rounded-xl text-center pl-4 text-[#0673c3]  ring-2 ring-[#0673c3] hover:scale-110 "><p class="flex md:pl-5"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-[#0673c3]">
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z" />
                </svg>
                &nbsp;&nbsp;Pay school fees</p>
                        </button>
                </router-link>

                <router-link to="/registerSchool">
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
    <section id="solutions" class="w-full flex md:pt-20 pl-10 md:pl-20 md:pr-10 bg-white md:text-center" >
        <div class=" w-full md:text-center">
            <h1 class="text-[#0673c3] text-[40px]  font-extrabold pb-6">Solutions </h1>
            <h1 class="text-[#0673c3] text-[25px]  font-bold ">~ For Schools ~</h1>
            <div class="grid md:grid-cols-3 md:gap-44 mt-4">
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
        <div class="grid  md:grid-cols-3 gap-y-10 md:gap-44 mt-4">
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
            <br>
           
            
        </div>
        </div>
    </section>
    <section class="w-full  p-10 " id="help">
      <div class="pt-10"></div>
      <h1 class="text-[#0673c3] text-[40px] text-center  font-extrabold pb-10">FAQ &amp; Support </h1>
      <div class="md:flex">
         <div class="w-full md:w-1/2  m-4">
          <p class="text-[#0673c3] text-[30px] pb-6"> Frequently Asked Questions (FAQs) </p>

          <div class="w-full" v-for="(faq,i) in faqContents" :key="faq.header" @click="activeFaq(i)">
            <div class="w-full p-4 mt-4 rounded-xl bg-white shadow-lg cursor-pointer "  :class="faq.isActive ? 'h-56':''">
            <div class="flex " :class="faq.isActive ? 'border-b-2 pb-4':''">
              <p class="w-5/6 text-[17px] font-semibold mt-1 "> {{ faq.header }}</p>
              <span class="w-8 h-8 rounded-full ring-2 ring-[#0673c3] text-center pt-1 text-lg ml-10 ">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 pl-2 text-[#0673c3]  " :class="faq.isActive ? 'hidden':'block'">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                </svg>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 pl-2 text-[#0673c3] " :class="faq.isActive ? 'block':'hidden'">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m0 0l6.75-6.75M12 19.5l-6.75-6.75" />
              </svg>
              </span>
            </div>
            <p class="w-5/6 text-[14px] mt-3" :class="faq.isActive ? 'block':'hidden'" > {{ faq.contents }}</p>
          </div>
          </div>
          

         </div>
         <div class="w-full md:w-1/2 md:inline-flex pl-6">
          
          <div class="w-full">
            <p class="text-[#0673c3] text-[30px] pt-4"> Do you need support? </p>
            <div class="  w-full h-auto  p-4 mt-10 rounded-xl bg-white shadow-lg cursor-pointer">

              <p class=" pt-2 text-sm font-bold"> If you need personalized assistance or have specific inquiries, our support team is readily available to help.</p>
        <div class="pt-4 space-y-3">
          <p class="pt-2 text-sm font-semibold text-left">Names: <span class=" text-red-600" title="Required field">(*)</span></p>
          <input type='text' class='w-full h-9 ring-2 ring-[#f6f6f6] rounded-lg  placeholder:p-1 placeholder:font-light  enabled:p-2' placeholder='Enter your names here' v-model="formData[0].names.value" :class="formData[0].names.value =='' ? formData[0].names.required.className :''"/>
          <span class="w-full md:pl-[370px] text-red-600 text-xs" >{{formData[0].names.value =="" ? formData[0].names.required.value : ""}}</span>


          <p class="pt-2 text-sm font-semibold text-left">Email: <span class=" text-red-600" title="Required field">(*)</span></p>
          <input type='text' class='w-full h-9 ring-2 ring-[#f6f6f6] rounded-lg     placeholder:p-1 placeholder:font-light  enabled:p-2' placeholder='Enter your email here' v-model="formData[1].email.value" :class="formData[1].email.value =='' ? formData[1].email.required.className :''"/>
          <span class="w-full md:pl-[350px] text-red-600 text-xs" >{{formData[1].email.value =="" ? formData[1].email.required.value : ""}}</span>

          <p class="pt-2 text-sm font-semibold text-left">Select reason for reaching out:</p>
                      <select  v-model="reason"  class="w-full h-9 ring-2 ring-[#f6f6f6] rounded-lg enabled:p-2 enabled:font-light" id="exampleInputSchoolSector">
                      <option value=''>Select reason here:</option>
                      <option value="">Need to know more about the system</option>
                      <option value="">Need to be partner with us</option>
                      <option value="">Another reason</option>
                      </select>
          <p class="pt-2 text-sm font-semibold text-left">Describe your inquiry: <span class=" text-red-600" title="Required field">(*)</span></p>
          <textarea type='text' class='w-full h-24 ring-2 ring-[#f6f6f6] rounded-lg     placeholder:p-1  placeholder:font-light  enabled:p-2' v-model="formData[2].description.value" :class="formData[2].description.value =='' ? formData[2].description.required.className :''" placeholder="Briefly describe your inquiry here"></textarea>
          <span class="w-full md:pl-[350px] text-red-600 text-xs" >{{formData[2].description.value =="" ? formData[2].description.required.value : ""}}</span>
          <br><br>
      
        
          <button class="w-full h-10  text-sm rounded-lg  font-bold bg-[#0673c3]"><p class=" text-center text-white ">Submit your inquiry</p>

          </button>
         
        </div>

              </div>


          </div>

         </div>
      </div>
    </section>
    <section class="w-full  p-10 bg-[#0673c3] text-white" id="follow_us">
      <h1 class=" text-[40px] text-center  font-extrabold pb-10">Follow us</h1>
      <div class="flex  w-full space-x-2 pl-20 md:pl-[450px]">
        <a href="#" target="_blank" >
          <svg xmlns="http://www.w3.org/2000/svg"  viewBox="0 0 48 48" width="70px" height="70px"><path fill="#039be5" d="M24 5A19 19 0 1 0 24 43A19 19 0 1 0 24 5Z"/><path fill="#fff" d="M26.572,29.036h4.917l0.772-4.995h-5.69v-2.73c0-2.075,0.678-3.915,2.619-3.915h3.119v-4.359c-0.548-0.074-1.707-0.236-3.897-0.236c-4.573,0-7.254,2.415-7.254,7.917v3.323h-4.701v4.995h4.701v13.729C22.089,42.905,23.032,43,24,43c0.875,0,1.729-0.08,2.572-0.194V29.036z"/></svg>
        </a>
        <a href="#" target="_blank" >
          <svg xmlns="http://www.w3.org/2000/svg"  viewBox="0 0 48 48" width="70px" height="70px"><radialGradient id="yOrnnhliCrdS2gy~4tD8ma" cx="19.38" cy="42.035" r="44.899" gradientUnits="userSpaceOnUse"><stop offset="0" stop-color="#fd5"/><stop offset=".328" stop-color="#ff543f"/><stop offset=".348" stop-color="#fc5245"/><stop offset=".504" stop-color="#e64771"/><stop offset=".643" stop-color="#d53e91"/><stop offset=".761" stop-color="#cc39a4"/><stop offset=".841" stop-color="#c837ab"/></radialGradient><path fill="url(#yOrnnhliCrdS2gy~4tD8ma)" d="M34.017,41.99l-20,0.019c-4.4,0.004-8.003-3.592-8.008-7.992l-0.019-20	c-0.004-4.4,3.592-8.003,7.992-8.008l20-0.019c4.4-0.004,8.003,3.592,8.008,7.992l0.019,20	C42.014,38.383,38.417,41.986,34.017,41.99z"/><radialGradient id="yOrnnhliCrdS2gy~4tD8mb" cx="11.786" cy="5.54" r="29.813" gradientTransform="matrix(1 0 0 .6663 0 1.849)" gradientUnits="userSpaceOnUse"><stop offset="0" stop-color="#4168c9"/><stop offset=".999" stop-color="#4168c9" stop-opacity="0"/></radialGradient><path fill="url(#yOrnnhliCrdS2gy~4tD8mb)" d="M34.017,41.99l-20,0.019c-4.4,0.004-8.003-3.592-8.008-7.992l-0.019-20	c-0.004-4.4,3.592-8.003,7.992-8.008l20-0.019c4.4-0.004,8.003,3.592,8.008,7.992l0.019,20	C42.014,38.383,38.417,41.986,34.017,41.99z"/><path fill="#fff" d="M24,31c-3.859,0-7-3.14-7-7s3.141-7,7-7s7,3.14,7,7S27.859,31,24,31z M24,19c-2.757,0-5,2.243-5,5	s2.243,5,5,5s5-2.243,5-5S26.757,19,24,19z"/><circle cx="31.5" cy="16.5" r="1.5" fill="#fff"/><path fill="#fff" d="M30,37H18c-3.859,0-7-3.14-7-7V18c0-3.86,3.141-7,7-7h12c3.859,0,7,3.14,7,7v12	C37,33.86,33.859,37,30,37z M18,13c-2.757,0-5,2.243-5,5v12c0,2.757,2.243,5,5,5h12c2.757,0,5-2.243,5-5V18c0-2.757-2.243-5-5-5H18z"/></svg>
        </a>
        <a href="#" target="_blank" >
          <svg xmlns="http://www.w3.org/2000/svg"  viewBox="0 0 48 48" width="70px" height="70px"><linearGradient id="_osn9zIN2f6RhTsY8WhY4a" x1="10.341" x2="40.798" y1="8.312" y2="38.769" gradientUnits="userSpaceOnUse"><stop offset="0" stop-color="#2aa4f4"/><stop offset="1" stop-color="#007ad9"/></linearGradient><path fill="url(#_osn9zIN2f6RhTsY8WhY4a)" d="M46.105,11.02c-1.551,0.687-3.219,1.145-4.979,1.362c1.789-1.062,3.166-2.756,3.812-4.758	c-1.674,0.981-3.529,1.702-5.502,2.082C37.86,8.036,35.612,7,33.122,7c-4.783,0-8.661,3.843-8.661,8.582	c0,0.671,0.079,1.324,0.226,1.958c-7.196-0.361-13.579-3.782-17.849-8.974c-0.75,1.269-1.172,2.754-1.172,4.322	c0,2.979,1.525,5.602,3.851,7.147c-1.42-0.043-2.756-0.438-3.926-1.072c0,0.026,0,0.064,0,0.101c0,4.163,2.986,7.63,6.944,8.419	c-0.723,0.198-1.488,0.308-2.276,0.308c-0.559,0-1.104-0.063-1.632-0.158c1.102,3.402,4.299,5.889,8.087,5.963	c-2.964,2.298-6.697,3.674-10.756,3.674c-0.701,0-1.387-0.04-2.065-0.122C7.73,39.577,12.283,41,17.171,41	c15.927,0,24.641-13.079,24.641-24.426c0-0.372-0.012-0.742-0.029-1.108C43.483,14.265,44.948,12.751,46.105,11.02"/></svg>
        </a>
        <a href="#" target="_blank" >
          <svg xmlns="http://www.w3.org/2000/svg"  viewBox="0 0 48 48" width="70px" height="70px"><path fill="#FF3D00" d="M43.2,33.9c-0.4,2.1-2.1,3.7-4.2,4c-3.3,0.5-8.8,1.1-15,1.1c-6.1,0-11.6-0.6-15-1.1c-2.1-0.3-3.8-1.9-4.2-4C4.4,31.6,4,28.2,4,24c0-4.2,0.4-7.6,0.8-9.9c0.4-2.1,2.1-3.7,4.2-4C12.3,9.6,17.8,9,24,9c6.2,0,11.6,0.6,15,1.1c2.1,0.3,3.8,1.9,4.2,4c0.4,2.3,0.9,5.7,0.9,9.9C44,28.2,43.6,31.6,43.2,33.9z"/><path fill="#FFF" d="M20 31L20 17 32 24z"/></svg>
        </a>
      </div>

    </section>

</template>
<script>
export default {
  name:"home",
  components:{
},
data: () => ({
        faqContents:[
          {
            "header":"How does the school fees management system work?",
            "isActive":false,
            "contents":"Our school fees management system simplifies the process of collecting and managing school fees. It provides an online platform where parents can conveniently make payments, view fee details, and receive payment receipts. Schools can easily track and reconcile payments, generate reports, and streamline their fee collection process."
          },
          {
            "header":"Is the school fees management system secure?",
            "isActive":false,
            "contents":"Yes, we prioritize the security of your data and transactions. Our school fees management system employs industry-standard security measures to protect sensitive information. We utilize encryption protocols, secure servers, and regularly update our security systems to ensure the confidentiality, integrity of your data and the whole payment process."
          },
          {
            "header":"How can I access the school fees management system?",
            "isActive":false,
            "contents":"To access the system, you can visit our website and log in using your unique parent account credentials. Once logged in, you will have access to your child's fee details, payment history, and the option to make online payments."
          },
          {
            "header":"Can I view and download fee receipts and statements?",
            "isActive":false,
            "contents":"Yes, our school fees management system provides the option to view and download fee receipts and statements. You can easily access and download these documents from your parent account, allowing you to keep track of your payment records and financial history."
          },
          {
            "header":"Is the school fees management system compatible with mobile devices?",
            "isActive":false,
            "contents":"Yes, our system is designed to be mobile-friendly, allowing you to access and use it seamlessly on various devices, including smartphones and tablets. You can conveniently manage your child's fees, make payments, and view important information on the go."
          },
          {
            "header":"What if I encounter any issues or have further questions?",
            "isActive":false,
            "contents":"If you encounter any issues or have additional questions about the school fees management system, our dedicated support team is available to assist you. You can reach out to our support staff through the contact information provided on our website, and they will be happy to address any concerns or queries you may have."
          }
        ],
        formData:[
    {
      names:{
      required:{
        isRequired:true,
        className:"ring-1 ring-red-500",
        value:"Your names are required"
      },
      value:""
    }
    },
    {
      email:{
      required:{
        isRequired:true,
        className:"ring-1 ring-red-500",
        value:"Your email address is required"
      },
      value:""
    }
    },
    {
      description:{
      required:{
        isRequired:true,
        className:"ring-1 ring-red-500",
        value:"Your description is required"
      },
      value:""
    }
    }
  ],
        reason:""
      }),
      mounted () {
        },
    created() {
      },
    methods: {
      activeFaq(i){
         this.faqContents[i].isActive =! this.faqContents[i].isActive;
      },
    },
}
</script>
