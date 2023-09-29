<template >
  <section id="home" class="flex p-10 text-center pt-24">
    <div class=" w-full flex md:text-center">
      <div class="w-1/5"></div>
      <div class="w-3/5">
    <h1 class="text-6xl font-semibold text-transparent bg-clip-text bg-gradient-to-l from-[#8fcc53] to-[#0171c0]">
      Your school in the palm of your hand
    </h1>
    <p class="text-[18px] pt-5">The first fully online school management software in Rwanda with amazing features to more easily manage your school</p>
    <div class="flex text-center pl-36 pt-3">   
      
      
  <router-link to="/registerSchool">
    <button class="h-10 text-[16px] rounded-lg text-center pl-4 ml-24 w-auto bg-[#000000] text-white ml-4 mt-2 z-10 "><p class="flex"> Try it free for 1 month! 👌&nbsp;&nbsp;<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12h15m0 0l-6.75-6.75M19.5 12l-6.75 6.75" />
</svg>&nbsp;&nbsp;</p></button>
</router-link>

<router-link to="/login"  >
<button class="h-10 text-[16px] rounded-lg text-center pl-4 ml-24 w-auto bg-[#000000] text-white ml-4 mt-2 z-10 "><p class="flex"> Already have an account? Login&nbsp;&nbsp;</p></button>
</router-link>
</div>
            <img class="pl-24 z-0 -mt-5" src="../../../public/images/home.png" />
    </div>
    <div class="w-1/5 "></div>

  </div>
  </section>
 
    <section id="solutions" class="w-full flex md:pt-10 pl-10 pb-10 md:pl-20 md:pr-10 bg-white md:text-center" >
        <div class=" w-full md:text-center">
            <h1 class="text-[#0673c3] text-[40px] text-transparent bg-clip-text bg-gradient-to-l from-[#8fcc53] to-[#0171c0] font-extrabold pb-6">Our services </h1>
            <p class="text-[18px]">Ireme, the powerful online school management system, includes an incredible set of customizable features to help you with your school administration tasks and complex processes.</p>
            <div class="grid md:grid-cols-4 md:gap-x-10 md:gap-y-16 mt-10">
            <div class="w-[310px] h-auto text-left bg-[#f5f8fa] rounded-xl p-4 shadow-md text-center ">
                <div class="ml-20">
                  <img src="../../../public/images/report_form.png" class="w-[100px] h-[100px]" >
                </div>
                <div class="pt-4 ">
                  <p class="h-10 text-black text-[20px] font-bold "> Report form generator </p>
                  <p class="h-[150px] text-[15px] mt-3 "> This system helps the school to automatically generate the student report form without requiring teachers to provide student grades, just click the print 'button'.</p>
                    <router-link to="/registerSchool">
                        <button class="h-8 text-[16px] rounded-lg text-center pl-4 ml-24 w-auto bg-[#000000] text-white ml-4 mt-2 z-10 "><p class="flex"> Learn more <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12h15m0 0l-6.75-6.75M19.5 12l-6.75 6.75" />
                    </svg>&nbsp;&nbsp;</p></button>
                    </router-link>
                </div>
                
            </div>   
            <div class="w-[310px] h-auto text-left bg-[#f5f8fa] rounded-xl p-4 shadow-md text-center ">
                <div class="ml-20">
                  <img src="../../../public/images/marking.png" class="w-[130px] h-[100px]" >
                </div>
                <div class="pt-4 ">
                  <p class="h-10 text-black text-[20px] font-bold "> Grade management system </p>
                  <p class="h-[150px] text-[15px] mt-3 "> This system allows teachers to store and edit assessment and exam scores, which helps in automatically generating the student's progressive report form.</p>
                    <router-link to="/registerSchool">
                        <button class="h-8 text-[16px] rounded-lg text-center pl-4 ml-24 w-auto bg-[#000000] text-white ml-4 mt-2 z-10 "><p class="flex"> Learn more <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12h15m0 0l-6.75-6.75M19.5 12l-6.75 6.75" />
                    </svg>&nbsp;&nbsp;</p></button>
                    </router-link>
                </div>
                
            </div> 
            <div class="w-[310px] h-auto text-left bg-[#f5f8fa] rounded-xl p-4 shadow-md text-center ">
                <div class="ml-20">
                  <img src="../../../public/images/attendance.png" class="w-[100px] h-[100px]" >
                </div>
                <div class="pt-4 ">
                  <p class="h-14 text-black text-[20px] font-bold "> Student attendance system </p>
                  <p class="h-[140px] text-[15px] mt-3 "> This system enables the schools to record student attendance on a daily basis and generate a monthly report.</p>
                    <router-link to="/registerSchool">
                        <button class="h-8 text-[16px] rounded-lg text-center pl-4 ml-24 w-auto bg-[#000000] text-white ml-4 mt-2 z-10 "><p class="flex"> Learn more <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12h15m0 0l-6.75-6.75M19.5 12l-6.75 6.75" />
                    </svg>&nbsp;&nbsp;</p></button>
                    </router-link>
                </div>
                
            </div> 
            <div class="w-[300px] h-auto text-left bg-[#f5f8fa] rounded-xl p-4 shadow-md text-center ">
                <div class="ml-20">
                  <img src="../../../public/images/storage.png" class="w-[100px] h-[100px]" >
                </div>
                <div class="pt-4 ">
                  <p class="h-10 text-black text-[20px] font-bold ">School Cloud Storage</p>
                  <p class="h-[150px] text-[15px] mt-3 "> This system enables the school to upload and access their files in the cloud at any time and from any location.</p>
                    <router-link to="/registerSchool">
                        <button class="h-8 text-[16px] rounded-lg text-center pl-4 ml-24 w-auto bg-[#000000] text-white ml-4 mt-2 z-10 "><p class="flex"> Learn more <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12h15m0 0l-6.75-6.75M19.5 12l-6.75 6.75" />
                    </svg>&nbsp;&nbsp;</p></button>
                    </router-link>
                </div>
                
            </div> 
        </div>
        </div>
    </section>
    <section class="w-full  p-10 " id="help">
      <div class="pt-10"></div>
      <h1 class="text-[#0673c3] text-[40px] text-center text-transparent bg-clip-text bg-gradient-to-l from-[#8fcc53] to-[#0171c0]  font-extrabold pb-10">FAQ &amp; Support </h1>
      <div class="md:flex">
         <div class="w-full md:w-1/2  m-4">
          <p class="text-[#000000] text-[30px] pb-6"> Frequently Asked Questions (FAQs) </p>

          <div class="w-full" v-for="(faq,i) in faqContents" :key="faq.header" @click="activeFaq(i)">
            <div class="w-full p-4 mt-4 rounded-xl bg-white shadow-lg cursor-pointer "  :class="faq.isActive ? 'h-56':''">
            <div class="flex " :class="faq.isActive ? 'border-b-2 pb-4':''">
              <p class="w-5/6 text-[17px] font-semibold mt-1 "> {{ faq.header }}</p>
              <span class="w-8 h-8 rounded-full ring-2 ring-[#000000] text-center pt-1 text-lg ml-10 ">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 pl-2 text-[#000000]  " :class="faq.isActive ? 'hidden':'block'">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                </svg>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 pl-2 text-[#000000] " :class="faq.isActive ? 'block':'hidden'">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m0 0l6.75-6.75M12 19.5l-6.75-6.75" />
              </svg>
              </span>
            </div>
            <p class="w-5/6 text-[14px] mt-3" :class="faq.isActive ? 'block':'hidden'" > {{ faq.contents }}</p>
          </div>
          </div>
          

         </div>
         <div class="w-full md:w-1/2 md:inline-flex pl-6">

          <!-- <Alert :feedback=feedbackStatus :message=feedbackMessage :type=feedbackType :closeMethod="closeFeedback" ></Alert> -->
          
          <div class="w-full">
            <p class="text-[#000000] text-[30px] pt-4"> Do you need support? </p>
            <div class="  w-full h-auto  p-4 mt-10 rounded-xl bg-white shadow-lg cursor-pointer">

              <p class=" pt-2 text-sm font-bold"> If you need personalized assistance or have specific inquiries, our support team is readily available to help.</p>
        <div class="pt-4 space-y-3">
          <p class="pt-2 text-sm font-semibold text-left">Names: <span class=" text-red-600" title="Required field">(*)</span></p>
          <input type='text' class='w-full h-9 ring-2 ring-[#f6f6f6] rounded-lg  placeholder:p-1 placeholder:font-light  enabled:p-2' placeholder='Enter your names here'  id="formData.names"   @keyup="validate(messages,rules,formData)" v-model="formData.names"/>
          <div class="text-end">
            <span class=" text-red-600 text-xs" v-html="messages.names.slot" ></span>
          </div>


          <p class="pt-2 text-sm font-semibold text-left">Email: <span class=" text-red-600" title="Required field">(*)</span></p>
          <input type='text' class='w-full h-9 ring-2 ring-[#f6f6f6] rounded-lg     placeholder:p-1 placeholder:font-light  enabled:p-2' placeholder='Enter your email here' id="formData.email"   @keyup="validate(messages,rules,formData)" v-model="formData.email"/>
       
          <div class="text-end">
            <span class=" text-red-600 text-xs" v-html="messages.email.slot"></span>
          </div>

          <p class="pt-2 text-sm font-semibold text-left">Select reason for reaching out:</p>
                      <select  v-model="reason"  class="w-full h-9 ring-2 ring-[#f6f6f6] rounded-lg enabled:p-2 enabled:font-light" id="exampleInputSchoolSector">
                      <option value=''>Select reason here:</option>
                      <option value="">Need to know more about the system</option>
                      <option value="">Need to be partner with us</option>
                      <option value="">Another reason</option>
                      </select>
          <p class="pt-2 text-sm font-semibold text-left">Describe your inquiry: <span class=" text-red-600" title="Required field">(*)</span></p>
          <textarea type='text' class='w-full h-24 ring-2 ring-[#f6f6f6] rounded-lg     placeholder:p-1  placeholder:font-light  enabled:p-2' id="formData.description"   @keyup="validate(messages,rules,formData)" v-model="formData.description" placeholder="Briefly describe your inquiry here"></textarea>
          <div class="text-end">
            <span class=" text-red-600 text-xs" v-html="messages.description.slot"></span>
          </div>
          <br><br>

          <button class="w-full h-10 text-sm rounded-lg  font-semibold bg-[#000000] " @click="submitInquiry()"><p class="flex text-white  pl-24 md:pl-[200px]">
            
<svg v-if="isLoading" class="animate-spin -ml-1 mr-1 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
      <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
      <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
    </svg>
    Submit your inquiry</p>

          </button>
         
        </div>

              </div>


          </div>

         </div>
      </div>
    </section>
</template>
<script>
import {validations} from "../helpers/validations"
import Alert from '../components/alert.vue'
export default {
  name:"home",
  components:{
      Alert
      },
    data: () => ({
    feedbackStatus:false,
    feedbackMessage:"",
    feedbackType:"",
    isLoading:false,


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

    formData:{
    names:"",
    email: "",
    description:"",
    },  
    
    rules: {
      names: {
        required:true,
        validationClass:"ring-1 ring-red-500",
      },
      email: {
        email:true,
        validationClass:"ring-1 ring-red-500",
      },
      description:{
        required:true,
        maxlength: 500,
        counter:true,
        validationClass:"ring-1 ring-red-500",
      }
    },
    messages: {
      names: {
        required:"Name field is required",
        slot:"",
        className:""
      },
      email: {
        email:"Valid email is required",
        slot:"",
        className:""
      },
      description:{
        maxlength: 500,
        required:"Description is required",
        counter:"$count / $maxlength",
        slot:"",
        className:""
      },
          },
        reason:"",
      }),
      mounted () {
        },
    created() {
      },
    methods: {
      validate: (messages,rules,formData) =>  validations(messages,rules,formData),
      activeFaq(i){
         this.faqContents[i].isActive =! this.faqContents[i].isActive;
      },
      closeFeedback() {
       this.feedbackStatus =! this.feedbackStatus
       },
    submitInquiry(){
      this.isLoading = true
        if(this.validate(this.messages,this.rules,this.formData))
        {
          this.feedbackStatus = true
          this.feedbackMessage="Your message is successfully sent"
          this.feedbackType="success"
        }
       },
    },
}
</script>
