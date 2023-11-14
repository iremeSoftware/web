import { defineStore } from 'pinia'

export const uiChangesStore = defineStore("ui_changes", {
    state: () => ({
        isMenuClicked : false,
        isPopUpOpened : false,
        popup_type:'',
        to:'',
        popupDetails: {
            popup_title : "",
            popup_message : "",
            popup_data : {}
        },
        
    }),
    getters: {
    },
    actions: {
        isLeftMenuSelected ()
        {
          this.isMenuClicked =! this.isMenuClicked
        },
        openPopUpFunc(popup_type = "",to = "",popup_records = ""){
           this.isPopUpOpened =! this.isPopUpOpened
           this.popup_type = popup_type
           this.to = to
           this.popupDetails.popup_title = popup_records.popup_title
           this.popupDetails.popup_message = popup_records.popup_message
           this.popupDetails.popup_data = popup_records.popup_data
        },
    },
})