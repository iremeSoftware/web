<template>
   <table class="mt-3 w-full  text-[11px] text-gray-500 dark:text-gray-400" :style="selected_type">
                <tbody class="border mt-2">
                     
                     <tr class="bg-white border-b dark:bg-gray-900 dark:border-gray-700 ">
                      <td rowspan="3" class="px-2 py-5 border"  :class="`px-[${padding_steps.px}px] py-[${padding_steps.py}px]`">
                       <b>SUBJECTS</b>
                       </td>
                       <td colspan="3" class="px-2 py-5 border text-center">
                       <b>FIRST TERM</b>
                       </td>
                       <td colspan="3" class="px-2 py-5 border text-center">
                       <b>SECOND TERM</b>
                       </td>
                       <td colspan="6" class="px-2 py-5 border text-center">
                       <b>THIRD TERM</b>
                       </td>
                       <td colspan="2" class="px-2 py-5 border text-center">
                       <b>ANNUAL POINTS</b>
                       </td>
                     </tr>
                     <tr class="bg-white border-b dark:bg-gray-900 dark:border-gray-700 ">
                       <td class="px-2 py-5 border"  :class="`px-[${padding_steps.px}px] py-[${padding_steps.py}px]`">
                       <b>MID</b>
                       </td>
                       <td class="px-2 py-5 border"  :class="`px-[${padding_steps.px}px] py-[${padding_steps.py}px]`">
                       <b>EOT</b>
                       </td>
                       <td class="px-2 py-5 border text-center">
                       <b>TOTAL</b>
                       </td>
                       <td class="px-2 py-5 border"  :class="`px-[${padding_steps.px}px] py-[${padding_steps.py}px]`">
                       <b>MID</b>
                       </td>
                       <td class="px-2 py-5 border"  :class="`px-[${padding_steps.px}px] py-[${padding_steps.py}px]`">
                       <b>EOT</b>
                       </td>
                       <td class="px-2 py-5 border text-center">
                       <b>TOTAL</b>
                       </td>
                       <td class="px-2 py-5 border"  :class="`px-[${padding_steps.px}px] py-[${padding_steps.py}px]`">
                       <b>MID</b>
                       </td>
                       <td class="px-2 py-5 border"  :class="`px-[${padding_steps.px}px] py-[${padding_steps.py}px]`">
                       <b>EOT</b>
                       </td>
                       <td colspan="3" class="px-2 py-5 border text-center">
                       <b>TOTAL</b>
                       </td>
                       <td rowspan="2" class="px-2 py-5 border text-center">
                       <b>CA(%)</b>
                       </td>
                       <td rowspan="2" class="px-2 py-5 border text-center">
                       <b>TOTAL</b>
                       </td>
                       <td rowspan="2"  class="px-2 py-5 border text-center">
                       <b>%</b>
                       </td>
                     </tr>
                     <tr class="bg-white border-b dark:bg-gray-900 dark:border-gray-700 ">
                      <td class="px-2 py-5 border"  :class="`px-[${padding_steps.px}px] py-[${padding_steps.py}px]`">
                       <b>Marks</b>
                       </td>
                       <td class="px-2 py-5 border"  :class="`px-[${padding_steps.px}px] py-[${padding_steps.py}px]`">
                       <b>Marks</b>
                       </td>
                       <td class="px-2 py-5 border"  :class="`px-[${padding_steps.px}px] py-[${padding_steps.py}px]`">
                       <b>Marks</b>
                       </td>
                       <td class="px-2 py-5 border"  :class="`px-[${padding_steps.px}px] py-[${padding_steps.py}px]`">
                       <b>Marks</b>
                       </td>
                       <td class="px-2 py-5 border"  :class="`px-[${padding_steps.px}px] py-[${padding_steps.py}px]`">
                       <b>Marks</b>
                       </td>
                       <td class="px-2 py-5 border"  :class="`px-[${padding_steps.px}px] py-[${padding_steps.py}px]`">
                       <b>Marks</b>
                       </td>
                       <td class="px-2 py-5 border"  :class="`px-[${padding_steps.px}px] py-[${padding_steps.py}px]`">
                       <b>Marks</b>
                       </td>
                       <td class="px-2 py-5 border"  :class="`px-[${padding_steps.px}px] py-[${padding_steps.py}px]`">
                       <b>Marks</b>
                       </td>
                       <td class="px-2 py-5 border"  :class="`px-[${padding_steps.px}px] py-[${padding_steps.py}px]`">
                       <b>Marks</b>
                       </td>
                       <td class="px-2 py-5 border"  :class="`px-[${padding_steps.px}px] py-[${padding_steps.py}px]`">
                        <b>%</b>
                       </td>
                       <td class="px-2 py-5 border"  :class="`px-[${padding_steps.px}px] py-[${padding_steps.py}px]`">
                        <b>Aggr</b>
                       </td>
                     </tr>
                      <input type="hidden" :set="general_CAT_total_marks_term1 = 0">
                      <input type="hidden" :set="general_CAT_total_maximum_term1 = 0">
                      <input type="hidden" :set="general_EXAM_total_marks_term1 = 0">
                      <input type="hidden" :set="general_EXAM_total_maximum_term1 = 0">

                      <input type="hidden" :set="general_CAT_total_marks_term2 = 0">
                      <input type="hidden" :set="general_CAT_total_maximum_term2 = 0">
                      <input type="hidden" :set="general_EXAM_total_marks_term2 = 0">
                      <input type="hidden" :set="general_EXAM_total_maximum_term2 = 0">

                      <input type="hidden" :set="general_CAT_total_marks_term3 = 0">
                      <input type="hidden" :set="general_CAT_total_maximum_term3 = 0">
                      <input type="hidden" :set="general_EXAM_total_marks_term3 = 0">
                      <input type="hidden" :set="general_EXAM_total_maximum_term3 = 0">

                      <input type="hidden" :set="general_total_marks_annual = 0" />
                      <input type="hidden" :set="general_total_marks_annual_maximum = 0" />

                      <input type="hidden" :set="total_aggregate = 0">
                      <input type="hidden" :set="total_average = 0">


                     <tr v-for="marks in getStudentRanks?.Marks" class="bg-white border-b dark:bg-gray-900 dark:border-gray-700 ">
                      <td class="px-[5px] py-[16px] border">
                       <p class="w-24 truncate">{{ marks.course_name }}</p>
                       </td>
                       <input type="hidden" :set="general_CAT_total_marks_term1 += marks.term1_quiz">
                       <input type="hidden" :set="general_CAT_total_maximum_term1 += marks.out_of_marks_quiz_term1">
                       <input type="hidden" :set="general_EXAM_total_marks_term1 += marks.term1_exam">
                       <input type="hidden" :set="general_EXAM_total_maximum_term1 += marks.out_of_marks_exam_term1">

                       <input type="hidden" :set="general_CAT_total_marks_term2 += marks.term2_quiz">
                       <input type="hidden" :set="general_CAT_total_maximum_term2 += marks.out_of_marks_quiz_term2">
                       <input type="hidden" :set="general_EXAM_total_marks_term2 += marks.term2_exam">
                       <input type="hidden" :set="general_EXAM_total_maximum_term2 += marks.out_of_marks_exam_term2">

                       <input type="hidden" :set="general_CAT_total_marks_term3 += marks.term3_quiz">
                       <input type="hidden" :set="general_CAT_total_maximum_term3 += marks.out_of_marks_quiz_term3">
                       <input type="hidden" :set="general_EXAM_total_marks_term3 += marks.term3_exam">
                       <input type="hidden" :set="general_EXAM_total_maximum_term3 += marks.out_of_marks_exam_term3">

                       <td class="px-[5px] py-[16px] border">
                        {{ marks.term1_quiz }}/{{ marks.out_of_marks_quiz_term1 }}
                       </td>
                       <td class="px-[5px] py-[16px] border">
                        {{ marks.term1_exam }}/{{ marks.out_of_marks_exam_term1 }}
                       </td>
                       <td class="px-[5px] py-[16px] border">
                        <input type="hidden" :set="total_term1 = marks.term1_quiz + marks.term1_exam">
                        <input type="hidden" :set="total_maximum_term1 = marks.out_of_marks_quiz_term1 + marks.out_of_marks_exam_term1">
                        <input type="hidden" :set="total_term1_percentage = (total_term1 / total_maximum_term1) * 100 ">
                       {{ total_term1 }}/{{ total_maximum_term1 }}
                       </td>
                       <td class="px-[5px] py-[16px] border">
                        {{ marks.term2_quiz }}/{{ marks.out_of_marks_quiz_term2 }}
                       </td>
                       <td class="px-[5px] py-[16px] border">
                        {{ marks.term2_exam }}/{{ marks.out_of_marks_exam_term2 }}
                       </td>
                       <td class="px-[5px] py-[16px] border">
                        <input type="hidden" :set="total_term2 = marks.term2_quiz + marks.term2_exam">
                        <input type="hidden" :set="total_maximum_term2 = marks.out_of_marks_quiz_term2 + marks.out_of_marks_exam_term2">
                        <input type="hidden" :set="total_term2_percentage = (total_term2 / total_maximum_term2) * 100 ">
                        {{total_term2 }}/{{total_maximum_term2}}
                       </td>
                       <td class="px-[5px] py-[16px] border">
                        {{ marks.term3_quiz }}/{{ marks.out_of_marks_quiz_term3 }}
                       </td>
                       <td class="px-[5px] py-[16px] border">
                        {{ marks.term3_exam }}/{{ marks.out_of_marks_exam_term3 }}
                       </td>
                       <td class="px-[5px] py-[16px] border">
                        <input type="hidden" :set="total_term3 = marks.term3_quiz + marks.term3_exam">
                        <input type="hidden" :set="total_maximum_term3 = marks.out_of_marks_quiz_term3 + marks.out_of_marks_exam_term3">
                        <input type="hidden" :set="total_term3_percentage = (total_term3 / total_maximum_term3) * 100 ">
                        {{total_term3 }}/{{total_maximum_term3}}
                       </td>
                       <td class="px-[5px] py-[16px] border">
                        {{ total_term3_percentage.toFixed(1) }}%
                       </td>
                       <td class="px-[5px] py-[16px] border">
                        {{ generateGrades(total_term3_percentage, marks?.ranges).value }}
                        <input type="hidden" :set="total_aggregate += generateGrades(total_term1_percentage, marks?.ranges).value" />

                       </td>
                       <td class="px-[5px] py-[16px] border">
                        <input type="hidden" :set="total_term3_class_maximum = total_maximum_term3 * getStudentRanks?.no_of_students ">
                        <input type="hidden" :set="class_average_percentage = (marks?.average?.total_term3 / total_term3_class_maximum ) * 100">
                        <input type="hidden" :set="total_average += class_average_percentage">


                        {{class_average_percentage.toFixed(1) }} 
                       </td>
                       <td class="px-[5px] py-[16px] border">
                        <input type="hidden" :set="total_annual = (marks.term1_quiz + marks.term1_exam+marks.term2_quiz + marks.term2_exam+marks.term3_quiz + marks.term3_exam)">

                        <input type="hidden" :set="total_maximum_annual = (marks.out_of_marks_quiz_term1 + marks.out_of_marks_exam_term1 + marks.out_of_marks_quiz_term2 + marks.out_of_marks_exam_term2 + marks.out_of_marks_quiz_term3 + marks.out_of_marks_exam_term3)">

                        <input type="hidden" :set="total_annual_percentage = (total_term3 / total_maximum_term3) * 100 ">

                        {{ total_annual }}/{{ total_maximum_annual  }}
                       </td>
                       <td class="px-[5px] py-[16px] border">
                        {{ total_annual_percentage.toFixed(1) }}%
                       </td>
                       
                     </tr>
                     <tr class="bg-white border-b dark:bg-gray-900 dark:border-gray-700 ">
                        <td class="px-2 py-4 border">
                          <b>TOTAL</b>
                       </td>
                       <td class="px-2 py-4 border">
                        <b>{{ general_CAT_total_marks_term1 }}/{{ general_CAT_total_maximum_term1 }}</b>
                       </td>
                       <td class="px-2 py-4 border">
                       <b>{{ general_EXAM_total_marks_term1 }}/{{ general_EXAM_total_maximum_term1 }}</b>
                       </td>
                       <td class="px-2 py-4 border">
                        <input type="hidden" :set="general_total_marks_CAT_EXAM = general_CAT_total_marks_term1 + general_EXAM_total_marks_term1">
                        <input type="hidden" :set="general_total_maximum_CAT_EXAM = general_CAT_total_maximum_term1 + general_EXAM_total_maximum_term1">

                        <b>{{ general_total_marks_CAT_EXAM }}/{{ general_total_maximum_CAT_EXAM }}</b>
                       </td>


                       <td class="px-2 py-4 border">
                        <b>{{ general_CAT_total_marks_term2 }}/{{ general_CAT_total_maximum_term2 }}</b>
                       </td>
                       <td class="px-2 py-4 border">
                       <b>{{ general_EXAM_total_marks_term2 }}/{{ general_EXAM_total_maximum_term2 }}</b>
                       </td>
                       <td class="px-2 py-4 border">
                        <input type="hidden" :set="general_total_marks_CAT_EXAM_term2 = general_CAT_total_marks_term2 + general_EXAM_total_marks_term2">
                        <input type="hidden" :set="general_total_maximum_CAT_EXAM_term2 = general_CAT_total_maximum_term2 + general_EXAM_total_maximum_term2">
                        <b>{{ general_total_marks_CAT_EXAM_term2 }}/{{ general_total_maximum_CAT_EXAM_term2 }}</b>
                       </td>

                       <td class="px-2 py-4 border">
                        <b>{{ general_CAT_total_marks_term3 }}/{{ general_CAT_total_maximum_term3 }}</b>
                       </td>
                       <td class="px-2 py-4 border">
                       <b>{{ general_EXAM_total_marks_term3 }}/{{ general_EXAM_total_maximum_term3 }}</b>
                       </td>
                       <td class="px-2 py-4 border">
                        <input type="hidden" :set="general_total_marks_CAT_EXAM_term3 = general_CAT_total_marks_term3 + general_EXAM_total_marks_term3">
                        <input type="hidden" :set="general_total_maximum_CAT_EXAM_term3 = general_CAT_total_maximum_term3 + general_EXAM_total_maximum_term3">
                        <b>{{ general_total_marks_CAT_EXAM_term3 }}/{{ general_total_maximum_CAT_EXAM_term3 }}</b>
                       </td>
                       <td class="px-2 py-4 border">
                       <b>{{ ((general_total_marks_CAT_EXAM_term3 / general_total_maximum_CAT_EXAM_term3) * 100).toFixed(1) }}%</b>
                       </td>
                       <td class="px-2 py-4 border"><b>{{ total_aggregate }}</b></td>
                       <td class="px-2 py-4 border">
                        <input type="hidden" :set="total_average_percentage = (total_average / (getStudentRanks.courses * 100)) * 100" >
                        <b>{{ total_average_percentage.toFixed(1) }}%</b>
                       </td>
                       <td class="px-2 py-4 border">
                        <input type="hidden" :set="general_total_marks_annual = (general_CAT_total_marks_term1 + general_EXAM_total_marks_term1 + general_CAT_total_marks_term2 + general_EXAM_total_marks_term2 + general_CAT_total_marks_term3 + general_EXAM_total_marks_term3)">
                        <input type="hidden" :set="general_total_marks_annual_maximum = (general_CAT_total_maximum_term1 + general_EXAM_total_maximum_term1 + general_CAT_total_maximum_term2 + general_EXAM_total_maximum_term2 + general_CAT_total_maximum_term3 + general_EXAM_total_maximum_term3)" />
                        <b>{{ general_total_marks_annual }}/{{ general_total_marks_annual_maximum }}</b>
                       </td>
                       <td class="px-2 py-4 border">
                        <input type="hidden" :set="annual_percentage = (general_total_marks_annual / general_total_marks_annual_maximum ) * 100" />
                        <b>{{ annual_percentage.toFixed() }}%</b>
                       </td>
                     </tr>
                     <tr class="bg-white border-b dark:bg-gray-900 dark:border-gray-700 ">
                        <td class="px-2 py-5 border">
                          <b>RANK</b>
                       </td>
                       <td colspan="3"  class="px-2 py-5 border text-center">
                        <b>{{ getStudentRanks?.Ranks?.rank_term1 }}/{{getStudentRanks?.no_of_students }}</b>
                       </td>
                       <td colspan="3"  class="px-2 py-5 border text-center">
                        <b>{{ getStudentRanks?.Ranks?.rank_term2 }}/{{getStudentRanks?.no_of_students }}</b>
                       </td>
                       <td colspan="6"  class="px-2 py-5 border text-center">
                        <b>{{ getStudentRanks?.Ranks?.rank_term3 }}/{{getStudentRanks?.no_of_students }}</b>
                       </td>
                       <td colspan="2"  class="px-2 py-5 border text-center">
                        <b>{{ getStudentRanks?.Ranks?.rank_annual }}/{{getStudentRanks?.no_of_students }}</b>
                       </td>
                       
                     </tr>
                </tbody>
            </table>
            <table class="mt-3 w-full  text-[10px] text-left text-gray-500 dark:text-gray-400" :style="selected_type">
                <tbody class="border mt-2">
                  <tr class="bg-white border-b dark:bg-gray-900 dark:border-gray-700 ">
                        <td rowspan="2" class="px-2 py-3 border">
                          <b>KEY</b>
                        </td>
                        <td class="px-2 py-3 border">
                          <b>MID: Mid Term Test</b>
                        </td>
                        <td class="px-2 py-3 border">
                          <b>EOT: End of Term Exam</b>
                        </td>
                  </tr>
                  <tr class="bg-white border-b dark:bg-gray-900 dark:border-gray-700 ">
                        <td class="px-2 py-3 border">
                          <b>CA: Class Average</b>
                        </td>
                        <td class="px-2 py-3 border">
                          <b>Aggr: Aggregate</b>
                        </td>
                  </tr>
                </tbody>
            </table>
            <table class="mt-3 w-full  text-[10px] text-left text-gray-500 dark:text-gray-400" :style="selected_type">
                <tbody class="border mt-2">
                  <tr class="bg-white border-b dark:bg-gray-900 dark:border-gray-700 ">
                        <td rowspan="2" class="px-2 py-3 border">
                          <b>DECISION OF JURY</b>
                        </td>
                        <td class="flex px-2 py-3">
                          <b>Promoted</b>
                          <input type="checkbox" class="ml-4 h-[12px] w-[12px]">

                        </td>
                        <td class="px-2 py-3 border">
                          <b>Repeat</b>
                          <input type="checkbox" class="ml-4 h-[12px] w-[12px]">
                        </td>
                  </tr>
                  <tr class="bg-white border-b dark:bg-gray-900 dark:border-gray-700 ">
                    <td class="flex px-2 py-3">
                          <b>Discontinued</b>
                          <input type="checkbox" class="ml-4 h-[12px] w-[12px]">

                        </td>
                        <td class="px-2 py-3 border">
                          <b>Resit</b>
                          <input type="checkbox" class="ml-4 h-[12px] w-[12px]">
                        </td>
                  </tr>
                </tbody>
            </table>
</template>

<script>
  import {generateGrades} from '../../../helpers/generate_grades'
  import {teacherInitials} from '../../../helpers/teacher_initials'


export default {
  name:"ThirdTermSingleReport",
  props: {
    getStudentRanks: Object,
    selected_type:String,
    padding_steps:Object
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
