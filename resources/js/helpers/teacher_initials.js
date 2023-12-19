export const teacherInitials = function (teacher_name){
     
    let splited_tr=teacher_name.split(' ');
    let first_letter=splited_tr[0].charAt(0);
    let second_letter=splited_tr[1]!=undefined?splited_tr[1].charAt(0):'';
    let third_letter=splited_tr[2]!=undefined?splited_tr[2].charAt(0):'';
    let teacher_initial =(first_letter+'.'+ second_letter + (third_letter ? '.'+ third_letter : "")).toUpperCase();
      
    return teacher_initial
   
}