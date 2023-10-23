export const generateKey = function (len){
    let text = " "
    let chars = "0123456789"
    
    for( let i=0; i < len; i++ ) {
        text += chars.charAt(Math.floor(Math.random() * chars.length))
    }
   return text
}