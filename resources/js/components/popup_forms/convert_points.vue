<template>
    <ModalPopUp height="250">
        <template v-slot:title>
           Convert Maximum Points (Term {{ popupDetails.popup_data.term}})
            </template>
            <template v-slot:contents>

                <Alert v-if="successStatus !='' && successFeedbackStatus == false" :message="successStatus"  type="success" :closeMethod="closeFeedback"/>
                <!-- {{  popupDetails.popup_data }} -->
                <div class="flex">
                    <div class="">
                            <input type="radio" name="set" class="mr-2" id="quiz" value="quiz" v-model="selected" @change="selectType('quiz')" >
                            <label class="font-semibold pt-1" for="quiz" >CAT</label>
                    </div>
                     <div class="ml-10">
                            <input type="radio" name="set" class="mr-2" id="exam" value="exam" v-model="selected" @change="selectType('exam')" >
                            <label class="font-semibold pt-1" for="exam" >Exam</label>
                    </div>
                </div>
                <!-- {{ maximumPoints }} -->
               <template v-if="selected == 'quiz'">
                <div class="flex">
                    <p class="text-sm md:text-md font-semibold text-left mt-2">Convert quiz maximum points from 
                        <template v-if="popupDetails.popup_data.term ==1">{{ popupDetails.popup_data.maximumPoints?.term1_quiz ?? 0 }}</template>
                        <template v-else-if="popupDetails.popup_data.term ==2">{{ popupDetails.popup_data.maximumPoints?.term2_quiz ?? 0 }}</template>
                        <template v-else>{{ popupDetails.popup_data.maximumPoints?.term3_quiz ?? 0 }}</template> to: </p>
                    <input type='number' class='w-20 h-10 ml-3 md:ml-2 ring-1 ring-[#000000]  enabled:p-2' v-model="formData.term_quiz"  />
                <button class="w-32 h-8 text-xs md:text-sm rounded-lg text-white bg-[#000000] ml-4 mt-1" @click="convertMaximumPoints()" ><p class="flex pl-2">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
                    </svg>
                    <dt class="md:pl-2 pt-1">Convert </dt></p>
                </button>

                </div> 
   
                <div class="flex">
                    <p v-if="popupDetails.popup_data.term ==1" class="text-lg font-bold">Total Maximum Points:/{{ popupDetails.popup_data.maximumPoints?.term1_quiz ?? 0 }}</p>
                    <p v-else-if="popupDetails.popup_data.term ==2" class="text-lg font-bold">Total Maximum Points:/{{ popupDetails.popup_data.maximumPoints?.term2_quiz ?? 0 }}</p>
                    <p v-else class="text-lg font-bold">Total Maximum Points:/{{ popupDetails.popup_data.maximumPoints?.term3_quiz ?? 0 }}</p>
                </div> 
               </template>
               <template v-else>
                    <div class="flex">
                        <p class="text-sm md:text-md font-semibold text-left mt-2">Convert exam maximum points from 
                        <template v-if="popupDetails.popup_data.term ==1">{{ popupDetails.popup_data.maximumPoints?.term1_exam ?? 0 }}</template>
                        <template v-else-if="popupDetails.popup_data.term ==2">{{ popupDetails.popup_data.maximumPoints?.term2_exam ?? 0 }}</template>
                        <template v-else>{{ popupDetails.popup_data.maximumPoints?.term3_exam ?? 0 }}</template> to: </p>
                    <input type='number' class='w-20 h-10 ml-3 md:ml-2 ring-1 ring-[#000000]  enabled:p-2' v-model="formData.term_exam"  />
                <button class="w-32 h-8 text-xs md:text-sm rounded-lg text-white bg-[#000000] ml-4 mt-1" @click="convertMaximumPoints()" ><p class="flex pl-2">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
                    </svg>
                    <dt class="md:pl-2 pt-1">Convert </dt></p>
                </button>

                </div>    
                <div class="flex">
                    <p v-if="popupDetails.popup_data.term ==1" class="text-lg font-bold">Total Maximum Points:/{{ popupDetails.popup_data.maximumPoints?.term1_exam ?? 0 }}</p>
                    <p v-else-if="popupDetails.popup_data.term ==1" class="text-lg font-bold">Total Maximum Points:/{{ popupDetails.popup_data.maximumPoints?.term2_exam ?? 0 }}</p>
                    <p v-else class="text-lg font-bold">Total Maximum Points:/{{ popupDetails.popup_data.maximumPoints?.term3_exam ?? 0 }}</p>
                </div> 
               </template>           
            </template>
    </ModalPopUp>
</template>

<script>
import { ref, useSlots,computed, onMounted } from 'vue'
import Alert from '../../components/alert.vue'
import ModalPopUp from './../ModalPopUp.vue'
import { useUserStore } from '../../stores/auth'
import { uiChangesStore } from '../../stores/ui_changes'
import {studentsMarksStore} from '../../stores/student_marks'


export default {
      name:"convertMaximumPoints",
      components:{
      ModalPopUp,
      Alert
   },
      setup() {
        const slots = useSlots()
        const slotData = ref(slots)
        const successFeedbackStatus = ref(false)
        const errorFeedbackStatus = ref(false)
        const store = useUserStore()
        const uiStore = uiChangesStore();
        let maximumPoints = ref({})

        const popupDetails = computed(() => uiStore.popupDetails)
        const studentsMarksStores = studentsMarksStore()
        const selected = ref('quiz');

        const formData = ref({
              school_id:uiStore.popupDetails.popup_data?.school_id,
              class_id:uiStore.popupDetails.popup_data?.class_id,
              account_id:uiStore.popupDetails.popup_data?.account_id,
              course_id:uiStore.popupDetails.popup_data?.course_id,
              page:1,
              limit:uiStore.popupDetails.popup_data?.limit,
              sort_by:'name',
              sort:'ASC',
              term:uiStore.popupDetails.popup_data?.term,
              term_quiz:"",
              term_exam:""
        });


        function selectType(type){
            selected.value = type 
            type == 'quiz' ? formData.value.term_exam = "" : formData.value.term_quiz = ""
        }

        const loadingStatus = computed(() => {
            errorFeedbackStatus.value = studentsMarksStores.errorMessage != "" ? false : true
            successFeedbackStatus.value = studentsMarksStores.successMessage != "" ? false : true
            return studentsMarksStores.loadingUI
        });

        const errorStatus = computed(() => {
            return studentsMarksStores.errorMessage
        });

        function closeFeedback() {
        successFeedbackStatus.value =! successFeedbackStatus.value
        errorFeedbackStatus.value =! errorFeedbackStatus.value
        }

        maximumPoints = computed(() =>  studentsMarksStores.maximumPoints )

        const successStatus = computed(() => {
            return studentsMarksStores.successMessage
        });

        function convertMaximumPoints(){
             return studentsMarksStores.convertMaximumPoints(formData.value)
        }

        onMounted(() => {
            if(store.getUserData())
            {
                successFeedbackStatus.value = true
                errorFeedbackStatus.value = true
                setTimeout(function (){
                    formData.value.school_id = store.userDetails.school_id
                },1000);
            }
         })
        
        return {slotData,loadingStatus,errorStatus,successStatus,closeFeedback,successFeedbackStatus,errorFeedbackStatus,popupDetails,convertMaximumPoints,selected,selectType,formData,maximumPoints}
       },
    }
    </script>

    