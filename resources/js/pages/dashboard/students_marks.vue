
<template >
    <div class="w-full flex" >
      <sidebarVue />
      <div class="w-full md:w-5/6">
        <Header2 />
        <div class="pl-2 md:pl-[20%] pt-[22%] md:pt-[8%]">
          <!-- <h1 class="text-16px md:text-3xl font-semibold text-transparent bg-clip-text bg-gradient-to-l from-[#8fcc53] to-[#0171c0]">
            👋 Welcome to {{ getUsers.school_name }}
            </h1> -->
            <Alert v-if="successStatus !='' && successFeedbackStatus == false" :message="successStatus"  type="success" :closeMethod="closeFeedback"/>

              <Alert  v-if="errorStatus !='' && errorFeedbackStatus ==    false" :message="errorStatus.message " type="danger" :closeMethod="closeFeedback"/>


            <p class="flex text-16px md:text-2xl font-semibold">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 mt-1">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z" />
                </svg> &nbsp;&nbsp;Manage Students Points
                 ({{ classroomDetails!=undefined ? classroomDetails.classroom_name : '' }})
  
            </p>
        </div>
        <DataTable>
          <template v-slot:no_of_records>
            <div class="flex  space-x-2">
            <button class="w-48 h-8 text-xs md:text-sm rounded-lg text-white bg-[#000000]" @click="showPopUp('set_maximum_points','','','',formData)" ><p class="flex pl-2">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
              <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
              <dt class="md:pl-3 pt-1">Set Maximum Points </dt></p>
            </button>
            <button class="w-44 h-8 text-xs md:text-sm rounded-lg text-white bg-[#000000]"><p class="flex pl-2">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
              <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
            </svg>
              <dt class="md:pl-3 pt-1">Convert Points </dt></p>
            </button>
            <button class="w-48 h-8 text-xs md:text-sm rounded-lg text-white bg-[#000000]" :disabled="isLoading" @click="importStudents"><p class="flex pl-2">
              <svg v-if="isLoading==false" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5" />
              </svg>
              <svg v-else class="animate-spin text-black h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" ></circle><path class="opacity-75" fill="currentColor"
                              d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
              </svg>
              <dt class="md:pl-3 pt-1">Import Students</dt></p>
            </button>
            {{ coursesstores?.coursesList.courses?.[0]['course_id'] }}
          </div>
          </template>
          <template v-slot:searchInput>
            <input type="text" class="w-full mt-1 h-[28px] md:h-10 ring-1 ring-[#000000] rounded-tl rounded-bl placeholder:p-1 placeholder:font-light  enabled:p-2" @keyup="clearSearch()" placeholder="Search student here" v-model="formData.student_name">
            <button @click="searchStudents()" class="w-12 h-[30px] md:h-[42px] mt-[3px] text-sm text-white bg-[#000000] rounded-tr rounded-br"><p class="flex pl-2 pt-[1px]"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
              <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
              </svg>
              </p></button>
          </template>
          <template v-slot:columnsToShow>
  
       
          </template>
          <template v-slot:table>
            <div class="md:flex md:flex-wrap">
              <p class=" font-semibold text-left mt-2 pr-2">Show:</p>
            <select @change="setNumberOfRecords()"  name='select_user_role' v-model="formData.limit" class="h-6 md:h-9  rounded-lg bg-transparent ring-1 ring-[#000000]  md:enabled:p-2 enabled:font-light " id="formData.select_user_role">
              <option>10</option>
              <option>25</option>
              <option>50</option>
              <option>100</option>
          </select>
          <p class="text-sm font-semibold text-left mt-2 pl-2">entries</p>
          <div class="border-l-[4px] -mt-1 ml-8 mr-14"></div>
          <p class=" font-semibold text-left mt-2 pr-2">Select Term:</p>
          <select  name='select_user_role' @change="setCurrentTerm()"  class="h-6 md:h-9  rounded-lg  bg-transparent ring-1 ring-[#000000]  md:enabled:p-2 enabled:font-light ml-4 " v-model="formData.term">
            <option v-for="term in termList" :value="term.term_no">
              {{ term.term_name }}
            </option>
          </select>

          <div class="border-l-[4px] -mt-1 ml-8 mr-14"></div>
          <p class=" font-semibold text-left mt-2 pr-2">Select Course:</p>
          <select  name='select_user_role'  class="h-6 md:h-9  rounded-lg  bg-transparent ring-1 ring-[#000000]  md:enabled:p-2 enabled:font-light ml-4 "  v-model="formData.course_id" @change="setCourse()">
                    <option v-for="course in getCoursesList" :value="course.course_id">{{ course.course_name }}</option>
          </select>

          <div class="border-l-[4px] -mt-1 ml-8 mr-14"></div>
          <p class=" font-semibold text-left mt-2 pr-2">Sort Records:</p>
          <select  name='select_user_role'  class="h-6 md:h-9  rounded-lg  bg-transparent ring-1 ring-[#000000]  md:enabled:p-2 enabled:font-light ml-4 "  v-model="formData.sort_records" @change="sortRecords()">
                    <option v-for="sort in sortList" :value="sort.sort">{{ sort.sort_name }}</option>
          </select>

      

      <template v-if="studentsMarks.Marks?.length">
           <input type="hidden" v-set="firstItem = 0">
           <input type="hidden" v-set="lastItem = 0">
        <StudentPointsCard v-for="student,i in studentsMarks.Marks">
           <input v-if="i==0" type="hidden" v-set="firstItem = (i + studentsMarks.offset) +1">
           <input  type="hidden" v-set="lastItem = (i + studentsMarks.offset) +1">
            <template v-slot:rank>
              
              <dt v-if="formData.term ==1">{{ student.rank_term1 }}/{{ studentsMarks.no_of_students  }}</dt>
              <dt v-else-if="formData.term ==2">{{ student.rank_term2 }}/{{ studentsMarks.no_of_students  }}</dt>
              <dt v-else="formData.term ==1">{{ student.rank_term3 }}/{{ studentsMarks.no_of_students  }}</dt>

            </template>
            <template v-slot:student_name>
              <dt>{{ (i + studentsMarks.offset)+1 }}. {{ student.name }}</dt></template>
            <template v-slot:quiz_points>
              <input type='number' class='w-20 h-10 ml-4 md:ml-2 ring-1 ring-[#000000]  enabled:p-2' v-model="quiz_marks[i]"  />
                  <p class="pl-2 pt-2 h-10 text-lg font-bold"> <dt v-if="getQuizMaximum">/ {{ getQuizMaximum }}</dt></p>
            </template>
            <template v-slot:exam_points>
                  <input type='number' class='w-20 h-10 ml-3 md:ml-2 ring-1 ring-[#000000]  enabled:p-2'  v-model="exam_marks[i]" />
                  <p v-if="formData.term ==1" class="pl-4 pt-2 h-10 text-lg font-bold"> / {{ maximumPoints.Out_of_marks?.term1_exam }}</p>
                  <p v-else-if="formData.term ==2" class="pl-4 pt-2 h-10 text-lg font-bold"> / {{ maximumPoints.Out_of_marks?.term2_exam }}</p>
                  <p v-else class="pl-4 pt-2 h-10 text-lg font-bold"> / {{ maximumPoints.Out_of_marks?.term3_exam }}</p>

                  <button @click="updateStudentMarks(i,student.student_id)" class="absolute w-8 md:w-12 h-8  md:h-12 rounded-full bg-black text-white text-center pl-2 md:pl-3 text-2xl md:mt-2 ml-[60%] md:ml-[13%]">
                    <p class="flex md:pl-1 text-2xl font-bold">
                      +
                    </p>
                  </button>
          </template>
           
          <template v-slot:total_quiz_points>Total Quiz Points: 
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
      </template>
      <template v-else >
        <div class="w-full h-10 text-lg text-center rounded-md background-transparent ring-2 ring-[#000000] mt-10 pl-4 pt-2 "><p>There is no student imported</p></div>
      </template>
</div>
</template>
  <template v-slot:entries>
    Show {{ firstItem }} to {{ lastItem }} of {{ studentsMarks?.no_of_students }} students
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
  <template v-slot:printBtns>

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
        toggleSideBar()
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
          getQuizMaximum.value.quiz_maximum = 0
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


        const errorStatus = computed(() => {
            return studentsMarksStores.errorMessage
        });

        function closeFeedback() {
        successFeedbackStatus.value =! successFeedbackStatus.value
        errorFeedbackStatus.value =! errorFeedbackStatus.value
        }

        const successStatus = computed(() => {
            getStudentMarks()
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

        function updateStudentMarks(index,student_id){
            formData.value.term_quiz = quiz_marks.value[index] ?? 0
            formData.value.term_exam = exam_marks.value[index] ?? 0
            formData.value.student_id = student_id
            return studentsMarksStores.updateStudentMarks(formData.value)
        }

        function sortRecords(){
          let currentSort = event.target.value
          formData.value.sort = currentSort.split('-')[1]
          formData.value.sort_by = currentSort.split('-')[0] =='rank_term'?currentSort.split('-')[0]+formData.value.term:currentSort.split('-')[0]
          localStorage.setItem('currentSort',currentSort)
          getStudentMarks()
        }
        
      onMounted(() => {
        setPageTitle(`Students (${classroomStores.classroomDetails.classroom_name})`)
        if(store.getUserData())
        {
          setTimeout(function (){
            currentUser.value = store.userDetails
            formData.value.account_id = store.userDetails.account_id  
            formData.value.course_id = localStorage.getItem('course_id')
            checkAuth()
            getCoursesOfTeacherInClass(formData.value)
            getStudentMarks()
            getClassTeacherByClass()
            getMaximum()

          },500);
          
        }
      });
  
      return {currentUser,getUsers,classroomDetails,studentsList,setNumberOfRecords,formData,isLoading,selectPage,currentPage,searchStudents,clearSearch,isSorted,showPopUp,deleteAction,popupDetails,popup_type,getCoursesList,setCourse,importStudents,studentsMarks,maximumPoints,errorStatus,successStatus,closeFeedback,successFeedbackStatus,errorFeedbackStatus,termList,getQuizMaximum,setCurrentTerm,updateStudentMarks,quiz_marks,exam_marks,sortList,sortRecords}
    }
  }
  </script>
  