export const validations = function(messages,rules,formData,event = ""){
        let isValidated = []
          for(const prop in rules)
          {
            rules[prop]['validationClass'] = rules[prop]['validationClass'] ?? "ring-2 ring-red-500"
            var getId = document.getElementById('formData.'+prop);
            let originalClass= getId.getAttribute('class') ;
            originalClass = [...new Set(originalClass.split(' '))].join(' ').replaceAll(rules[prop]['validationClass'],"");
            if(rules[prop]['required'])
            {
              if(formData[prop] == "" )
              {
                
                let validationClass= getId.getAttribute('class');
                let className = validationClass +' '+ rules[prop]['validationClass'];
                validationClass = [...new Set(className.split(' '))].join(' ');
                getId.setAttribute("class",validationClass);
                messages[prop]['slot'] =  messages[prop]['required'];
              }
              else
              {
                messages[prop]['slot'] = ""
                getId.setAttribute("class",originalClass)
              }            
              isValidated.push(formData[prop] != "");
            }

            if(rules[prop]['email'])
            {

              if(validateEmail(formData[prop]) == false)
              {
                let validationClass= getId.getAttribute('class');
                let className = validationClass +' '+ rules[prop]['validationClass'];
                validationClass = [...new Set(className.split(' '))].join(' ');
                getId.setAttribute("class",validationClass);
                messages[prop]['slot'] =   messages[prop]['email'] 
                messages[prop]['className'] = rules[prop]['validationClass'];
              }
              else
              {
                messages[prop]['slot'] = ""
                getId.setAttribute("class",originalClass)
              }
              
              isValidated.push(validateEmail(formData[prop]));
            }

            if(rules[prop]['minlength'] != undefined)
            {
              
              if(formData[prop].length < parseInt(rules[prop]['minlength']))
              {
                let validationClass= getId.getAttribute('class');
                let className = validationClass +' '+ rules[prop]['validationClass'];
                validationClass = [...new Set(className.split(' '))].join(' ');
                getId.setAttribute("class",validationClass);
                messages[prop]['slot'] =   messages[prop]['minlength'].replace("$minlength",rules[prop]['minlength']);
                isValidated.push(formData[prop].length < parseInt(rules[prop]['minlength']));

              }
            }
            if(rules[prop]['maxlength'] != undefined)
            {
              let validationClass= getId.getAttribute('class');
              let className = validationClass +' '+ rules[prop]['validationClass'];
              validationClass = [...new Set(className.split(' '))].join(' ');
              getId.setAttribute("class",validationClass);
              getId.setAttribute("maxlength",parseInt(rules[prop]['maxlength']));
              if(formData[prop].length > parseInt(rules[prop]['maxlength']))
              {
                messages[prop]['slot'] =   messages[prop]['maxlength'].replace("$maxlength",rules[prop]['maxlength']);
                isValidated.push(formData[prop].length < parseInt(rules[prop]['maxlength']));

              }
            }

            if(rules[prop]['counter'] != undefined && rules[prop]['maxlength'] != undefined)
            {
              if(rules[prop]['counter'])
              {
                let validationClass= getId.getAttribute('class');
                let className = validationClass +' '+ rules[prop]['validationClass'];
                validationClass = [...new Set(className.split(' '))].join(' ');
                getId.setAttribute("class",validationClass);
                messages[prop]['slot'] =  messages[prop]['counter'].replace("$count",formData[prop].length ?? 0).replace("$maxlength",rules[prop]['maxlength']);
              }
              else
              {
                messages[prop]['slot'] = ""
                getId.setAttribute("class",originalClass);
              }            
            }
            
          }
          return isValidated.toString().includes('false')?false:true;
       }

       function validateEmail(input) {
        var validRegex = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
        return input.match(validRegex) ? true : false;
      }

      export const onlyNumberKey = function (evt) {
        alert(evt.value)
          evt.value = evt.target.value.replace(/[^0-9\.]/g,'');
      }
