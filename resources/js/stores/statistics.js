import { defineStore } from 'pinia'

export const statisticsStore = defineStore("statistics", {
    state: () => ({
        data:{},
        errorMessage : "",
        loadingUI :{
          isLoading:false
        },
    }),
    getters: {
    },
    actions: {
         async getDashboardStistics(){
            let self = this
            self.errorMessage = ""
            self.loadingUI.isLoading = true
            let school_id = localStorage.getItem('school_id') ?? ''
            await axios.get(`statistics/dashboard/${school_id}`).then(function (response) {
                self.data = response.data
                self.loadingUI.isLoading = false
            }).catch(function(err){
              self.errorMessage = err.response.data
              self.loadingUI.isLoading = false
            })

         }
    },
})