import { defineStore } from 'pinia'

export const uiChangesStore = defineStore("ui_changes", {
    state: () => ({
        isMenuClicked : false,
        isPopUpOpened : false,
        popup_type:'',
        to:''
    }),
    getters: {
    },
    actions: {
        isLeftMenuSelected (status)
        {
          this.isMenuClicked = status
        },
        openPopUpFunc(popup_type = "",to = ""){
           this.isPopUpOpened =! this.isPopUpOpened
           this.popup_type = popup_type
           this.to = to
        },
    },
})