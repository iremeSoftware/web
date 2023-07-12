export default{
    validation(messages,rules,formData){
        let isValidated = []
          for(const prop in rules)
          {
            if(rules[prop]['required'])
            {
              if(formData[prop] == "" )
              {
                messages[prop]['slot'] =  messages[prop]['required'];
                messages[prop]['className'] = rules['className'];
              }
              else
              {
                messages[prop]['slot'] = ""
                messages[prop]['className'] = ""
              }            
              isValidated.push(formData[prop] != "");
            }

            if(rules[prop]['email'])
            {
              if(validateEmail(formData[prop]) == false)
              {
                messages[prop]['slot'] =   messages[prop]['email'] 
                messages[prop]['className'] = rules['className'];
              }
              else
              {
                messages[prop]['slot'] = ""
                messages[prop]['className'] = "";
              }
              
              isValidated.push(validateEmail(formData[prop]));
            }

            if(rules[prop]['minlength'] != undefined)
            {
              if(formData[prop].length < parseInt(rules[prop]['minlength']))
              {
                messages[prop]['slot'] =   messages[prop]['minlength'].replace("$minlength",rules[prop]['minlength']);
                messages[prop]['className'] = rules['className'];
                isValidated.push(validateEmail(formData[prop]));

              }
             
            }
            
          }
          return isValidated.toString().includes('false')?false:true;
       },

       validateEmail(input) {
        var validRegex = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;

        if (input.match(validRegex)) {

          return true;

        } else {
          return false;
        }
      }
}