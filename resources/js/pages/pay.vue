<template >
      <div class="w-[100px]">&nbsp;</div>
      <Alert :feedback=feedbackStatus :message=feedbackMessage :type=feedbackType :closeMethod="closeFeedback" ></Alert>
      <div class="w-full" >
        <div class=" w-[400px] bg-white p-8  rounded-3xl mt-[90px] ml-14 md:ml-[450px] text-center shadow-lg">
        <p class=" text-lg font-bold"> Pay school fees</p>
        <p class=" pt-2 text-sm font-light"> Just enter student code to continue</p>
        <div class="pt-4 space-y-3">
          <p class="pt-2 text-sm font-bold text-left">Student code:</p>
          <input type='text' id="formData.studentCode" v-model="formData.studentCode" @keyup="validate(messages,rules,formData)" className='w-[330px] h-9 ring-2 ring-[#f6f6f6] rounded-lg     placeholder:p-1 placeholder:font-light  enabled:p-2' placeholder='Enter student code'/>

          <div class="text-end">
            <span class=" text-red-600 text-xs" v-html="messages.studentCode.slot" ></span>
          </div>


          <p class=" pt-4 pb-3 text-sm font-light text-left"> Forgot student code? <router-link to="/resetPassword"><a href="#" class=" text-sm font-bold  hover:text-[#0673c3]">Verify it here </a></router-link></p>
        
          <button class="w-[330px] h-10 text-sm rounded-lg  font-semibold bg-[#0673c3]" @click="loginBtn"><p class="flex text-center text-white pl-[130px]">
            Continue&nbsp;&nbsp; <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 4.5l7.5 7.5-7.5 7.5m-6-15l7.5 7.5-7.5 7.5" />
</svg></p>

          </button>
         
        </div>
      </div>
      </div>
     
      <div class="h-[40px]">&nbsp;</div>
    
  </template>
  <script>
  import {validations} from "../helpers/validations"
  import Alert from '../components/alert.vue'

  export default {
    name:"pay",
    components:{
      Alert
   },
  data: () => ({
    feedbackStatus:false,
    feedbackMessage:"",
    feedbackType:"",

    formData:{
    studentCode: "",
    },

    rules: {
    studentCode: {
        required:true,
        maxlength:8,
        counter:true,
        validationClass:"ring-1 ring-red-500",
      },
    },
    messages: {
        studentCode: {
        counter:"$count of $maxlength characters",
        slot:"",
        className:""
      },
    },


  }),
  
  methods: {
      validate: (messages,rules,formData) =>  validations(messages,rules,formData),
      closeFeedback() {
       this.feedbackStatus =! this.feedbackStatus
       },
      loginBtn()
      {
        if(this.validate(this.messages,this.rules,this.formData))
        {
          this.feedbackStatus = true
          this.feedbackMessage="Student code "
          this.feedbackType="danger"
        }
      }
   }
  }
  </script>

