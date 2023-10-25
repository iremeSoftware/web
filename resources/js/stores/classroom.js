import { defineStore } from 'pinia'
import axios from "../plugins/axios"

export const classroomStore = defineStore("classroom", {
    state: () => ({
        classroomList: [],
        classroomDetails:{},
        successMessage:"",
        errorMessage : "",
        loadingUI :{
          isLoading:false
        },
    }),
    getters: {
      getClassrooms(state){
        return state.classroomList
      }
    },
    actions: {
        async getClassroomList(school_id) {  
            let self = this;
            self.errorMessage = ""
            self.loadingUI.isLoading = true
            await axios.get(`classroom/${school_id}`,{}).then(function (response) {
              self.classroomList = []
              self.classroomList = response.data
              self.loadingUI.isLoading = false
            }).catch(function(err){
              self.classroomList = []
              self.errorMessage = err.response.data
              self.loadingUI.isLoading = false
            })
          },

          async getClassTeacherByClass(school_id,class_id) {  
            let self = this;
            self.errorMessage = ""
            self.loadingUI.isLoading = true
            await axios.get(`classteacher/${school_id}/${class_id}`,{}).then(function (response) {
              self.classroomDetails = response.data.classrooms
              self.loadingUI.isLoading = false
            }).catch(function(err){
              self.classroomDetails = {}
              self.errorMessage = err.response.data
              self.loadingUI.isLoading = false
            })
          },


          async createNewClassroom(data) {  
            let self = this;
            self.errorMessage = ""
            self.loadingUI.isLoading = true
            await axios.post('classroom',data).then(function (response) {
              self.successMessage = response.data.message
              self.loadingUI.isLoading = false
            }).catch(function(err){
              self.classroomList = []
              self.errorMessage = err.response.data
              self.loadingUI.isLoading = false
            })
          },

          async updateClassroom(school_id,data) {  
            let self = this;
            self.errorMessage = ""
            self.loadingUI.isLoading = true
            await axios.post(`classroom/update/${school_id}`,data).then(function (response) {
              self.successMessage = response.data.message
              self.loadingUI.isLoading = false
            }).catch(function(err){
              self.classroomList = []
              self.errorMessage = err.response.data
              self.loadingUI.isLoading = false
            })
          },

          async designateClassroom(data) {  
            let self = this;
            self.errorMessage = ""
            self.loadingUI.isLoading = false
            await axios.post('classroom/designate_class_teacher',data).then(function (response) {
              self.successMessage = response.data.status
              self.loadingUI.isLoading = false
            }).catch(function(err){
              self.classroomList = []
              self.errorMessage = err.response.data
              self.loadingUI.isLoading = false
            })
          },

          async deleteClassroom(school_id,class_id) {  
            let self = this;
            self.errorMessage = ""
            self.loadingUI.isLoading = false
            await axios.post(`classroom/destroy/${school_id}?class_id=${class_id}`,{}).then(function (response) {
              self.successMessage = response.data.message
              self.loadingUI.isLoading = false
            }).catch(function(err){
              self.classroomList = []
              self.errorMessage = err.response.data
              self.loadingUI.isLoading = false
            })
          },

    },
})