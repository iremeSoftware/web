import { defineStore } from 'pinia'

export const uiChangesStore = defineStore("ui_changes", {
    state: () => ({
        isMenuClicked : false,
        isPopUpOpened : false,
        popup_type:'',
    }),
    getters: {
    },
    actions: {
        isLeftMenuSelected (status)
        {
          this.isMenuClicked = status
        },
        openPopUpFunc(popup_type = ""){
           this.isPopUpOpened =! this.isPopUpOpened;
           this.popup_type = popup_type;
        },
    },
})