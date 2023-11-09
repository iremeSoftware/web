export const setPageTitle = function (newTitle) {
    if (document.title != newTitle) {
        document.title = ""
        document.title = import.meta.env.VITE_APP_NAME +' - '+ newTitle
    }
}