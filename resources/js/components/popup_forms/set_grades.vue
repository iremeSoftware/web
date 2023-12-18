<template>
    <ModalPopUp>
        <template v-slot:title>
           Set grades (Term {{ popupDetails.popup_data.term}})
            </template>
            <template v-slot:contents>

                <Alert v-if="successStatus !='' && successFeedbackStatus ==false" :message="successStatus"  type="success" :closeMethod="closeFeedback"/>

                <Alert  v-if="errorStatus !='' && errorFeedbackStatus ==false" :message="errorStatus.message" type="danger" :closeMethod="closeFeedback"/>
    <!-- {{  popupDetails.popup_data }} -->

                <div class="flex">
                    <p class="text-sm md:text-md font-semibold text-left mt-2">Grade A (6) :</p>
                    <input type='number' class='w-20 h-10 ml-3 md:ml-2 ring-1 ring-[#000000]  enabled:p-2' v-model="formData.gradeA_from" readonly />
                    <p class="ml-1 pt-2">%</p>
                    <p class="ml-4 mt-2">-</p>
                    <input type='number' class='w-20 h-10 ml-3 md:ml-4 ring-1 ring-[#000000]  enabled:p-2' v-model="formData.gradeA_to" @input="changeToGrade('gradeA')"  />
                    <p class="ml-1 pt-2">%</p>
                </div>
                <div class="flex">
                    <p class="text-sm md:text-md font-semibold text-left mt-2">Grade B (5):</p>
                    <input type='number' class='w-20 h-10 ml-3 md:ml-2 ring-1 ring-[#000000]  enabled:p-2' v-model="formData.gradeB_from" readonly  />
                    <p class="ml-1 pt-2">%</p>
                    <p class="ml-4 mt-2">-</p>
                    <input type='number' class='w-20 h-10 ml-3 md:ml-4 ring-1 ring-[#000000]  enabled:p-2' v-model="formData.gradeB_to" @input="changeToGrade('gradeB')"  />
                    <p class="ml-1 pt-2">%</p>
                </div> 
                <div class="flex">
                    <p class="text-sm md:text-md font-semibold text-left mt-2">Grade C (4):</p>
                    <input type='number' class='w-20 h-10 ml-3 md:ml-2 ring-1 ring-[#000000]  enabled:p-2' v-model="formData.gradeC_from" readonly />
                    <p class="ml-1 pt-2">%</p>
                    <p class="ml-4 mt-2">-</p>
                    <input type='number' class='w-20 h-10 ml-3 md:ml-4 ring-1 ring-[#000000]  enabled:p-2' v-model="formData.gradeC_to" @input="changeToGrade('gradeC')"  />
                    <p class="ml-1 pt-2">%</p>
                </div>
                <div class="flex">
                    <p class="text-sm md:text-md font-semibold text-left mt-2">Grade D (3):</p>
                    <input type='number' class='w-20 h-10 ml-3 md:ml-2 ring-1 ring-[#000000]  enabled:p-2' v-model="formData.gradeD_from" readonly  />
                    <p class="ml-1 pt-2">%</p>
                    <p class="ml-4 mt-2">-</p>
                    <input type='number' class='w-20 h-10 ml-3 md:ml-4 ring-1 ring-[#000000]  enabled:p-2' v-model="formData.gradeD_to" @input="changeToGrade('gradeD')"  />
                    <p class="ml-1 pt-2">%</p>
                </div>
                <div class="flex">
                    <p class="text-sm md:text-md font-semibold text-left mt-2">Grade E (2) :</p>
                    <input type='number' class='w-20 h-10 ml-3 md:ml-2 ring-1 ring-[#000000]  enabled:p-2' v-model="formData.gradeE_from" readonly  />
                    <p class="ml-1 pt-2">%</p>
                    <p class="ml-4 mt-2">-</p>
                    <input type='number' class='w-20 h-10 ml-3 md:ml-4 ring-1 ring-[#000000]  enabled:p-2' v-model="formData.gradeE_to" @input="changeToGrade('gradeE')"  />
                    <p class="ml-1 pt-2">%</p>
                </div>
                <div class="flex">
                    <p class="text-sm md:text-md font-semibold text-left mt-2">Grade S (1) :</p>
                    <input type='number' class='w-20 h-10 ml-3 md:ml-2 ring-1 ring-[#000000]  enabled:p-2' v-model="formData.gradeS_from" readonly   />
                    <p class="ml-1 pt-2">%</p>
                    <p class="ml-4 mt-2">-</p>
                    <input type='number' class='w-20 h-10 ml-3 md:ml-4 ring-1 ring-[#000000]  enabled:p-2' v-model="formData.gradeS_to" @input="changeToGrade('gradeS')"  />
                    <p class="ml-1 pt-2">%</p>
                </div>
                <div class="flex">
                    <p class="text-sm md:text-md font-semibold text-left mt-2">Grade F (0) :</p>
                    <input type='number' class='w-20 h-10 ml-3 md:ml-2 ring-1 ring-[#000000]  enabled:p-2' v-model="formData.gradeF_from" readonly />
                    <p class="ml-1 pt-2">%</p>
                    <p class="ml-4 mt-2">-</p>
                    <input type='number' class='w-20 h-10 ml-3 md:ml-4 ring-1 ring-[#000000]  enabled:p-2' v-model="formData.gradeF_to" readonly  />
                    <p class="ml-1 pt-2">%</p>
                </div>
                
                <button class="w-32 h-8 text-xs md:text-sm rounded-lg text-white bg-[#000000] mt-1" @click="updateRanges()" ><p class="flex pl-2">
                    <p class="flex md:pl-1 text-2xl font-bold">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                        </svg>
                    </p>
                    <dt class="md:pl-2 pt-[4px]">Update </dt></p>

                </button>          
            </template>
    </ModalPopUp>
</template>

<script>
import { ref, useSlots,computed, onMounted,inject } from 'vue'
import Alert from '../../components/alert.vue'
import ModalPopUp from './../ModalPopUp.vue'
import { useUserStore } from '../../stores/auth'
import { uiChangesStore } from '../../stores/ui_changes'
import {studentsMarksStore} from '../../stores/student_marks'


export default {
      name:"setGrades",
      components:{
      ModalPopUp,
      Alert
   },
      setup() {
        const swal = inject('$swal')
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

        const gradeLists = ref([
            {
            'from':100,
            'to':70
            },
            {
            'from':69,
            'to':65
            },
            {
            'from':64,
            'to':60
            },
            {
            'from':59,
            'to':50
            },
            {
            'from':49,
            'to':40
            },
            {
            'from':39,
            'to':20
            },
            {
            'from':19,
            'to':0
            },


        ])

        const formData = ref({
              school_id:uiStore.popupDetails.popup_data?.school_id,
              class_id:uiStore.popupDetails.popup_data?.class_id,
              teacher_id:uiStore.popupDetails.popup_data?.account_id,
              course_id:uiStore.popupDetails.popup_data?.course_id,
              term:uiStore.popupDetails.popup_data?.term,

              gradeA_from:gradeLists.value[0].from,
              gradeA_to:gradeLists.value[0].to,

              gradeB_from:gradeLists.value[1].from,
              gradeB_to:gradeLists.value[1].to,
              
              gradeC_from:gradeLists.value[2].from,
              gradeC_to:gradeLists.value[2].to,

              gradeD_from:gradeLists.value[3].from,
              gradeD_to:gradeLists.value[3].to,

              gradeE_from:gradeLists.value[4].from,
              gradeE_to:gradeLists.value[4].to,

              gradeS_from:gradeLists.value[5].from,
              gradeS_to:gradeLists.value[5].to,

              gradeF_from:gradeLists.value[6].from,
              gradeF_to:gradeLists.value[6].to,

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
            if(studentsMarksStores.successMessage!=""){
                swal({
                    icon: 'success',
                    title: '',
                    text: studentsMarksStores.successMessage,
                    });  
            }
            return studentsMarksStores.successMessage
        });

        function convertMaximumPoints(){
            if(formData.value.term_quiz >0 || formData.value.term_exam >0)
                   return studentsMarksStores.convertMaximumPoints(formData.value)
            else
                    swal({
                    icon: 'error',
                    title: 'Oops...',
                    text: "Marks less than 1 point not allowed",
                    });       
        }

        function changeToGrade(grade){
            let inputVal = event.target.value
            if(grade =='gradeA')
            {
                if(inputVal < parseInt(formData.value.gradeA_from))
                {
                    formData.value.gradeB_from = inputVal - 1
                }
                else {
                    formData.value.gradeA_to = formData.value.gradeA_from -1
                }
            }
            else if(grade =='gradeB')
            {

                if(inputVal < parseInt(formData.value.gradeB_from))
                {
                    formData.value.gradeC_from = inputVal - 1

                }
                else {
                    formData.value.gradeB_to = formData.value.gradeB_from -1
                }
            }
            else if(grade =='gradeC')
            {
                if(inputVal < formData.value.gradeC_from)
                {
                    formData.value.gradeD_from = inputVal - 1
                }
                else {
                    formData.value.gradeC_to = formData.value.gradeC_from -1
                }
                
            }
            else if(grade =='gradeD')
            {
                if(inputVal < formData.value.gradeD_from)
                {
                    formData.value.gradeE_from = inputVal - 1
                }
                else {
                    formData.value.gradeD_to = formData.value.gradeD_from -1
                }
            }
            else if(grade =='gradeE')
            {
                if(inputVal < formData.value.gradeE_from)
                {
                    formData.value.gradeS_from = inputVal - 1                
                }
                else {
                    formData.value.gradeE_to = formData.value.gradeE_from -1
                }
                
            }
            else if(grade =='gradeS')
            {
                if(inputVal < formData.value.gradeS_from)
                {
                    formData.value.gradeF_from = inputVal - 1               
                }
                else {
                    formData.value.gradeS_to = formData.value.gradeS_from -1
                }
            }
        }

        function updateRanges(){
             studentsMarksStores.successMessage = ""
             return studentsMarksStores.savePointsRanges(formData.value)
        }

        function getRanges(){
            studentsMarksStores.getPointsRanges(formData.value)
            setTimeout(function (){
                if(studentsMarksStores.ranges.points_ranges)
                {
                    formData.value.gradeA_from = studentsMarksStores.ranges.points_ranges?.gradeA.split(',')[0]
                    formData.value.gradeA_to = studentsMarksStores.ranges.points_ranges?.gradeA.split(',')[1]

                    formData.value.gradeB_from = studentsMarksStores.ranges.points_ranges?.gradeB.split(',')[0]
                    formData.value.gradeB_to = studentsMarksStores.ranges.points_ranges?.gradeB.split(',')[1]

                    formData.value.gradeC_from = studentsMarksStores.ranges.points_ranges?.gradeC.split(',')[0]
                    formData.value.gradeC_to = studentsMarksStores.ranges.points_ranges?.gradeC.split(',')[1]

                    formData.value.gradeD_from = studentsMarksStores.ranges.points_ranges?.gradeD.split(',')[0]
                    formData.value.gradeD_to = studentsMarksStores.ranges.points_ranges?.gradeD.split(',')[1]

                    formData.value.gradeE_from = studentsMarksStores.ranges.points_ranges?.gradeE.split(',')[0]
                    formData.value.gradeE_to = studentsMarksStores.ranges.points_ranges?.gradeE.split(',')[1]

                    formData.value.gradeS_from = studentsMarksStores.ranges.points_ranges?.gradeS.split(',')[0]
                    formData.value.gradeS_to = studentsMarksStores.ranges.points_ranges?.gradeS.split(',')[1]

                    formData.value.gradeF_from = studentsMarksStores.ranges.points_ranges?.gradeF.split(',')[0]
                    formData.value.gradeF_to = studentsMarksStores.ranges.points_ranges?.gradeF.split(',')[1]
                }
           
            },1000)
        }

    
        onMounted(() => {
            if(store.getUserData())
            {
                successFeedbackStatus.value = true
                errorFeedbackStatus.value = true
                studentsMarksStores.successMessage = ""
                setTimeout(function (){
                    formData.value.school_id = store.userDetails.school_id
                    getRanges()
                },1000);
            }
         })
        
        return {slotData,loadingStatus,errorStatus,successStatus,closeFeedback,successFeedbackStatus,errorFeedbackStatus,popupDetails,convertMaximumPoints,selected,selectType,formData,maximumPoints,gradeLists,changeToGrade,updateRanges}
       },
    }
    </script>

    