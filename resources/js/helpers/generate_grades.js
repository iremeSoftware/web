export const generateGrades = function (marks,ranges){
    if(parseFloat(marks)<=parseFloat(ranges?.gradeA.split(',')[0])+0.9 && parseFloat(marks) >= parseFloat(ranges?.gradeA.split(',')[1])){
        return {'grade':'A','value':6}
    }
    else if(parseFloat(marks)<parseFloat(ranges?.gradeB.split(',')[0])+0.9 && parseFloat(marks) >= parseFloat(ranges?.gradeB.split(',')[1])){
        return {'grade':'B','value':5}
    }
    else if(parseFloat(marks)<parseFloat(ranges?.gradeC.split(',')[0])+0.9 && parseFloat(marks) >= parseFloat(ranges?.gradeC.split(',')[1])){
        return {'grade':'C','value':4}
    }
    else if(parseFloat(marks)<parseFloat(ranges?.gradeD.split(',')[0])+0.9 && parseFloat(marks) >= parseFloat(ranges?.gradeD.split(',')[1])){
        return {'grade':'D','value':3}
    }
    else if(parseFloat(marks)<parseFloat(ranges?.gradeE.split(',')[0])+0.9 && parseFloat(marks) >= parseFloat(ranges?.gradeE.split(',')[1])){
        return {'grade':'E','value':2}
    }
    else if(parseFloat(marks)<parseFloat(ranges?.gradeS.split(',')[0])+0.9 && parseFloat(marks) >= parseFloat(ranges?.gradeS.split(',')[1])){
        return {'grade':'S','value':1}
    }
    else {
        return {'grade':'F','value':0}
    }
   
}