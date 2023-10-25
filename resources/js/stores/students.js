import { defineStore } from 'pinia'
import axios from "../plugins/axios"

export const studentsStore = defineStore("students", {
    state: () => ({
        studentsList: [],
        successMessage:"",
        successMessageArr:[],
        errorMessage : "",
        loadingUI :{
          isLoading:false
        },
    }),
    getters: {
      studentsListGetter(state){
        return state.studentsList
      }
    },
    actions: {
        async getStudentList(data) {  
            let self = this
            self.errorMessage = ""
            self.loadingUI.isLoading = true
            await axios.get(`students/${data.school_id}/${data.class_id}/${data.student_id}?page=${data.page}&limit=${data.limit}&sort=${data.sort}&sort_by=${data.sort_by}`,{}).then(function (response) {
              self.studentsList = response.data
              self.loadingUI.isLoading = false
            }).catch(function(err){
              self.studentsList = []
              self.errorMessage = err.response.data
              self.loadingUI.isLoading = false
            })
          },
          async createStudent(data) {  
            let self = this
            self.errorMessage = ""
            self.loadingUI.isLoading = true
            await axios.post('students',data).then(function (response) {
              self.successMessage = response.data.message
              self.loadingUI.isLoading = false
            }).catch(function(err){
              self.studentsList = []
              self.errorMessage = err.response.data
              self.loadingUI.isLoading = false
            })
          },
          async searchStudent(data) {  
            let self = this
            self.errorMessage = ""
            self.loadingUI.isLoading = false
            await axios.post(`students/search`,data).then(function (response) {
              self.studentsList = response.data;
            }).catch(function(err){
              self.studentsList = []
              self.errorMessage = err.response.data
              self.loadingUI.isLoading = false
            })
          },
          async importStudents(data,frmData) {  
            let self = this
            self.errorMessage = ""
            self.loadingUI.isLoading = true
            
            await axios({
              method: "POST",
              url: `students/${data.school_id}/${data.class_id}/importcsv`,
              data: frmData,
              headers: {
                  "Content-Type": "multipart/form-data",
              },
          }).then(function (response) {
              self.successMessageArr = response.data
              self.loadingUI.isLoading = false
            }).catch(function(err){
              self.studentsList = []
              self.errorMessage = err.response.data
              self.loadingUI.isLoading = false
            })
          },
          async updateStudent(data) {  
            let self = this
            self.errorMessage = ""
            self.loadingUI.isLoading = true
            await axios.post('students/update',data).then(function (response) {
              self.successMessage = response.data.message
              self.loadingUI.isLoading = false
            }).catch(function(err){
              self.studentsList = []
              self.errorMessage = err.response.data
              self.loadingUI.isLoading = false
            })
          },
          async moveStudents(data) {  
            let self = this
            self.errorMessage = ""
            self.loadingUI.isLoading = true
            await axios.post('student/move',data).then(function (response) {
                self.successMessageArr = response.data
                self.loadingUI.isLoading = false
            }).catch(function(err){
              self.studentsList = []
              self.errorMessage = err.response.data
              self.loadingUI.isLoading = false
            })
          },
          async deleteStudent(student_id) {  
            let self = this
            self.errorMessage = ""
            self.loadingUI.isLoading = true
            await axios.post(`students/delete/${student_id}`,data).then(function (response) {
                self.successMessage = response.data.message
                self.loadingUI.isLoading = false
            }).catch(function(err){
              self.studentsList = []
              self.errorMessage = err.response.data
              self.loadingUI.isLoading = false
            })
          },
    },
})