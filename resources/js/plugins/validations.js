import {validations} from '../helpers/validations'

export const validate =  {
  install: (app, options) => {
    // inject a globally available $translate() method
    app.config.globalProperties.$validate = (messages,rules,formData) => validations(messages,rules,formData)
 }
} 
