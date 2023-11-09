
<template >
    <template v-if="popup_type =='delete' || popup_type =='migrate' ">
      <confirmationPrompt :popupDetails="popupDetails" :popupAction="popup_type =='delete'?deleteAction:migrateStudents" />
    </template>
  
    
    <div class="w-full flex" >
      <sidebarVue />
      <div class="w-full md:w-5/6">
        <Header2 />
        <div class="pl-2 md:pl-[20%] pt-[22%] md:pt-[8%]">
            <p class="flex text-16px md:text-2xl font-semibold">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" class="w-6 h-6 mt-1">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                </svg> &nbsp;&nbsp;Assign courses to teachers
            </p>
        </div>
        <DataTable>
        <template v-slot:table>
            <div v-for="classroom in getClassroomList" class="w-full h-auto ring-2 ring-black rounded-lg m-4">
                <div class="w-full h-6 bg-black">
                    <input type="hidden" v-set="courses = designatedCourses.filter((el) => el.class_id  == classroom.class_id)">
                    <p class='text-white text-center font-semibold'>{{ classroom.classroom_name }}</p>
                </div>
                <div v-if="courses.length > 0" class="flex flex-wrap p-3 ">
                    <div v-for="course in courses" class="md:w-1/4 h-16 ring-1 ring-black ml-2 mt-2 ">
                        <div class="w-full h-6 bg-transparent ring-1 ring-black text-center font-semibold">
                       {{ course.course_name }} 
                       </div>
                       <div class="text-sm pt-4 pb-4 text-center">
                        {{ course.name }}                       
                        <button class="h-4 w-10 rounded-sm bg-black text-white text-xs" type="button" 
                        @click="showPopUp('assign_courses','','','',{
                        'class_id':classroom.class_id,
                        'teacher_id':course.account_id,
                        'course_id':course.course_id,
                        'classroom_name':classroom.classroom_name,
                        'course_name':course.course_name
                            })" > Edit</button>
                       </div>
                    </div>
                    <div class="m-4">
                      <button @click="showPopUp('assign_courses','','','',{
                        'class_id':classroom.class_id,
                        'classroom_name':classroom.classroom_name
                      })" class="h-10 w-10 bg-[#000000] text-white rounded-full pl-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                      </button> 

                    </div>
                </div>
                <div v-else class="flex flex-wrap p-3 space-x-3 ">
                   <p> There is no assigned courses</p>
                   <button @click="showPopUp('assign_courses','','','',{
                        'class_id':classroom.class_id
                      })" class="h-10 w-10 bg-[#000000] text-white rounded-full pl-2  ">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                    </button> 
                </div>
            </div>
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
  import { useRoute } from 'vue-router'
  import { classroomStore } from '../../stores/classroom'
  import { studentsStore } from '../../stores/students'
  import { uiChangesStore } from '../../stores/ui_changes'
  import confirmationPrompt from '../../components/popup_forms/confirmation_prompt.vue'
  import DataTable from '../../components/DataTable.vue'
  import {setPageTitle} from '../../helpers/set_page_title'

  
  export default {
      name:"AssignCourses",
      components:{
        Alert,
        Header2,
        sidebarVue,
        confirmationPrompt,
        DataTable
     },
    setup() {
      const store = useUserStore()
      const uiStore = uiChangesStore();
      const currentUser = ref([])
      const route = useRoute()
      const classroomStores = classroomStore()
      const studentsStores = studentsStore()
      const currentPage = ref(1)
      let studentsList = ref([]) 

  
      const getUsers = computed(() => {
        currentUser.value = store.userDetails
       return currentUser.value;
      });
  
      const classroomDetails = computed (() => {
        return classroomStores.classroomDetails
      })
  
      studentsList = computed (() => {
        return studentsStores.studentsList
      })
  
      const isLoading = computed (() => {
        return studentsStores.loadingUI.isLoading
      })

      const getClassroomList = computed(() => {
            return classroomStores.classroomList.classrooms;
        });
  
  
      watch(route,() => {
        getDesignatedTeachers()
       })
  
       function setNumberOfRecords(){
          localStorage.setItem('numRows',formData.value.limit)
          getStudentList()
       }
  
      let isMenuClicked = computed(() => uiStore.isMenuClicked);
  
      const popup_type = computed(() => uiStore.popup_type);
  
      function showPopUp(popup_type,to='',popup_title='',popup_message='',popup_data = {}){
        let popup_records = {
          'popup_title':popup_title,
          'popup_message':popup_message,
          'popup_data':popup_data,
        }
        console.log(popup_data)
        toggleSideBar()
            
        return uiStore.openPopUpFunc(popup_type,to,popup_records);    
      }
  
      function toggleSideBar(){
          isMenuClicked =! isMenuClicked
          return uiStore.isLeftMenuSelected(isMenuClicked)         
      }
  
      const popupDetails = computed(() => uiStore.popupDetails)
  
      function deleteAction(){
        formData.value.student_id = uiStore.popupDetails.popup_data.student_id
        uiStore.openPopUpFunc() // Close popup
        return studentsStores.deleteStudent(formData.value)
      }
   
  
      function print_pdf() {
                  var tableData = document.getElementById('dataTable').innerHTML;
          var tag = document.getElementsByTagName('head')[0].innerHTML;
                  var cssHead = 
          tag + `
            <img src='/school_logo/` + store.userDetails.logo + `' width=100 height=100>
            <br>` + store.userDetails.school_name 
            + `<br>` + store.userDetails.school_phone_number 
            + `<br>` + store.userDetails.school_sector 
            +`, `+ store.userDetails.school_district
            +`<br><br>
            <center>
              <h3 class='text-2xl'>Students of `+classroomStores.classroomDetails.classroom_name+`</h3>
              <br><br>
            </center>`;
                  var data = cssHead + tableData;
                  let myWindow = window.open('', '', 'width=1000px,height=1000px');
                  myWindow.innerWidth = screen.width;
                  myWindow.innerHeight = screen.height;
                  myWindow.screenX = 300;
                  myWindow.screenY = 100;
                  myWindow.document.write(data);
                  myWindow.focus();
                  setTimeout(() => {
                      myWindow.print();
                  }, 2000);
              }
              //################################//PRINT PDF#############################################
              //################################PRINT EXCEL FILE########################################
              function print_ms(type) {
          document.getElementsByClassName('colToHide')[0].style.display = 'none'
          var tag = document.getElementsByTagName('head')[0].innerHTML;
          var tableData = document.getElementById('dataTable').innerHTML;
                  var contents = tag 
            + store.userDetails.school_name + `<br>` 
            + store.userDetails.school_phone_number 
            + `<br>` + store.userDetails.school_sector 
            +`, `+ store.userDetails.school_district
            + `<br><br>
            <center>
              <h3 class='text-2xl'>Students of `+classroomStores.classroomDetails.classroom_name+`</h3>
              <br><br>
            </center>
             <br>
             <br>`;
                  contents += tableData;
                  window.open('data:application/vnd.' + type + ',' + encodeURIComponent(contents));
                  e.preventDefault();
              }


        function getDesignatedTeachers()
        {

            const data = {
                'school_id':store.userDetails.school_id,
                'class_id':'empty'
            }
            return classroomStores.designatedTeachers(data)

        }  
            
        let designatedCourses = computed(() => {
                return classroomStores.designatedTeachersList;
        }); 

        
       
        onMounted(() => {
        setPageTitle(`Assign teachers courses`)
        if(store.getUserData())
        {
          setTimeout(function (){
            currentUser.value = store.userDetails
            classroomStores.getClassroomList(store.userDetails.school_id)
            getDesignatedTeachers()
          },500);
          
        }
      });
  
      return {currentUser,getUsers,classroomDetails,studentsList,setNumberOfRecords,isLoading,currentPage,getClassroomList,showPopUp,deleteAction,popupDetails,popup_type,print_pdf,print_ms,getDesignatedTeachers,designatedCourses}
    }
  }
  </script>
  