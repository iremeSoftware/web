<template>
   <table class="mt-3 w-full  text-[11px] text-left text-gray-500 dark:text-gray-400"  :style="selected_type">
                <tbody class="border mt-2">
                     <tr class="bg-white border-b dark:bg-gray-900 dark:border-gray-700 ">
                      <td rowspan="2" class="px-3 py-2 border" >
                       <b>SUBJECTS</b>
                       </td>
                       <td class="px-3 py-2 border" >
                       <b>MID</b>
                       </td>
                       <td class="px-3 py-2 border" >
                       <b>EOT</b>
                       </td>
                       <td colspan="4" class="px-3 py-2 border text-center" >
                       <b>TOTAL</b>
                       </td>
                       <td rowspan="2" class="px-3 py-2 border text-center" >
                        <b>CA (%)</b>
                       </td>
                       <td rowspan="2" class="px-3 py-2 border text-center" >
                        <b>Teacher Initials</b>
                       </td>
                     </tr>
                     <tr class="bg-white border-b dark:bg-gray-900 dark:border-gray-700 ">
                      <td class="px-3 py-2 border" >
                       <b>Mks</b>
                       </td>
                       <td class="px-3 py-2 border" >
                       <b>Mks</b>
                       </td>
                       <td class="px-3 py-2 border" >
                       <b>Mks</b>
                       </td>
                       <td class="px-3 py-2 border" >
                        <b>%</b>
                       </td>
                       <td class="px-3 py-2 border" >
                        <b>Aggr</b>
                       </td>
                       <td class="px-3 py-2 border" >
                        <b>Rank</b>
                       </td>
                     </tr>
                      <input type="hidden" :set="general_CAT_total_marks_term1 = 0">
                      <input type="hidden" :set="general_CAT_total_maximum_term1 = 0">

                      <input type="hidden" :set="general_EXAM_total_marks_term1 = 0">
                      <input type="hidden" :set="general_EXAM_total_maximum_term1 = 0">

                      <input type="hidden" :set="total_aggregate = 0">
                      <input type="hidden" :set="total_average = 0">



                     <tr v-for="marks in (is_for_all_students == 'true' ? getStudentRanks:getStudentRanks?.Marks)" class="bg-white border-b dark:bg-gray-900 dark:border-gray-700 " >
                      
                      <td class="px-3 py-3 border" >
                       <p class="w-24 truncate">{{ marks.course_name }}</p>
                       </td>
                       <td class="px-3 py-3 border" >
                       <input type="hidden" :set="general_CAT_total_marks_term1 += marks.term1_quiz">
                       <input type="hidden" :set="general_CAT_total_maximum_term1 += marks.out_of_marks_quiz_term1">

                       {{ marks.term1_quiz }}/{{ marks.out_of_marks_quiz_term1 }}
                       </td>
                       <td class="px-3 py-3 border" >

                        <input type="hidden" :set="general_EXAM_total_marks_term1 += marks.term1_exam">
                        <input type="hidden" :set="general_EXAM_total_maximum_term1 += marks.out_of_marks_exam_term1">
                        {{ marks.term1_exam }}/{{ marks.out_of_marks_exam_term1 }}
                       </td>
                       <td class="px-3 py-3 border" >
                        <input type="hidden" :set="total_term1 = marks.term1_quiz + marks.term1_exam">
                        <input type="hidden" :set="total_maximum_term1 = marks.out_of_marks_quiz_term1 + marks.out_of_marks_exam_term1">
                        <input type="hidden" :set="total_term1_percentage = (total_term1 / total_maximum_term1) * 100 ">


                       {{ total_term1 }}/{{ total_maximum_term1 }}
                       </td>
                       <td class="px-4 py-3 border" >
                        {{ total_term1_percentage.toFixed(1) }}%
                       </td>
                       <td class="px-4 py-3 border" >
                        {{ generateGrades(total_term1_percentage, marks?.ranges).value }}
                        <input type="hidden" :set="total_aggregate += generateGrades(total_term1_percentage, marks?.ranges).value" />
                       </td>
                       <td class="px-4 py-3 border" >
                        {{ marks.rank1 }}/{{  student_total_number  }}
                       </td>
                       <td class="px-4 py-3 border" >
                        <input type="hidden" :set="total_term1_class_maximum = total_maximum_term1 * student_total_number ">
                        <input type="hidden" :set="class_average_percentage = (marks?.average?.total_term1 / total_term1_class_maximum ) * 100">
                        <input type="hidden" :set="total_average += class_average_percentage">


                        {{class_average_percentage.toFixed(1) }} 
                       </td>
                       <td class="px-4 py-3 border" >
                          {{  teacherInitials(marks?.teacher?.name) }}
                       </td>
                     </tr>
                     <tr class="bg-white border-b dark:bg-gray-900 dark:border-gray-700 ">
                        <td class="px-4 py-3 border" >
                          <b>TOTAL</b>
                       </td>
                       <td class="px-4 py-3 border" >
                        <b>{{ general_CAT_total_marks_term1.toFixed(1) }}/{{ general_CAT_total_maximum_term1 }}</b>
                       </td>
                       <td class="px-4 py-3 border" >
                       <b>{{ general_EXAM_total_marks_term1.toFixed(1) }}/{{ general_EXAM_total_maximum_term1 }}</b>
                       </td>
                       <td class="px-4 py-3 border" >
                        <input type="hidden" :set="general_total_marks_CAT_EXAM = general_CAT_total_marks_term1 + general_EXAM_total_marks_term1">
                        <input type="hidden" :set="general_total_maximum_CAT_EXAM = general_CAT_total_maximum_term1 + general_EXAM_total_maximum_term1">
                        <b>{{ general_total_marks_CAT_EXAM.toFixed(1) }}/{{ general_total_maximum_CAT_EXAM }}</b>
                       </td>
                       <td class="px-4 py-3 border">
                       <b>{{ ((general_total_marks_CAT_EXAM.toFixed(1) / general_total_maximum_CAT_EXAM) * 100).toFixed(1) }}%</b>
                       </td>
                       <td class="px-4 py-3 border">
                       <b>{{ total_aggregate }}</b>
                       </td>
                       <td class="px-4 py-3 border">

                       </td>
                       <td class="px-4 py-3 border">
                        <input type="hidden" :set="total_average_percentage = (total_average / ((is_for_all_students == 'true' ? getStudentRanks.length:getStudentRanks?.Marks?.length) * 100)) * 100" >
                        {{ total_average_percentage.toFixed(1) }}% 
                       </td>
                     </tr>
                     <tr class="bg-white border-b dark:bg-gray-900 dark:border-gray-700 ">
                        <td class="px-4 py-3 border">
                          <b>RANK</b>
                       </td>
                       <td colspan="8"  class="px-4 py-3 border text-center">
                        <b>{{  (is_for_all_students == 'true' ? ranks.rank_term1 :  getStudentRanks?.Ranks?.rank_term1) }}/{{student_total_number }}</b>
                       </td>
                       
                     </tr>
                </tbody>
            </table>
            <table class="mt-3 w-full  text-[11px] text-left text-gray-500 dark:text-gray-400" :style="selected_type" >
                <tbody class="border mt-2">
                  <tr class="bg-white border-b dark:bg-gray-900 dark:border-gray-700 ">
                        <td rowspan="2" class="px-4 py-3 border"  >
                          <b>KEY</b>
                        </td>
                        <td class="px-4 py-3 border" >
                          <b>MID: Mid Term Test</b>
                        </td>
                        <td class="px-4 py-3 border" >
                          <b>EOT: End of Term Exam</b>
                        </td>
                  </tr>
                  <tr class="bg-white border-b dark:bg-gray-900 dark:border-gray-700 ">
                        <td class="px-4 py-3 border" >
                          <b>MKS: Marks</b>
                        </td>
                        <td class="px-4 py-3 border" >
                          <b>Aggr: Aggregate</b>
                        </td>
                  </tr>
                </tbody>
            </table>
</template>

<script>
  import {generateGrades} from '../../../helpers/generate_grades'
  import {teacherInitials} from '../../../helpers/teacher_initials'


export default {
  name:"FirstTermSingleReport",
  props: {
    getStudentRanks: Object,
    selected_type:String,
    padding_steps:Object,
    is_for_all_students:String,
    student_total_number:Number,
    ranks:Object
  },
  components:{
    generateGrades,
    teacherInitials
   },
  setup() {
       return {generateGrades,teacherInitials}
   },
}
</script>
