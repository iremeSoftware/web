<template>
  <div class="w-[100px]">&nbsp;</div>

  <Alert
    v-if="getUsers !='' && feedbackStatus == false"
    :message="getUsers.message ?? getUsers.password[0]"
    type="danger"
    :closeMethod="closeFeedback"
  />
  <div
    class="w-[400px] bg-white p-8 rounded-3xl mt-[90px] md:ml-[500px] text-center shadow-lg"
  >
    <p class="text-lg font-bold">Account 2FA verification</p>

    <p class="pt-2 text-sm font-light">
      Please enter verification code you have received inbox
    </p>
    <div class="pt-4 space-y-3">
      <p class="pt-2 text-sm font-bold text-left">Verification Code:</p>
      <div class="flex space-x-2">
        <input type="text" id="code1" @keyup="focusInput(1)" v-model="formData.code1" className="w-[60px] h-12 ring-2 ring-[#000000] rounded-lg enabled:pl-6" maxlength="1" />
        <input type="text" id="code2" @keyup="focusInput(2)" v-model="formData.code2" className="w-[60px] h-12 ring-2 ring-[#000000] rounded-lg enabled:pl-6" maxlength="1"/>
        <input type="text" id="code3" @keyup="focusInput(3)" v-model="formData.code3" className="w-[60px] h-12 ring-2 ring-[#000000] rounded-lg enabled:pl-6" maxlength="1"/>
        <input type="text" id="code4" @keyup="focusInput(4)" v-model="formData.code4" className="w-[60px] h-12 ring-2 ring-[#000000] rounded-lg enabled:pl-6" maxlength="1"/>
        <input type="text" id="code5" @keyup="focusInput(5)" v-model="formData.code5" className="w-[60px] h-12 ring-2 ring-[#000000] rounded-lg enabled:pl-6" maxlength="1"/>
      </div>

      <button
        class="w-[330px] h-10 text-sm rounded-lg font-semibold bg-[#000000]"
        @click="verifyBtn"
      >
        <p class="flex text-center text-white pl-[130px]">
          <svg
            v-if="getUsers.isLoading==false"
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 24 24"
            stroke-width="1.5"
            stroke="currentColor"
            class="w-5 h-5 -ml-1 mr-1 text-white"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"
            />
          </svg>
          <svg
            v-if="getUsers.isLoading"
            class="animate-spin -ml-1 mr-1 h-5 w-5 text-white"
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 24 24"
          >
            <circle
              class="opacity-25"
              cx="12"
              cy="12"
              r="10"
              stroke="currentColor"
              stroke-width="4"
            ></circle>
            <path
              class="opacity-75"
              fill="currentColor"
              d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
            ></path>
          </svg>
          Verify
        </p>
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
  name:"verification_code",
  components:{
    Alert
  },
  setup() {
    const router = useRouter();
    const route =  useRoute();
    const store = useUserStore();
    const feedbackStatus = ref(false);
    const formData = ref({
      code1:"",
      code2:"",
      code3:"",
      code4:"",
      code5:""
    })


  function validate (messages,rules,formData){
     return validations(messages,rules,formData)
  }

  function closeFeedback() {
        feedbackStatus.value =! feedbackStatus.value
  }

  function verifyBtn() {
        const codes = formData.value.code1+formData.value.code2+formData.value.code3+formData.value.code4+formData.value.code5;
        const verification_code = route.params.account_id;
        return store.account_verification(verification_code,codes);
      
    }

    function checkAuth(){
      store.getUserData()
      // if(store.getUserData() )
      // {
      //   if(store.getUserDetails.length > 0 && store.device_id !="null"){
      //     router.push({ path:"/dashboard"});
      //   }
      // }
    }

    function focusInput(num){
      if(event.which == 8)
      {
            if(num == 5)
          {
            document.getElementById('code4').focus();
          }
          else if(num == 4)
          {
            document.getElementById('code3').focus();
          }
          else if(num == 3)
          {
            document.getElementById('code2').focus();
          }
          else if(num == 2)
          {
            document.getElementById('code1').focus();
          }
      }
      else 
      {
                if(num == 0)
              {
                document.getElementById('code1').focus();
              }
              else if(num == 1)
              {
                document.getElementById('code2').focus();
              }
              else if(num == 2)
              {
                document.getElementById('code3').focus();
              }
              else if(num == 3)
              {
                document.getElementById('code4').focus();
              }
              else {
                document.getElementById('code5').focus();
              }
       }   
    }

    const getUsers = computed(() => {
      if(store.getUserDetails.length > 0 && store.device_id !="null"){
        router.push({ path:"/dashboard"});
       }
       feedbackStatus.value = store.errorMessage != "" ? false : true
       const objectStates = Object.assign(store.errorMessage,store.loadingUI);
      return objectStates
    });

    onMounted(() => {
      checkAuth();
    });

    return {
      formData,feedbackStatus,closeFeedback,verifyBtn,getUsers,validate,focusInput
    }

  },
}
</script>

