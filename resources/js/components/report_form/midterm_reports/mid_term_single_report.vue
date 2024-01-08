<template>
   <table class="mt-3 w-full  text-[11px] text-left text-gray-500 dark:text-gray-400"  :style="selected_type">
                <tbody class="border mt-2">
                     <tr class="bg-white border-b dark:bg-gray-900 dark:border-gray-700 ">
                      <td rowspan="2" class="px-6 py-4 border" :class="`px-[${padding_steps.px}px] py-[${padding_steps.py}px]`">
                       <b>SUBJECTS</b>
                       </td>
                       <td class="px-6 py-4 border" :class="`px-[${padding_steps.px}px] py-[${padding_steps.py}px]`">
                       <b>MID Term</b>
                       </td>
                       <td colspan="3" class="px-6 py-4 border text-center" :class="`px-[${padding_steps.px}px] py-[${padding_steps.py}px]`">
                       <b>TOTAL</b>
                       </td>
                       <td rowspan="2" class="px-6 py-4 border text-center" :class="`px-[${padding_steps.px}px] py-[${padding_steps.py}px]`">
                        <b>Class Average (%)</b>
                       </td>
                       <td rowspan="2" class="px-6 py-4 border text-center" :class="`px-[${padding_steps.px}px] py-[${padding_steps.py}px]`">
                        <b>Teacher Initials</b>
                       </td>
                     </tr>
                     <tr class="bg-white border-b dark:bg-gray-900 dark:border-gray-700 ">
                      <td class="px-6 py-4 border" :class="`px-[${padding_steps.px}px] py-[${padding_steps.py}px]`">
                       <b>Mks</b>
                       </td>
                       <td class="px-6 py-4 border" :class="`px-[${padding_steps.px}px] py-[${padding_steps.py}px]`">
                        <b>Percentage</b>
                       </td>
                       <td class="px-6 py-4 border" :class="`px-[${padding_steps.px}px] py-[${padding_steps.py}px]`">
                        <b>Aggregate</b>
                       </td>
                       <td class="px-6 py-4 border" :class="`px-[${padding_steps.px}px] py-[${padding_steps.py}px]`">
                        <b>Rank</b>
                       </td>
                     </tr>
                      <input type="hidden" :set="general_CAT_total_marks_term1 = 0">
                      <input type="hidden" :set="general_CAT_total_maximum_term1 = 0">

                      <input type="hidden" :set="general_CAT_total_marks_term2 = 0">
                      <input type="hidden" :set="general_CAT_total_maximum_term2 = 0">

                      <input type="hidden" :set="general_CAT_total_marks_term3 = 0">
                      <input type="hidden" :set="general_CAT_total_maximum_term3 = 0">

                      <input type="hidden" :set="total_aggregate = 0">
                      <input type="hidden" :set="total_average = 0">




                     <tr v-for="marks in getStudentRanks?.Marks" class="bg-white border-b dark:bg-gray-900 dark:border-gray-700 ">
                      <td class="px-6 py-4 border" >
                       <p class="w-24 truncate">{{ marks.course_name }}</p>
                       </td>
                       <td class="px-6 py-4 border" >
                       <input type="hidden" :set="general_CAT_total_marks_term1 += marks.term1_quiz">
                       <input type="hidden" :set="general_CAT_total_maximum_term1 += marks.out_of_marks_quiz_term1">

                       <input type="hidden" :set="general_CAT_total_marks_term2 += marks.term2_quiz">
                       <input type="hidden" :set="general_CAT_total_maximum_term2 += marks.out_of_marks_quiz_term2">

                       <input type="hidden" :set="general_CAT_total_marks_term3 += marks.term1_quiz">
                       <input type="hidden" :set="general_CAT_total_maximum_term3 += marks.out_of_marks_quiz_term3">
                     
                        <template v-if="term ==1">
                        {{ marks.term1_quiz }}/{{ marks.out_of_marks_quiz_term1 }}
                        </template>
                        <template v-else-if="term ==2">
                          {{ marks.term2_quiz }}/{{ marks.out_of_marks_quiz_term2 }}
                        </template>
                        <template v-else>
                          {{ marks.term3_quiz }}/{{ marks.out_of_marks_quiz_term3 }}
                        </template>

                       </td>
                       <input type="hidden" :set="total_maximum_term1 = marks.out_of_marks_quiz_term1">
                       <input type="hidden" :set="total_term1_percentage = (marks.term1_quiz / marks.out_of_marks_quiz_term1) * 100 ">

                       <input type="hidden" :set="total_maximum_term2 = marks.out_of_marks_quiz_term2">
                       <input type="hidden" :set="total_term2_percentage = (marks.term2_quiz / marks.out_of_marks_quiz_term2) * 100 ">

                       <input type="hidden" :set="total_maximum_term3 = marks.out_of_marks_quiz_term3">
                       <input type="hidden" :set="total_term3_percentage = (marks.term3_quiz / marks.out_of_marks_quiz_term3) * 100 ">

                       <td class="px-6 py-4 border" >
                        <template v-if="term == 1">
                          {{ total_term1_percentage.toFixed(1) }}%
                        </template>
                        <template v-else-if="term == 2">
                          {{ total_term2_percentage.toFixed(1) }}%
                        </template>
                        <template v-else>
                          {{ total_term3_percentage.toFixed(1) }}%
                        </template>
                       </td>
                       <td class="px-6 py-4 border" >

                        <template v-if="term == 1">
                        {{ generateGrades(total_term1_percentage, marks?.ranges).value }}
                        </template>
                        <template v-else-if="term == 2">
                        {{ generateGrades(total_term2_percentage, marks?.ranges).value }}
                        </template>
                        <template v-else>
                        {{ generateGrades(total_term3_percentage, marks?.ranges).value }}
                        </template>

                        <input type="hidden" v-if="term==1" :set="total_aggregate += generateGrades(total_term1_percentage, marks?.ranges).value" />
                        <input type="hidden" v-else-if="term==2" :set="total_aggregate += generateGrades(total_term2_percentage, marks?.ranges).value" />
                        <input type="hidden" v-else :set="total_aggregate += generateGrades(total_term3_percentage, marks?.ranges).value" />

                       </td>
                       <td class="px-6 py-4 border" >
                        <template v-if="term == 1">
                          {{ marks.rank1 }}/{{  getStudentRanks?.no_of_students  }}
                        </template>
                        <template v-else-if="term == 2">
                          {{ marks.rank2 }}/{{  getStudentRanks?.no_of_students  }}
                        </template>
                        <template v-else>
                          {{ marks.rank3 }}/{{  getStudentRanks?.no_of_students  }}
                        </template>
                       </td>
                       <td class="px-6 py-4 border" >
                        <input type="hidden" v-if="term ==1" :set="total_term1_class_maximum = total_maximum_term1 * getStudentRanks?.no_of_students ">
                        <input type="hidden" v-else-if="term ==2" :set="total_term2_class_maximum = total_maximum_term2 * getStudentRanks?.no_of_students ">
                        <input type="hidden" v-else :set="total_term3_class_maximum = total_maximum_term3 * getStudentRanks?.no_of_students ">


                        <input type="hidden" v-if="term ==1" :set="class_average_percentage = (marks?.average?.term1_quiz / total_term1_class_maximum ) * 100">
                        <input type="hidden" v-else-if="term ==2" :set="class_average_percentage = (marks?.average?.term2_quiz / total_term2_class_maximum ) * 100">
                        <input type="hidden" v-else :set="class_average_percentage = (marks?.average?.term3_quiz / total_term3_class_maximum ) * 100">

                        <input type="hidden" :set="total_average += class_average_percentage">
                        {{class_average_percentage.toFixed(1) }}%
                       </td>
                       <td class="px-6 py-4 border" >
                          {{ teacherInitials(marks?.teacher?.name) }}
                       </td>
                     </tr>
                     <tr class="bg-white border-b dark:bg-gray-900 dark:border-gray-700 ">
                        <td class="px-6 py-4 border" >
                          <b>TOTAL</b>
                       </td>
                       <td class="px-6 py-4 border" >
                        <b v-if="term ==1">{{ general_CAT_total_marks_term1 }}/{{ general_CAT_total_maximum_term1 }}</b>
                        <b v-else-if="term ==2">{{ general_CAT_total_marks_term2 }}/{{ general_CAT_total_maximum_term2}}</b>
                        <b v-else>{{ general_CAT_total_marks_term3 }}/{{ general_CAT_total_maximum_term3 }}</b>
                       </td>
                       <td class="px-6 py-4 border">
                        <template v-if="term ==1">
                          <input type="hidden" :set="general_total_marks_CAT_EXAM = general_CAT_total_marks_term1">
                          <input type="hidden" :set="general_total_maximum_CAT_EXAM = general_CAT_total_maximum_term1">
                          <b>{{ ((general_total_marks_CAT_EXAM / general_total_maximum_CAT_EXAM) * 100).toFixed(1) }}%</b>
                        </template>
                        <template v-else-if="term ==2">
                          <input type="hidden" :set="general_total_marks_CAT_EXAM = general_CAT_total_marks_term2">
                          <input type="hidden" :set="general_total_maximum_CAT_EXAM = general_CAT_total_maximum_term2">
                          <b>{{ ((general_total_marks_CAT_EXAM / general_total_maximum_CAT_EXAM) * 100).toFixed(1) }}%</b>
                        </template>
                        <template v-else>
                          <input type="hidden" :set="general_total_marks_CAT_EXAM = general_CAT_total_marks_term3">
                          <input type="hidden" :set="general_total_maximum_CAT_EXAM = general_CAT_total_maximum_term3">
                          <b>{{ ((general_total_marks_CAT_EXAM / general_total_maximum_CAT_EXAM) * 100).toFixed(1) }}%</b>
                        </template>
                        
                       </td>
                       <td class="px-6 py-4 border">
                       <b>{{ total_aggregate }}</b>
                       </td>
                       <td class="px-6 py-4 border">
                       </td>
                       <td class="px-6 py-4 border">
                        <input type="hidden" :set="total_average_percentage = (total_average / (getStudentRanks.courses * 100)) * 100" >
                        {{ total_average_percentage.toFixed(1) }}%
                       </td>
                     </tr>
                     <tr class="bg-white border-b dark:bg-gray-900 dark:border-gray-700 ">
                        <td class="px-6 py-4 border">
                          <b>RANK</b>
                       </td>
                       <td colspan="8"  class="px-6 py-4 border text-center">
                        <b v-if="term ==1">{{ getStudentRanks?.Ranks?.rank_quiz_term1 }}/{{getStudentRanks?.no_of_students }}</b>
                        <b v-else-if="term ==2">{{ getStudentRanks?.Ranks?.rank_quiz_term2 }}/{{getStudentRanks?.no_of_students }}</b>
                        <b v-else>{{ getStudentRanks?.Ranks?.rank_quiz_term3 }}/{{getStudentRanks?.no_of_students }}</b>
                       </td>
                     </tr>
                </tbody>
            </table>
</template>
<script>
  import {generateGrades} from '../../../helpers/generate_grades'
  import {teacherInitials} from '../../../helpers/teacher_initials'


export default {
  name:"MidTermSingleReport",
  props: {
    getStudentRanks: Object,
    selected_type:String,
    padding_steps:Object,
    term:Number
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
