<template >
  <div class="w-full flex ">
    <sidebarVue />
    <div class="w-5/6">
      <Header2 />
    </div>
  </div>
      
    
</template>
  <script>
import { useUserStore } from '../../stores/auth'
import {validations} from "../../helpers/validations"
import Alert from '../../components/alert.vue'
import Header2 from '../../components/header2.vue'
import sidebarVue from '../../components/sidebar.vue'
import { computed } from 'vue';
import { useRouter } from 'vue-router';


export default {
    name:"dashboard",
    components:{
      Alert,
      Header2,
      sidebarVue
   },
  setup() {
    const store = useUserStore();


  function validate (messages,rules,formData){
     return validations(messages,rules,formData)
  }

  function closeFeedback() {
        feedbackStatus.value =! feedbackStatus.value
  }

    const getUsers = computed(() => {
      return store.userDetails;
    });

    return {
     closeFeedback,getUsers,validate
    }

  },
}
  </script>
