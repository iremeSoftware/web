<template >
      <div class="w-[100px]">&nbsp;</div>
      <Alert  v-if="errorStatus !='' && feedbackStatus == false" 
      :message="
      errorStatus.status ?? 
      (
      errorStatus.errors 
      ? errorStatus.errors.confirm_password 
      :
       (errorStatus.password !=undefined ? errorStatus.password[0] : '') +'<br>'+ 
       (errorStatus.confirm_password !=undefined ? errorStatus.confirm_password[0] : '')
       )" 
       
       type="danger" :closeMethod="closeFeedback"/>
      <Alert v-if="successStatus !=''" :message="successStatus == 'success' ? 'Password is successfully updated':''"  type="success" :closeMethod="closeFeedback"/>

      <div class=" w-[400px] bg-white pl-8 pt-4 pr-8 pb-4  rounded-3xl mt-[90px] ml-14 md:ml-[38%] text-center shadow-lg">
        <p class=" text-lg font-bold"> Change Password
</p>
        <p class=" pt-2 text-sm font-light"> In order to reset your password just enter your new password and confirm it</p>
        <div class="pt-4 pb-8 space-y-3">
          <p class="pt-2 text-sm font-bold text-left">New password:</p>
          <input type='password' className='w-[330px] h-9 ring-2 ring-[#f6f6f6] rounded-lg placeholder:p-1 placeholder:font-light  enabled:p-2' id="formData.password" v-model="formData.password" @keyup="validate(messages,rules,formData)" placeholder=''/>
          <div class="text-end">
            <span class=" text-red-600 text-xs" v-html="messages.password.slot" ></span>
          </div>

          <p class="pt-2 text-sm font-bold text-left">Confirm new password:</p>
          <input type='password' className='w-[330px] h-9 ring-2 ring-[#f6f6f6] rounded-lg placeholder:p-1 placeholder:font-light  enabled:p-2' id="formData.confirm_password" v-model="formData.confirm_password" @keyup="validate(messages,rules,formData)" placeholder=''/>
          <div class="text-end">
            <span class=" text-red-600 text-xs" v-html="messages.confirm_password.slot" ></span>
          </div>
          

          <button class="w-[330px] h-10 text-sm rounded-lg  font-semibold bg-[#000000]" @click="changePasswordBtn"><p class="flex text-center text-white pl-24">
            <svg v-if="loadingStatus.isLoading==false" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
  <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 5.25a3 3 0 013 3m3 0a6 6 0 01-7.029 5.912c-.563-.097-1.159.026-1.563.43L10.5 17.25H8.25v2.25H6v2.25H2.25v-2.818c0-.597.237-1.17.659-1.591l6.499-6.499c.404-.404.527-1 .43-1.563A6 6 0 1121.75 8.25z" />
</svg>
<svg v-if="loadingStatus.isLoading" class="animate-spin -ml-1 mr-1 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" ></circle><path class="opacity-75" fill="currentColor"
              d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
          </svg>
&nbsp;&nbsp;Change Password</p>

          </button>
        </div>
      </div>
      <div class="h-[40px]">&nbsp;</div>
    
  </template>
  <script>
import { useUserStore } from '../../stores/auth'
import {validations} from "../../helpers/validations"
import Alert from '../../components/alert.vue'
import { ref,computed,onMounted } from 'vue';
import { useRouter,useRoute } from 'vue-router';

export default {
  name:"ChangePassword",
  components:{
    Alert
  },
  setup() {
    const router = useRouter();
    const route =  useRoute();
    const store = useUserStore();
    const feedbackStatus = ref(false);
    const formData = ref({
      password: "",
      confirm_password: "",
      access_token: route.params.token
      });
const rules = ref({
    password: {
      required:true,
      validationClass:"ring-1 ring-red-500",
    },
    confirm_password: {
      required:true,
      validationClass:"ring-1 ring-red-500",
    },
  });
  const messages = ref({
    password: {
      required:"Password field is required",
      slot:"",
      className:""
    },
    confirm_password: {
      required:"Confirm password field is required",
      slot:"",
      className:""
    },
  });

  function validate (messages,rules,formData){
     return validations(messages,rules,formData)
  }

  function closeFeedback() {
        feedbackStatus.value =! feedbackStatus.value
  }

  function changePasswordBtn() {
      if(validate(messages.value,rules.value,formData.value))
      {
        return store.reset_password(formData.value);
      }
    }

    const errorStatus = computed(() => {
       return store.errorMessage
    });

    const successStatus = computed(() => store.successMessage);

    const loadingStatus = computed(() => {
       feedbackStatus.value = store.errorMessage != "" ? false : true
       return store.loadingUI
    });

    return {
      messages,formData,feedbackStatus,closeFeedback,changePasswordBtn,errorStatus,successStatus,loadingStatus,validate
    }
  },
}
  </script>
