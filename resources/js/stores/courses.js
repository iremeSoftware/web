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
        async getcoursesList(school_id,class_id = "",page="",limit="") {  
            let self = this;
            self.errorMessage = ""
            self.loadingUI.isLoading = true
            school_id = localStorage.getItem("school_id") ?? ""
            await axios.get(`course/${school_id}?class_id=${class_id}&page=${page}&limit=${limit}`,{}).then(function (response) {
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
            data.school_id = localStorage.getItem("school_id") ?? ""
            await axios.post('course',data).then(function (response) {
              self.successMessage = response.data.message
              self.loadingUI.isLoading = false
              self.getcoursesList(data.school_id)
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
            school_id = localStorage.getItem("school_id") ?? ""
            await axios.post(`course/update/${school_id}`,data).then(function (response) {
              self.successMessage = response.data.message
              self.loadingUI.isLoading = false
            }).catch(function(err){
              self.coursesList = []
              self.errorMessage = err.response.data
              self.loadingUI.isLoading = false
            })
          },

          async searchCourse(school_id,search_query) {  
            let self = this;
            self.errorMessage = ""
            self.loadingUI.isLoading = true
            school_id = localStorage.getItem("school_id") ?? ""
            await axios.post(`course/search/${school_id}?search_query=${search_query}`).then(function (response) {
              self.coursesList = response.data
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
            school_id = localStorage.getItem("school_id") ?? ""
            await axios.post(`course/destroy/${school_id}`,data).then(function (response) {
              self.successMessage = response.data.status
              self.loadingUI.isLoading = false
              self.getcoursesList(school_id)
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
            data.school_id = localStorage.getItem("school_id") ?? ""
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