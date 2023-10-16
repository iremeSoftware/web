import { defineStore } from 'pinia'
import axios from "../plugins/axios"

export const classroomStore = defineStore("classroom", {
    state: () => ({
        classroomList: [],
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
            self.errorMessage = "";
            await axios.get(`classroom/${school_id}`,{}).then(function (response) {
              self.classroomList = response.data;
            }).catch(function(err){
              self.classroomList = [];
              self.errorMessage = err.response.data;
            })
          },
          async createClassroom(data) {  
            let self = this;
            self.errorMessage = "";
            await axios.post('classroom',data).then(function (response) {
              self.successMessage = response.data.message;
            }).catch(function(err){
              self.classroomList = [];
              self.errorMessage = err.response.data;
            })
          },
          async updateClassroom(school_id,data) {  
            let self = this;
            self.errorMessage = "";
            await axios.post(`classroom/update/${school_id}`,data).then(function (response) {
              self.successMessage = response.data.message;
            }).catch(function(err){
              self.classroomList = [];
              self.errorMessage = err.response.data;
            })
          },
          async designateClassroom(data) {  
            let self = this;
            self.errorMessage = "";
            await axios.post('classroom/designate_class_teacher',data).then(function (response) {
              self.successMessage = response.data.status;
            }).catch(function(err){
              self.classroomList = [];
              self.errorMessage = err.response.data;
            })
          },
    },
})