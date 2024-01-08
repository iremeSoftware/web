<template>
  <div class="w-[100px]">&nbsp;</div>

  <Alert
    v-if="getUsers !='' && feedbackStatus == false" :message="getUsers.response.data?.password[0]" type="danger" :closeMethod="closeFeedback"/>


  <Alert  v-if="errorStatus !='' && errorFeedbackStatus == false && tokenQuery !=undefined" 
      :message="errorStatus == 'failed' ? 'Confirmation token is not valid':errorStatus" type="danger" :closeMethod="closeFeedback"/>

  <Alert v-if="successStatus !='' && successFeedbackStatus == false" :message="successStatus == 'success' ? 'Your account is successfully verified':'' "  type="success" :closeMethod="closeFeedback"/>



  <div class="w-full md:w-[400px] bg-white p-8 rounded-3xl mt-[90px] ml-[0%] md:ml-[38%] shadow-lg">
    <p class="text-lg font-bold">User Login </p>

    <p class="pt-2 text-sm font-light">
      Are you already registered? please login to use the system
    </p>
    <div class="pt-4 space-y-3">
      <p class="pt-2 text-sm font-bold text-left">Email:</p>
      <input
        type="text"
        id="formData.email"
        v-model="formData.email"
        @keyup="validate(messages,rules,formData)"
        className="w-[330px] h-9 ring-2 ring-[#f6f6f6] rounded-lg     placeholder:p-1 placeholder:font-light  enabled:p-2"
        placeholder="Enter Email"
      />

      <div class="text-end">
        <span class="text-red-600 text-xs" v-html="messages.email.slot"></span>
      </div>

      <p class="pt-1 text-sm font-bold text-left">Password:</p>
      <input
        type="password"
        id="formData.password"
        v-model="formData.password"
        @keyup="validate(messages,rules,formData)"
        className="w-[330px] h-9 ring-2 ring-[#f6f6f6] rounded-lg    placeholder:p-1 placeholder:font-light  enabled:p-2"
        placeholder="Enter Password"
      />

      <div class="text-end">
        <span
          class="text-red-600 text-xs"
          v-html="messages.password.slot"
        ></span>
      </div>

      <p class="pt-4 pb-3 text-sm font-light text-left">
        You forgot your password?
        <router-link to="/auth/resetPassword"
          ><a href="#" class="text-sm font-bold hover:text-[#0673c3]"
            >Reset it
          </a></router-link
        >
      </p>

      <button
        class="w-[330px] h-10 text-sm rounded-lg font-semibold bg-[#000000]" @click="loginBtn" :disabled="getUsers.isLoading" >
        <p class="flex text-center text-white pl-[130px]"><svg v-if="getUsers.isLoading==false" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 -ml-1 mr-1 text-white">
            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
          </svg>
          <svg v-if="getUsers.isLoading" class="animate-spin -ml-1 mr-1 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" >
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" ></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
          </svg>
          Sign in
        </p>
      </button>

      <button
        class="w-[330px] h-10 text-sm rounded-lg font-semibold ring-1 ring-[#000000]" @click="loginWithGoogle" :disabled="getUsers.isLoading">
        <p class="flex text-center text-black pl-[28%] pt-2">

          
          <svg v-if="isGoogleUIDUpdated==false"  xmlns="http://www.w3.org/2000/svg" class="ml-2" viewBox="0 0 48 48" width="24px" height="24px"><path fill="#fbc02d" d="M43.611,20.083H42V20H24v8h11.303c-1.649,4.657-6.08,8-11.303,8c-6.627,0-12-5.373-12-12	s5.373-12,12-12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C34.046,6.053,29.268,4,24,4C12.955,4,4,12.955,4,24s8.955,20,20,20	s20-8.955,20-20C44,22.659,43.862,21.35,43.611,20.083z"/><path fill="#e53935" d="M6.306,14.691l6.571,4.819C14.655,15.108,18.961,12,24,12c3.059,0,5.842,1.154,7.961,3.039	l5.657-5.657C34.046,6.053,29.268,4,24,4C16.318,4,9.656,8.337,6.306,14.691z"/><path fill="#4caf50" d="M24,44c5.166,0,9.86-1.977,13.409-5.192l-6.19-5.238C29.211,35.091,26.715,36,24,36	c-5.202,0-9.619-3.317-11.283-7.946l-6.522,5.025C9.505,39.556,16.227,44,24,44z"/><path fill="#1565c0" d="M43.611,20.083L43.595,20L42,20H24v8h11.303c-0.792,2.237-2.231,4.166-4.087,5.571	c0.001-0.001,0.002-0.001,0.003-0.002l6.19,5.238C36.971,39.205,44,34,44,24C44,22.659,43.862,21.35,43.611,20.083z"/></svg>
          <svg v-if="isGoogleUIDUpdated" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 -ml-1 mr-1 text-white">
            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
          </svg>
          &nbsp;Login with Google
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
import {getAuth,GoogleAuthProvider,signInWithPopup} from 'firebase/auth'

export default {
  name:"login",
  components:{
    Alert
  },
  setup() {
    const router = useRouter();
    const route = useRoute();
    const store = useUserStore();
    const feedbackStatus = ref(false);
    const successFeedbackStatus = ref(false);
    const errorFeedbackStatus = ref(false);
    const googleLoginData = ref({});
    const device_id = (localStorage.getItem('d_id') !="" || localStorage.getItem('d_id') !=undefined)  ? localStorage.getItem('d_id') : "null";
    const tokenQuery = route.query.token
    const formData = ref({
      email: "",
      password:"",
      d_id: device_id,
      loginWith:"normal_login"
      });
const rules = ref({
    email: {
      email:true,
      validationClass:"ring-1 ring-red-500",
    },
    password: {
      required:true,
      validationClass:"ring-1 ring-red-500",
    },
  });
  const messages = ref({
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
  });

  function validate (messages,rules,formData){
     return validations(messages,rules,formData)
  }

  function closeFeedback() {
        feedbackStatus.value =! feedbackStatus.value
        successFeedbackStatus.value =! successFeedbackStatus.value
        errorFeedbackStatus.value =! errorFeedbackStatus.value
  }

  function loginBtn() {
      if(validate(messages.value,rules.value,formData.value))
      {
        return store.login(formData.value);
      }
    }

    async function loginWithGoogle () {
      const auth = getAuth();
      const provider = new GoogleAuthProvider();
      try {
        const result = await signInWithPopup(auth, provider);
        let userData = {
          email:result.user.email,
          uid:result.user.uid,
          accessToken:result.user.accessToken,
          photoURL:result.user.photoURL
        }
        console.log(result.user);
        googleLoginData.value = result.user
        store.updateGoogleUid(userData)
      } catch(error) {
        console.log(error);
      }
    }

    function checkAuth(){
      if(store.getUserData())
      {
        if(store.userDetails.length > 0){  
            router.push({ path:"/dashboard/home"});
        }
      }
    }

    const getUsers = computed(() => {
      if(store.userDetails.account_id !=null){  
         router.push({ path:"/dashboard/home"});
       }
       feedbackStatus.value = store.errorMessage != "" ? false : true
       const objectStates = Object.assign(store.errorMessage,store.loadingUI);
      return objectStates
    });

    const successStatus = computed(() => {
       return store.successMessage
    });

    const errorStatus = computed(() => {
       return store.confirmAccountErrorMessage
    });

    const isGoogleUIDUpdated = computed(() => {
      if(store.isGoogleUIDUpdated)
      {

        let googleFormData = {
          email:googleLoginData.value.email,
          password:'',
          d_id:'',
          loginWith:'Google',
          uid:googleLoginData.value.uid,
          accessToken:googleLoginData.value.accessToken
        }
        store.login(googleFormData)
      }

       return store.isGoogleUIDUpdated
    });

    function setPageTitle(newTitle){
      if (document.title != newTitle) {
          document.title = ""
          document.title = import.meta.env.VITE_APP_NAME +' - '+ newTitle
      }
    }


    onMounted(() => {
      checkAuth()
      setPageTitle('Login')
      store.confirm_account(route.query.token)
    });

    return {
      messages,rules,formData,feedbackStatus,successFeedbackStatus,errorFeedbackStatus,closeFeedback,loginBtn,loginWithGoogle,getUsers,validate,successStatus,errorStatus,tokenQuery,isGoogleUIDUpdated
    }
  },
}
</script>
