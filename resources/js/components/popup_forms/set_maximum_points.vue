<template>
    <ModalPopUp height="250">
        <template v-slot:title>
           Set Maximum Points (Term {{ popupDetails.popup_data.term}})
            </template>
            <template v-slot:contents>

                <Alert v-if="successStatus !='' && successFeedbackStatus == false" :message="successStatus"  type="success" :closeMethod="closeFeedback"/>
                <!-- {{  popupDetails.popup_data }} -->
                <div class="flex">
                    <div class="">
                            <input type="radio" name="set" class="mr-2" id="quiz" value="quiz" v-model="selected" @change="selectType('quiz')" >
                            <label class="font-semibold pt-1" for="quiz" >Quiz</label>
                    </div>
                     <div class="ml-10">
                            <input type="radio" name="set" class="mr-2" id="exam" value="exam" v-model="selected" @change="selectType('exam')" >
                            <label class="font-semibold pt-1" for="exam" >Exam</label>
                    </div>
                </div>
                <!-- {{ maximumPoints }} -->
               <template v-if="selected == 'quiz'">
                <div class="flex">
                    <p class="text-sm font-semibold text-left mt-2">Quiz Maximum Points: </p>
                    <p class="text-sm font-semibold text-left mt-2 ml-4">/</p>
                    <input type='number' class='w-20 h-10 ml-3 md:ml-2 ring-1 ring-[#000000]  enabled:p-2' v-model="formData.term_quiz"  />
                <button class="w-20 h-8 text-xs md:text-sm rounded-lg text-white bg-[#000000] ml-4 mt-1" @click="setMaximumPoints()" ><p class="flex pl-2">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <dt class="md:pl-2 pt-1">Set </dt></p>
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
                    <p class="text-sm font-semibold text-left mt-2">Exam Maximum Points: </p>
                    <p class="text-sm font-semibold text-left mt-2 ml-4">/</p>
                    <input type='number' class='w-20 h-10 ml-3 md:ml-2 ring-1 ring-[#000000]  enabled:p-2' v-model="formData.term_exam"  />
                <button class="w-20 h-8 text-xs md:text-sm rounded-lg text-white bg-[#000000] ml-4 mt-1" @click="setMaximumPoints()" ><p class="flex pl-2">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <dt class="md:pl-2 pt-1">Set </dt></p>
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
      name:"setMaximumPoints",
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
              limit:uiStore.popupDetails.popup_data?.limit,
              sort_by:'name',
              sort:'ASC',
              term:uiStore.popupDetails.popup_data?.term,
              term_quiz:0,
              term_exam:0
        });


        function selectType(type){
            selected.value = type 
            type == 'quiz' ? formData.value.term_exam = 0 : formData.value.term_quiz = 0
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
            formData.value.term_quiz = 0
            return studentsMarksStores.successMessage
        });

        function setMaximumPoints(){
             formData.value.term_quiz >0 ? localStorage.setItem('quiz_maximum',formData.value.term_quiz) :""
             studentsMarksStores.quiz_maximum = localStorage.getItem('quiz_maximum')
             studentsMarksStores.updateMaximumPoints(formData.value)
             getMaximum()
        }

        function getMaximum(){
          return studentsMarksStores.getMaximumPoints(formData.value);
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
        
        return {slotData,loadingStatus,errorStatus,successStatus,closeFeedback,successFeedbackStatus,errorFeedbackStatus,popupDetails,setMaximumPoints,selected,selectType,formData,maximumPoints}
       },
    }
    </script>

    