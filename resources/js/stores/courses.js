import { defineStore } from 'pinia'
import axios from "../plugins/axios"

export const coursesStore = defineStore("courses", {
    state: () => ({
        coursesList: [],
        successMessage:"",
        errorMessage : "",
        loadingUI :{
          isLoading:false
        },
    }),
    getters: {
      getCourses(state){
        return state.coursesList
      }
    },
    actions: {
        async getcoursesList(school_id,class_id = "") {  
            let self = this;
            self.errorMessage = ""
            self.loadingUI.isLoading = true
            await axios.get(`course/${school_id}?class_id=${class_id}`,{}).then(function (response) {
              self.coursesList = response.data
              self.loadingUI.isLoading = false
            }).catch(function(err){
              self.coursesList = []
              self.errorMessage = err.response.data
              self.loadingUI.isLoading = false
            })
          },

          async createNewCourse(data) {  
            let self = this;
            self.errorMessage = ""
            self.loadingUI.isLoading = true
            await axios.post('course',data).then(function (response) {
              self.successMessage = response.data.message
              self.loadingUI.isLoading = false
            }).catch(function(err){
              self.coursesList = []
              self.errorMessage = err.response.data
              self.loadingUI.isLoading = false
            })
          },

          async updateCourse(school_id,data) {  
            let self = this;
            self.errorMessage = ""
            self.loadingUI.isLoading = true
            await axios.post(`course/update/${school_id}`,data).then(function (response) {
              self.successMessage = response.data.message
              self.loadingUI.isLoading = false
            }).catch(function(err){
              self.coursesList = []
              self.errorMessage = err.response.data
              self.loadingUI.isLoading = false
            })
          },

          async deleteCourse(school_id,data) {  
            let self = this;
            self.errorMessage = ""
            self.loadingUI.isLoading = false
            await axios.post(`course/destroy/${school_id}`,data).then(function (response) {
              self.successMessage = response.data.status
              self.loadingUI.isLoading = false
            }).catch(function(err){
              self.coursesList = []
              self.errorMessage = err.response.data
              self.loadingUI.isLoading = false
            })
          },

          async changeTeachersCourse(data) {  
            let self = this;
            self.errorMessage = ""
            self.loadingUI.isLoading = false
            await axios.post(`change_teacher/${data.school_id}/${data.class_id}`,data).then(function (response) {
              self.successMessage = response.data.message
              self.loadingUI.isLoading = false
            }).catch(function(err){
              self.coursesList = []
              self.errorMessage = err.response.data
              self.loadingUI.isLoading = false
            })
          },

    },
})