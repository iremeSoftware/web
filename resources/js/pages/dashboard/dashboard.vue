<template >
  <div class="w-full flex ">
    <sidebarVue />
    <div class="w-5/6">
      <Header2 />
    </div>
  </div>
      
    
</template>
  <script>
  import {validations} from "../../helpers/validations"
  import Alert from '../../components/alert.vue'
  import Header2 from '../../components/header2.vue'
  import sidebarVue from '../../components/sidebar.vue'

  export default {
    name:"dashboard",
    components:{
      Alert,
      Header2,
      sidebarVue
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
          this.feedbackStatus = true
          this.feedbackMessage="Your email or password is not valid"
          this.feedbackType="danger"
          this.isLoading = false;
        }
      }
   }
  }
  </script>
