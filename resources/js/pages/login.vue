<template >
      <div class="w-[100px]">&nbsp;</div>
      <Alert :feedback=feedbackStatus :message=feedbackMessage :type=feedbackType :closeMethod="closeFeedback" ></Alert>

      <div class=" w-[400px] bg-white p-8  rounded-3xl mt-[90px] ml-14 md:ml-[450px] text-center shadow-lg">
        <p class=" text-lg font-bold"> User Login</p>
        <p class=" pt-2 text-sm font-light"> Are you already registered? please login to use the system</p>
        <div class="pt-4 space-y-3">
          <p class="pt-2 text-sm font-bold text-left">Email:</p>
          <input type='text' id="formData.email" v-model="formData.email" @keyup="validate(messages,rules,formData)" className='w-[330px] h-9 ring-2 ring-[#f6f6f6] rounded-lg     placeholder:p-1 placeholder:font-light  enabled:p-2' placeholder='Enter Email'/>

          <div class="text-end">
            <span class=" text-red-600 text-xs" v-html="messages.email.slot" ></span>
          </div>

          <p class="pt-1 text-sm font-bold text-left">Password:</p>
          <input type='password' id="formData.password" v-model="formData.password" @keyup="validate(messages,rules,formData)" className='w-[330px] h-9 ring-2 ring-[#f6f6f6] rounded-lg    placeholder:p-1 placeholder:font-light  enabled:p-2' placeholder='Enter Password'/>

          <div class="text-end">
            <span class=" text-red-600 text-xs" v-html="messages.password.slot" ></span>
          </div>


          <p class=" pt-4 pb-3 text-sm font-light text-left"> Having trouble in sign in? <router-link to="/resetPassword"><a href="#" class=" text-sm font-bold  hover:text-[#0673c3]">Reset Password </a></router-link></p>
        
          <button class="w-[330px] h-10 text-sm rounded-lg  font-semibold bg-[#0673c3]" @click="loginBtn"><p class="flex text-center text-white pl-[130px]">

<svg v-if="isLoading==false" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class=" w-5 h-5 -ml-1 mr-1 text-white">
  <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
</svg>
<svg v-if="isLoading" class="animate-spin -ml-1 mr-1 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
      <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
      <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
    </svg>
Sign in</p>

          </button>
         
        </div>
      </div>
      <div class="h-[40px]">&nbsp;</div>
    
  </template>
  <script>
  import {validations} from "../helpers/validations"
  import Alert from '../components/alert.vue'

  export default {
    name:"login",
    components:{
      Alert
   },
  data: () => ({
    feedbackStatus:false,
    feedbackMessage:"",
    feedbackType:"",
    isLoading:false,
    formData:{
    email: "",
    password:"",
    },

    rules: {
      email: {
        email:true,
        validationClass:"ring-1 ring-red-500",
      },
      password: {
        required:true,
        validationClass:"ring-1 ring-red-500",
      },
    },
    messages: {
      email: {
        email:"Please enter valid email",
        slot:"",
        className:""
      },
      password:{
        required:"Please fill password field",
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
        this.isLoading = true;
        if(this.validate(this.messages,this.rules,this.formData))
        {
          // this.feedbackStatus = true
          // this.feedbackMessage="Your email or password is not valid"
          // this.feedbackType="danger"
          // this.isLoading = false;
          this.$router.push({
            path:"/dashboard",
          })
        }
      }
   }
  }
  </script>

