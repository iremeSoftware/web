
<template >
    <div class="w-full flex" >
      <sidebarVue />
      <div class="w-full md:w-5/6">
        <Header2 />
        <div class="pl-2 md:pl-[20%] pt-[22%] md:pt-[8%]">
          <!-- <h1 class="text-16px md:text-3xl font-semibold text-transparent bg-clip-text bg-gradient-to-l from-[#8fcc53] to-[#0171c0]">
            👋 Welcome to {{ getUsers.school_name }}
            </h1> -->
            <Alert v-if="successStatus !='' && successFeedbackStatus ==false" :message="successStatus"  type="success" :closeMethod="closeFeedback"/>

            <Alert  v-if="errorStatus !='' && errorFeedbackStatus ==false" :message="errorStatus.message" type="danger" :closeMethod="closeFeedback"/>


            <p class="flex text-16px md:text-2xl font-semibold">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 mt-1">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z" />
                </svg> &nbsp;&nbsp;Manage Students Points
                 ({{ classroomDetails!=undefined ? classroomDetails.classroom_name : '' }})
  
            </p>
        </div>
        <DataTable>

          <template v-slot:searchInput>
            <input type="text" class="w-full mt-1 h-[28px] md:h-10 ring-1 ring-[#000000] rounded-tl rounded-bl placeholder:p-1 placeholder:font-light  enabled:p-2" @keyup="clearSearch()" placeholder="Search student here" v-model="formData.student_name">
            <button @click="searchStudents()" class="w-12 h-[30px] md:h-[42px] mt-[3px] text-sm text-white bg-[#000000] rounded-tr rounded-br"><p class="flex pl-2 pt-[1px]"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
              <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
              </svg>
              </p></button>
          </template>
          <template v-slot:columnsToShow>

            <div class="flex overflow-x-auto">
            <button class="w-48 h-8 text-xs md:text-sm rounded-lg text-white bg-[#000000]" @click="showPopUp('set_maximum_points','','','',formData)" ><p class="flex pl-2">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
              <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
              <dt class="md:pl-3 pt-1 truncate">Set Maximum Points </dt></p>
            </button>
            <button class="ml-2 w-44 h-8 text-xs md:text-sm rounded-lg text-white bg-[#000000]" @click="showPopUp('convert_maximum_points','','','',formData)"><p class="flex pl-2">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
              <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
              </svg>
              <dt class="md:pl-3 pt-1 truncate">Convert Points </dt></p>
            </button>
            <button class="ml-2 w-48 h-8 text-xs md:text-sm rounded-lg text-white bg-[#000000]" :disabled="isLoading" @click="importStudents"><p class="flex pl-2">
              <svg v-if="isLoading==false" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5" />
              </svg>
              <svg v-else class="animate-spin text-black h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" ></circle><path class="opacity-75" fill="currentColor"
                              d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
              </svg>
              <dt class="md:pl-3 pt-1 truncate">Import Students</dt></p>
            </button>
          </div>
          </template>
          <template v-slot:table>
            <div class="flex overflow-x-auto h-14">
            <p class="text-sm md:text-md font-semibold text-left mt-2 pr-2">Show:</p>
            <select @change="setNumberOfRecords()"  name='select_user_role' v-model="formData.limit" class="h-6 md:h-9  rounded-lg bg-transparent ring-1 ring-[#000000] mt-1  md:enabled:p-2 enabled:font-light " id="formData.select_user_role">
              <option>10</option>
              <option>25</option>
              <option>50</option>
              <option>100</option>
            </select>
          <p class="text-sm md:text-md font-semibold text-left mt-2 pl-2">entries</p>
          <div class="hidden md:block border-l-[4px] -mt-1 ml-8 mr-14"></div>
          <p class="ml-10 md:ml-2 text-sm md:text-md font-semibold text-left mt-2 pr-2">Select Term:</p>
          <select  name='select_user_role' @change="setCurrentTerm()"  class="h-6 md:h-9  rounded-lg  bg-transparent ring-1 ring-[#000000] mt-1  md:enabled:p-2 enabled:font-light md:ml-4 " v-model="formData.term">
            <option v-for="term in termList" :value="term.term_no">
              {{ term.term_name }}
            </option>
          </select>

          <div class="hidden md:block border-l-[4px] -mt-1 ml-8 mr-14"></div>
          <p class="ml-10 md:ml-2 text-sm md:text-md font-semibold text-left mt-2 pr-2">Select Course:</p>
          <select  name='select_user_role'  class="h-6 md:h-9  rounded-lg  bg-transparent ring-1 ring-[#000000]  md:enabled:p-2 enabled:font-light mt-1 md:ml-4 "  v-model="formData.course_id" @change="setCourse()">
                    <option v-for="course in getCoursesList" :value="course.course_id">{{ course.course_name }}</option>
          </select>

          <div class="hidden md:block border-l-[4px] -mt-1 ml-8 mr-14"></div>
          <p class="ml-10 md:ml-2 text-sm md:text-md font-semibold text-left mt-2 pr-2">Sort Records:</p>
          <select  name='select_user_role'  class="h-6 md:h-9  rounded-lg  bg-transparent ring-1 ring-[#000000]  md:enabled:p-2 enabled:font-light mt-1 md:ml-4 "  v-model="formData.sort_records" @change="sortRecords()">
                    <option v-for="sort in sortList" :value="sort.sort">{{ sort.sort_name }}</option>
          </select>
          </div>
<!-- 
          <input type="hidden" v-set="firstItem = 0">
          <input type="hidden" v-set="lastItem = 0"> -->
         <template v-if="studentsMarks.Marks?.length">
           <div class="md:flex md:flex-wrap">
            <StudentPointsCard v-for="student,i in studentsMarks.Marks">
            <template v-slot:rank>
              <!-- <input v-if="i==0" type="hidden" v-set="firstItem = (i + studentsMarks.offset) +1">
              <input  type="hidden" v-set="lastItem = (i + studentsMarks.offset) +1"> -->
              <dt v-if="formData.term ==1">{{ student.rank_term1 }}/{{ studentsMarks.no_of_students  }}  </dt>
              <dt v-else-if="formData.term ==2">{{ student.rank_term2 }}/{{ studentsMarks.no_of_students  }}</dt>
              <dt v-else="formData.term ==1">{{ student.rank_term3 }}/{{ studentsMarks.no_of_students  }}</dt>

            </template>
            <template v-slot:student_name>
              <dt class="truncate">{{ (i + studentsMarks.offset)+1 }}. {{ student.name }}</dt></template>
            <template v-slot:quiz_points>
              <input type='number' class='w-20 h-10 ml-4 md:ml-2 ring-1 ring-[#000000]  enabled:p-2' :class="inputQuizError[i]"  v-model="quiz_marks[i]" @input="validateInput('quiz',i,student)"  />
                  <p class="pl-2 pt-2 h-10 text-lg font-bold"> <dt v-if="getQuizMaximum">/ {{ getQuizMaximum }}</dt></p>
            </template>
            <template v-slot:exam_points>
                  <input type='number' class='w-20 h-10 ml-3 md:ml-2 ring-1 ring-[#000000]  enabled:p-2'  v-model="exam_marks[i]" @input="validateInput('exam',i,student)" :class="inputExamError[i]"   />
                  <p v-if="formData.term ==1" class="pl-4 pt-2 h-10 text-lg font-bold"> / {{ maximumPoints.Out_of_marks?.term1_exam }}</p>
                  <p v-else-if="formData.term ==2" class="pl-4 pt-2 h-10 text-lg font-bold"> / {{ maximumPoints.Out_of_marks?.term2_exam }}</p>
                  <p v-else class="pl-4 pt-2 h-10 text-lg font-bold"> / {{ maximumPoints.Out_of_marks?.term3_exam }}</p>

                  <button @click="updateStudentMarks(i,student)" class="absolute w-8 md:w-12 h-8  md:h-12 rounded-full bg-black text-white text-center pl-2 md:pl-3 text-2xl md:mt-2 ml-[60%] md:ml-[13%]">
                    <p class="flex md:pl-1 text-2xl font-bold">
                      +
                    </p>
                  </button>
          </template>
           
          <template v-slot:total_quiz_points>Total CAT Points: 
            <template  v-if="formData.term ==1">
                {{ student.term1_quiz }} / {{ maximumPoints.Out_of_marks?.term1_quiz }}
            </template> 
            <template  v-else-if="formData.term ==2">
                {{ student.term2_quiz }} / {{ maximumPoints.Out_of_marks?.term2_quiz }}
            </template> 
            <template  v-else>
                {{ student.term3_quiz }} / {{ maximumPoints.Out_of_marks?.term3_quiz }}
            </template> 
          </template>

          <template v-slot:total_exam_points>Total Exam Points:  
            <template  v-if="formData.term ==1">
              {{ student.term1_exam }} /  {{ maximumPoints.Out_of_marks?.term1_exam }}
            </template>
            <template v-else-if="formData.term ==2">
              {{ student.term2_exam }} / {{ maximumPoints.Out_of_marks?.term2_exam }}
            </template>
            <template  v-else>
              {{ student.term3_exam }} / {{ maximumPoints.Out_of_marks?.term3_exam }}
            </template>
          </template>
        </StudentPointsCard>

           </div>
        
      </template>
      <template v-else >
        <div class="w-full h-10 text-lg text-center rounded-md background-transparent ring-2 ring-[#000000] mt-10 pl-4 pt-2 "><p>There is no student imported</p></div>
      </template>

</template>
<template v-slot:printBtns>
  <div class="flex text-xs md:text-sm space-x-4">
          <button class="w-44 h-8 md:h-10 text-xs md:text-sm rounded-md ring-2 ring-black mb-4" @click="print_pdf"><p class="flex pl-2  space-x-2">
            <svg viewBox="0 0 384 512" class="w-6 h-6 bg-white" xmlns="http://www.w3.org/2000/svg"><path  d="M369.9 97.9L286 14C277 5 264.8-.1 252.1-.1H48C21.5 0 0 21.5 0 48v416c0 26.5 21.5 48 48 48h288c26.5 0 48-21.5 48-48V131.9c0-12.7-5.1-25-14.1-34zM332.1 128H256V51.9l76.1 76.1zM48 464V48h160v104c0 13.3 10.7 24 24 24h104v288H48zm250.2-143.7c-12.2-12-47-8.7-64.4-6.5-17.2-10.5-28.7-25-36.8-46.3 3.9-16.1 10.1-40.6 5.4-56-4.2-26.2-37.8-23.6-42.6-5.9-4.4 16.1-.4 38.5 7 67.1-10 23.9-24.9 56-35.4 74.4-20 10.3-47 26.2-51 46.2-3.3 15.8 26 55.2 76.1-31.2 22.4-7.4 46.8-16.5 68.4-20.1 18.9 10.2 41 17 55.8 17 25.5 0 28-28.2 17.5-38.7zm-198.1 77.8c5.1-13.7 24.5-29.5 30.4-35-19 30.3-30.4 35.7-30.4 35zm81.6-190.6c7.4 0 6.7 32.1 1.8 40.8-4.4-13.9-4.3-40.8-1.8-40.8zm-24.4 136.6c9.7-16.9 18-37 24.7-54.7 8.3 15.1 18.9 27.2 30.1 35.5-20.8 4.3-38.9 13.1-54.8 19.2zm131.6-5s-5 6-37.3-7.8c35.1-2.6 40.9 5.4 37.3 7.8z"/></svg>
            <font class="pt-1">See Points Report</font></p>
          </button>
        </div>
  </template>
  <template v-slot:entries>
    <!-- Show {{ firstItem }} to {{ lastItem }} of {{ studentsMarks?.no_of_students }} students -->
  </template>
  
  <template v-slot:pagination>
    
    <div v-if="studentsMarks?.no_of_students" class="flex pt-6 text-end">
            <input v-set="noOfPages = Math.ceil(studentsMarks?.no_of_students / formData.limit)" type="hidden">
            <p class=" font-semibold mt-2 pr-2"> </p>
            <button type="button" class="w-20 h-[30px] md:h-[42px] mt-[3px]   bg-transparent ring-1 ring-black  rounded-tl-lg rounded-bl-lg" :disabled="noOfPages == 1" :class="noOfPages == 1 ?'text-[#737373] bg-gray-200 cursor-not-allowed ':''" @click="selectPage(currentPage-1,noOfPages)">
              Previous
            </button>
            <button v-for="page in noOfPages" type="button" :class="currentPage == page ? 'bg-[#000000] text-white':''" class="w-12 h-[30px] md:h-[42px] mt-[3px]  ring-1 ring-black" @click="selectPage(page,noOfPages)"  >
               {{ page }}
            </button>
            <button type="button" class="w-20 h-[30px] md:h-[42px] mt-[3px]  bg-transparent ring-1 ring-black  rounded-tr-lg rounded-br-lg" :disabled="noOfPages == 1" :class="noOfPages == 1 ?'text-[#737373] bg-gray-200 cursor-not-allowed ':''" @click="selectPage(currentPage+1,noOfPages)">Next
            </button>
          </div>
  </template>
  <template v-slot:migrateSection>

  </template>

  </DataTable>
  
          <div v-if="isLoading" class="absolute top-[60%] left-[50%]">
                      <svg class="animate-spin text-black h-14 w-14" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" ></circle><path class="opacity-75" fill="currentColor"
                              d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                      </svg>
            </div> 
         </div>
    </div>
    </template>
  
  <script>
  import Alert from '../../components/alert.vue'
  import Header2 from '../../components/header2.vue'
  import sidebarVue from '../../components/sidebar.vue'
  import { useUserStore } from '../../stores/auth'
  import { onMounted,ref,computed,watch } from 'vue'
  import { useRoute,useRouter } from 'vue-router'
  import { classroomStore } from '../../stores/classroom'
  import { studentsStore } from '../../stores/students'
  import { uiChangesStore } from '../../stores/ui_changes'
  import confirmationPrompt from '../../components/popup_forms/confirmation_prompt.vue'
  import DataTable from '../../components/DataTable.vue'
  import StudentPointsCard from '../../components/StudentPointsCard.vue'
  import {setPageTitle} from '../../helpers/set_page_title'
  import { coursesStore } from '../../stores/courses'
  import {studentsMarksStore} from '../../stores/student_marks'

  export default {
      name:"studentsMarks",
      components:{
        Alert,
        Header2,
        sidebarVue,
        confirmationPrompt,
        DataTable,
        StudentPointsCard
     },
    setup() {
      const store = useUserStore()
      const uiStore = uiChangesStore();
      const currentUser = ref([])
      const route = useRoute()
      const router = useRouter()
      const classroomStores = classroomStore()
      const studentsStores = studentsStore()
      const coursesstores = coursesStore()
      const studentsMarksStores = studentsMarksStore()
      const currentPage = ref(1)
      const isSorted = ref(false)
      let studentsList = ref([]) 
      let classroomDetails = ref([]) 
      let studentsMarks = ref([])
      let maximumPoints = ref({})
      let popupDetails = ref({})
      let termList = ref([
        {
          'term_no':1,
          'term_name':'First Term'
        },
        {
          'term_no':2,
          'term_name':'Second Term'
        },
        {
          'term_no':3,
          'term_name':'Third Term'
        },
      ])


      let sortList = ref([
        {
          'sort':'name-ASC',
          'sort_name':'Name (A-Z)'
        },
        {
          'sort':'name-DESC',
          'sort_name':'Name (Z-A)'
        },
        {
          'sort':'rank_term-ASC',
          'sort_name':'Rank (First-Last)'
        },
        {
          'sort':'rank_term-DESC',
          'sort_name':'Rank (Last-First)'
        },
      ])

      const inputQuizError = ref([])
      const inputExamError = ref([])
      const hasValidationError = ref([])
      let errorStatus =ref("")


      let getQuizMaximum = ref(localStorage.getItem('quiz_maximum'))

      const formData = ref({
              student_name:"",
              student_id:"",
              school_id:"",
              class_id:ref(route.params.class_id),
              page:1,
              account_id:"",
              course_id:uiStore.popupDetails.course_id ?? localStorage.getItem('course_id'),
              limit:localStorage.getItem('numRows') ?? 10,
              sort_by:'name',
              sort:'ASC',
              term:localStorage.getItem('selectedTerm') ?? termList.value[0].term_no,
              term_quiz:0,
              term_exam:0,
              sort_records:sortList.value[0].sort,
              maximumPoints:{

              }
      });

      let quiz_marks = ref([])
      let exam_marks = ref([])
      const successFeedbackStatus = ref(false)
      const errorFeedbackStatus = ref(false)
      const getUsers = computed(() => {
        currentUser.value = store.userDetails
       return currentUser.value;
      });
  
  
      classroomDetails = computed (() => {
        return classroomStores.classroomDetails
      })
  
      studentsMarks = computed (() => {
        return studentsMarksStores.studentsMarks
      })
  
      const isLoading = computed (() => {
        return studentsMarksStores.loadingUI.isLoading
      })
  
      watch(route,() => {
        formData.value.account_id = store.userDetails.account_id
        formData.value.course_id = localStorage.getItem('course_id') 
        getClassTeacherByClass()
        getCoursesOfTeacherInClass(formData.value)
        getStudentMarks()
        getMaximum()
       });
  
       function getClassTeacherByClass(){
         return classroomStores.getClassTeacherByClass(currentUser.value.school_id,route.params.class_id)
       }

      let isMenuClicked = computed(() => uiStore.isMenuClicked);
  
      const popup_type = computed(() => uiStore.popup_type);
  
      function showPopUp(popup_type,to='',popup_title='',popup_message='',popup_data = {}){
        let popup_records = {
          'popup_title':popup_title,
          'popup_message':popup_message,
          'popup_data':popup_data,
        }
        //toggleSideBar()
        return uiStore.openPopUpFunc(popup_type,to,popup_records);    
      }
  
      function toggleSideBar(){
          isMenuClicked =! isMenuClicked
          return uiStore.isLeftMenuSelected(isMenuClicked)         
      }
  
      popupDetails = computed(() => {
        return uiStore.popupDetails
      })

      getQuizMaximum = computed(() => {
        return studentsMarksStores.quiz_maximum
      })
  
      function deleteAction(){
        formData.value.student_id = uiStore.popupDetails.popup_data.student_id
        uiStore.openPopUpFunc() // Close popup
        return studentsStores.deleteStudent(formData.value)
      }
  
      function checkAuth(){
            console.log(currentUser.value)
            if(store.userDetails != undefined){
              if(!store.userDetails.authentications?.includes('manage_students'))
              {
                router.push('/dashboard/home')
              }
            }
        }


        function getCoursesOfTeacherInClass(data){
           return coursesstores.getCoursesOfTeacherInClass(data)
        }

        const getCoursesList = computed(() => {
            return coursesstores.coursesList.courses
        });

        function setCourse(){
          let course_id=event.target.value;
          localStorage.setItem('course_id',course_id)
          localStorage.removeItem('quiz_maximum')
         // getQuizMaximum.value.quiz_maximum = 0
          formData.value.course_id = course_id
          getStudentMarks()
          getMaximum()
        }

          
       function setNumberOfRecords(){
          localStorage.setItem('numRows',formData.value.limit)
          getStudentMarks()
       }

       function selectPage(num,noOfPages){
          if(num <= noOfPages && num>0) 
          {
            formData.value.page = num
            currentPage.value = num
            getStudentMarks()
          }
       }

        function importStudents(){
            return studentsMarksStores.importStudentMarks(formData.value);
        }

        function getStudentMarks(){
          return studentsMarksStores.getStudentMarks(formData.value);
        }

        function getMaximum(){
          return studentsMarksStores.getMaximumPoints(formData.value);
        }

        maximumPoints = computed(() => 
        {
          formData.value.maximumPoints = studentsMarksStores?.maximumPoints.Out_of_marks
          return studentsMarksStores.maximumPoints
        
        })


        errorStatus = computed(() => {
            errorFeedbackStatus.value = false
            return studentsMarksStores.errorMessage
        });

        function closeFeedback() {
        successFeedbackStatus.value =! successFeedbackStatus.value
        errorFeedbackStatus.value =! errorFeedbackStatus.value
        }

        const successStatus = computed(() => {
            successFeedbackStatus.value = false
            return studentsMarksStores.successMessage
        });

        function searchStudents(){
          if(formData.value.student_name.length >2)
          {
              return studentsMarksStores.searchStudentMarks(formData.value)
          }
        }

        function clearSearch(){
           if(event.which == 8)
           {
             return getStudentMarks()
           }
        }

        function setCurrentTerm(){
          formData.value.term = event.target.value
          localStorage.setItem('selectedTerm',formData.value.term)
          getCoursesOfTeacherInClass(formData.value)
          getStudentMarks()
          getClassTeacherByClass()
          getMaximum()
        }

        function updateStudentMarks(index,student){
          if(hasValidationError.value[index] =="")
          {
            formData.value.term_quiz = quiz_marks.value[index] ?? 0
            formData.value.term_exam = exam_marks.value[index] ?? (formData.value.term ==1 ? student.term1_exam : (formData.value.term ==2 ? student.term2_exam : student.term3_exam))
            formData.value.student_id = student.student_id
            return studentsMarksStores.updateStudentMarks(formData.value)
          }
          else {
            alert(hasValidationError.value[index])
          }
        }

        function sortRecords(){
          let currentSort = event.target.value
          formData.value.sort = currentSort.split('-')[1]
          formData.value.sort_by = currentSort.split('-')[0] =='rank_term'?currentSort.split('-')[0]+formData.value.term:currentSort.split('-')[0]
          localStorage.setItem('currentSort',currentSort)
          getStudentMarks()
      }
      
      function validateInput(type,index,student){
        if(type =='quiz')
        {

            let summation = parseFloat(formData.value.term ==1 ? student.term1_quiz : (formData.value.term ==2 ? student.term2_quiz:student.term3_quiz)) + parseFloat(quiz_marks.value[index])
            if((summation / studentsMarksStores?.maximumPoints.Out_of_marks[
            formData.value.term ==1 ? 'term1_quiz': (formData.value.term ==2 ? 'term2_quiz':'term3_quiz')]) > 1)
            {
              inputQuizError.value[index] = 'w-20 h-10 ml-4 md:ml-2 ring-1 ring-[#ef4444]  enabled:p-2'
              hasValidationError.value[index] = "Error : " + summation+" / "+ studentsMarksStores?.maximumPoints.Out_of_marks[
            formData.value.term ==1 ? 'term1_quiz':(formData.value.term ==2 ? 'term2_quiz':'term3_quiz')]
            }
            else {
              inputQuizError.value[index] = 'w-20 h-10 ml-4 md:ml-2 ring-1 ring-[#000000]'
              hasValidationError.value[index] = ""
            }
        }
        else if(type =='exam')
        {

            let summation = exam_marks.value[index]
            if((summation / studentsMarksStores?.maximumPoints.Out_of_marks[
            formData.value.term ==1 ? 'term1_exam': (formData.value.term ==2 ? 'term2_exam':'term3_exam')]) > 1)
            {
              inputExamError.value[index] = 'w-20 h-10 ml-4 md:ml-2 ring-1 ring-[#ef4444]  enabled:p-2'
              hasValidationError.value[index] = "Error : " + summation+" / "+ studentsMarksStores?.maximumPoints.Out_of_marks[
            formData.value.term ==1 ? 'term1_exam':(formData.value.term ==2 ? 'term2_exam':'term3_exam')]
            }
            else {
              inputExamError.value[index] = 'w-20 h-10 ml-4 md:ml-2 ring-1 ring-[#000000]'
              hasValidationError.value[index] = ""
            }
        }

      }



        
      onMounted(() => {
        setPageTitle(`Students POints (${classroomStores.classroomDetails.classroom_name})`)
        if(store.getUserData())
        {
          setTimeout(function (){
            currentUser.value = store.userDetails
            formData.value.account_id = store.userDetails.account_id  
            formData.value.course_id = localStorage.getItem('course_id')
            let currentSort = localStorage.getItem('currentSort') ?? 'name-ASC'
            formData.value.sort_records = currentSort
            formData.value.sort = currentSort.split('-')[1]
            formData.value.sort_by = currentSort.split('-')[0] =='rank_term'?currentSort.split('-')[0]+formData.value.term:currentSort.split('-')[0]
            checkAuth()
            getCoursesOfTeacherInClass(formData.value)
            getStudentMarks()
            getClassTeacherByClass()
            getMaximum()

          },500);
          
        }
      });
  
      return {currentUser,getUsers,classroomDetails,studentsList,setNumberOfRecords,formData,isLoading,selectPage,currentPage,searchStudents,clearSearch,isSorted,showPopUp,deleteAction,popupDetails,popup_type,getCoursesList,setCourse,importStudents,studentsMarks,maximumPoints,errorStatus,successStatus,closeFeedback,successFeedbackStatus,errorFeedbackStatus,termList,getQuizMaximum,setCurrentTerm,updateStudentMarks,quiz_marks,exam_marks,sortList,sortRecords,validateInput,inputQuizError,inputExamError,hasValidationError}
    }
  }
  </script>
  