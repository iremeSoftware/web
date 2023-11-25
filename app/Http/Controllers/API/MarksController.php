<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Marks;
use App\Models\PointsRanges;
use App\Models\Students;
use App\Models\academic_year;
use App\Models\Courses;
use App\Models\classrooms;
use App\Models\license_keys;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;

class MarksController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth:api");
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
        /**
        * @OA\Get(
        * path="/api/marks/{school_id}/{class_id}/{course_id}/{student_id}",
        * operationId="getStudentMarks",
        * tags={"Get students marks API"},
        * security={
        *  {
        *  "passport": {}},
        *  }, 
        *      @OA\Parameter(
        *         name="school_id",
        *         in="path",
        *         description="School ID",
        *      ),
        *      @OA\Parameter(
        *         name="class_id",
        *         in="path",
        *         description="Class ID",
        *      ),
        *      @OA\Parameter(
        *         name="course_id",
        *         in="path",
        *         description="Course ID or 'all' to get all courses",
        *      ),
        *      @OA\Parameter(
        *         name="student_id",
        *         in="path",
        *         description="Student ID",
        *      ),
        *      @OA\Parameter(
        *         name="limit",
        *         in="query",
        *         description="Limit",
        *      ),
        *      @OA\Parameter(
        *         name="page",
        *         in="query",
        *         description="Page",
        *      ),
        *      @OA\Parameter(
        *         name="sort_by",
        *         in="query",
        *         description="Sort BY",
        *      ),
        *      @OA\Response(
        *          response=201,
        *          description="Students are successfully retrieved",
        *          @OA\JsonContent()
        *       ),
        *      @OA\Response(
        *          response=422,
        *          description="Unprocessable Entity",
        *          @OA\JsonContent()
        *       ),
        *      @OA\Response(response=400, description="Bad request"),
        *      @OA\Response(response=404, description="Resource Not Found"),
        * )
        */
    public function index(Request $request)
    {
        //****Get student marks for all courses by student id FOR SPECIFIED SCHOOL***************
          
        if (
            !empty($request->school_id) &&
            !empty($request->class_id) &&
            $request->course_id == "all" &&
            !empty($request->student_id)
        ) {
            $sort_by = empty($request->sort_by)
                ? "course_name"
                : $request->sort_by;
            $sort = empty($request->sort) ? "ASC" : $request->sort;

            //***********************************UPDATE COURSE RANKS********************* */
            $courses = DB::table("courses")
                ->select("*")
                ->join(
                    "out_of_marks",
                    "out_of_marks.course_id",
                    "=",
                    "courses.course_id"
                )
                ->where([
                    ["out_of_marks.school_id", "=", $request->school_id],
                    ["out_of_marks.class_id", "=", $request->class_id],
                ])
                ->get();

            foreach ($courses as $key => $course) {
                # code...
                $ranks[] = DB::table("marks")
                    ->select(
                        "name",
                        "marks.student_id",
                        "course_name",
                        "marks.course_id",
                        "marks.term1_total_marks",
                        "marks.term2_total_marks",
                        "marks.term3_total_marks"
                    )
                    ->selectRaw(
                        "RANK() OVER (ORDER BY `marks`.`term1_total_marks` DESC) rank_term1"
                    )
                    ->selectRaw(
                        "RANK() OVER (ORDER BY `marks`.`term2_total_marks` DESC) rank_term2"
                    )
                    ->selectRaw(
                        "RANK() OVER (ORDER BY `marks`.`term3_total_marks` DESC) rank_term3"
                    )

                    ->join(
                        "students",
                        "students.student_id",
                        "=",
                        "marks.student_id"
                    )
                    ->join(
                        "courses",
                        "courses.course_id",
                        "=",
                        "marks.course_id"
                    )
                    ->where([
                        ["marks.school_id", "=", $request->school_id],
                        ["marks.course_id", "=", $course->course_id],
                        ["marks.class_id", "=", $request->class_id],
                    ])
                    ->get();

                foreach ($ranks[$key] as $key => $value) {
                    # code...

                    if ($value->student_id == $request->student_id) {
                        $update_ranks[] = DB::table("marks")
                            ->where([
                                ["student_id", "=", $request->student_id],
                                ["class_id", "=", $request->class_id],
                                ["course_id", "=", $value->course_id],
                                ["school_id", "=", $request->school_id],
                            ])
                            ->update([
                                "rank1" => $value->rank_term1,
                                "rank2" => $value->rank_term2,
                                "rank3" => $value->rank_term3,
                            ]);
                    }
                }
            }

            //*********************************//UPDATE COURSE RANKS********************* */

            $ranks_from_view = DB::table("report_form_view")
                ->select("*")
                ->selectRaw("RANK() OVER (ORDER BY `name` ASC) my_id")
                ->selectRaw(
                    "RANK() OVER (ORDER BY `term1_quiz` DESC) rank_quiz_term1"
                )
                ->selectRaw(
                    "RANK() OVER (ORDER BY `term2_quiz` DESC) rank_quiz_term2"
                )
                ->selectRaw(
                    "RANK() OVER (ORDER BY `term3_quiz` DESC) rank_quiz_term3"
                )

                ->selectRaw(
                    "RANK() OVER (ORDER BY `term1_total_marks` DESC) rank_term1"
                )
                ->selectRaw(
                    "RANK() OVER (ORDER BY `term2_total_marks` DESC) rank_term2"
                )
                ->selectRaw(
                    "RANK() OVER (ORDER BY `term3_total_marks` DESC) rank_term3"
                )
                ->selectRaw(
                    "RANK() OVER (ORDER BY `annual_marks` DESC) rank_annual"
                )
                ->where([
                    ["school_id", "=", $request->school_id],
                    ["class_id", "=", $request->class_id],
                ])
                ->get();

            $disciplines = DB::table("disciplines")
                ->select(
                    "name",
                    "disciplines.student_id",
                    "disciplines.class_id",
                    "first_term",
                    "second_term",
                    "third_term"
                )
                ->join(
                    "students",
                    "students.student_id",
                    "=",
                    "disciplines.student_id"
                )
                ->where([["disciplines.student_id", "=", $request->student_id]])
                ->orderBy("name", "ASC")
                ->first();

            for ($i = 0; $i <= $ranks_from_view->count() - 1; $i++) {
                if ($ranks_from_view[$i]->student_id == $request->student_id) {
                    $my_ranks = $ranks_from_view[$i];
                }
            }

            $Marks = DB::table("marks")
                ->select(
                    "name",
                    "marks.term1_quiz",
                    "marks.course_id",
                    "marks.term1_exam",
                    "marks.term1_total_marks",
                    "marks.term2_quiz",
                    "marks.term2_exam",
                    "marks.term2_total_marks",
                    "marks.term3_quiz",
                    "marks.term3_exam",
                    "marks.term3_total_marks",
                    "marks.student_id",
                    "course_name",
                    "rank1",
                    "rank2",
                    "rank3"
                )
                ->selectRaw(
                    "`out_of_marks`.`term1_quiz` as out_of_marks_quiz_term1"
                )
                ->selectRaw(
                    "`out_of_marks`.`term1_exam` as out_of_marks_exam_term1"
                )
                ->selectRaw(
                    "`out_of_marks`.`term1_total_marks` as out_of_marks_term1_total_marks"
                )
                ->selectRaw(
                    "`out_of_marks`.`term2_quiz` as out_of_marks_quiz_term2"
                )
                ->selectRaw(
                    "`out_of_marks`.`term2_exam` as out_of_marks_exam_term2"
                )
                ->selectRaw(
                    "`out_of_marks`.`term2_total_marks` as out_of_marks_term2_total_marks"
                )
                ->selectRaw(
                    "`out_of_marks`.`term3_quiz` as out_of_marks_quiz_term3"
                )
                ->selectRaw(
                    "`out_of_marks`.`term3_exam` as out_of_marks_exam_term3"
                )
                ->selectRaw(
                    "`out_of_marks`.`term3_total_marks` as out_of_marks_term3_total_marks"
                )
                ->join(
                    "students",
                    "students.student_id",
                    "=",
                    "marks.student_id"
                )
                ->join("courses", "courses.course_id", "=", "marks.course_id")
                ->join(
                    "out_of_marks",
                    "out_of_marks.course_id",
                    "=",
                    "marks.course_id"
                )
                ->where([
                    ["marks.school_id", "=", $request->school_id],
                    ["marks.student_id", "=", $request->student_id],
                    ["out_of_marks.class_id", "=", $request->class_id],
                ])
                ->orderBy($sort_by, $sort)
                ->get();

            $data = [
                "pointsranges.school_id" => $request->school_id,
                "pointsranges.class_id" => $request->class_id,
                "term" => $request->term,
            ];

            $PointsRanges = PointsRanges::getData($data);

            $classroom = classrooms::select("classroom_name")
                ->where([["class_id", "=", $request->class_id]])
                ->first();

            $number_of_courses = $Marks->count();
            $number_of_students = $ranks_from_view->count();
            $course = "all";
            $offset = 0;

            return response()->json(
                [
                    "Ranges" => $PointsRanges,
                    "Marks" => $Marks,
                    "Ranks" => $my_ranks,
                    "discipline" => $disciplines,
                    "courses" => $number_of_courses,
                    "no_of_students" => $number_of_students,
                    "offset" => $offset,
                    "course" => $course,
                    "classroom" => $classroom->classroom_name,
                    "message" => "Retrieved successfully",
                ],
                200
            );
        }
        //****Get student marks for all courses by student id FOR SPECIFIED SCHOOL***************

        //**************FETCH STUDENTS FROM CLASSROOM FOR SPECIFIED SCHOOL***************
        else {
              

            $limit = $request->limit;
            $page = $request->page - 1;
            $offset = ceil($limit * $page);
            $sort_by = empty($request->sort_by) ? "name" : $request->sort_by;
            $sort = empty($request->sort) ? "ASC" : $request->sort;

            $all_students = Marks::select("*")
                ->where([
                    ["marks.school_id", "=", $request->school_id],
                    ["class_id", "=", $request->class_id],
                    ["course_id", "=", $request->course_id],
                ])
                ->get();

            $Marks = DB::table("marks")
                ->select(
                    "name",
                    "term1_quiz",
                    "term1_exam",
                    "term1_total_marks",
                    "term2_quiz",
                    "term2_exam",
                    "term2_total_marks",
                    "term3_quiz",
                    "term3_exam",
                    "term3_total_marks",
                    "marks.student_id"
                )

                    ->selectRaw(
                      "RANK() OVER (ORDER BY `term1_quiz` DESC) rank_term1_quiz"
                  )
                  ->selectRaw(
                      "RANK() OVER (ORDER BY `term2_quiz` DESC) rank_term2_quiz"
                  )
                  ->selectRaw(
                      "RANK() OVER (ORDER BY `term3_quiz` DESC) rank_term3_quiz"
                  )


                ->selectRaw(
                    "RANK() OVER (ORDER BY `term1_total_marks` DESC) rank_term1"
                )
                ->selectRaw(
                    "RANK() OVER (ORDER BY `term2_total_marks` DESC) rank_term2"
                )
                ->selectRaw(
                    "RANK() OVER (ORDER BY `term3_total_marks` DESC) rank_term3"
                )
                ->join(
                    "students",
                    "students.student_id",
                    "=",
                    "marks.student_id"
                )
                ->where([
                    ["marks.school_id", "=", $request->school_id],
                    ["classroom", "=", $request->class_id],
                    ["marks.course_id", "=", $request->course_id],
                ])
                ->offset($offset)
                ->limit($limit)
                ->orderBy($sort_by, $sort)
                ->get();

            $course = Courses::select("course_name")
                ->where([["course_id", "=", $request->course_id]])
                ->first();

            $classroom = classrooms::select("classroom_name")
                ->where([["class_id", "=", $request->class_id]])
                ->first();
            $course = $course->course_name;

            $number_of_students = $all_students->count();

            return response()->json(
                [
                    "Marks" => $Marks,
                    "no_of_students" => $number_of_students,
                    "offset" => $offset,
                    "course" => $course,
                    "classroom" => $classroom->classroom_name,
                    "message" => "Retrieved successfully",
                ],
                200
            );
        }
    }


            /**
        * @OA\Get(
        * path="/api/get_marks/all_classes/{school_id}/{class_id}",
        * operationId="getAnnualReportForm",
        * tags={"Get annual report form API"},
        * security={
        *  {
        *  "passport": {}},
        *  }, 
        *      @OA\Parameter(
        *         name="school_id",
        *         in="path",
        *         description="School ID",
        *      ),
        *      @OA\Parameter(
        *         name="class_id",
        *         in="path",
        *         description="Class ID",
        *      ),
        *      @OA\Parameter(
        *         name="limit",
        *         in="query",
        *         description="Limit",
        *      ),
        *      @OA\Parameter(
        *         name="page",
        *         in="query",
        *         description="Page",
        *      ),
        *      @OA\Parameter(
        *         name="sort_by",
        *         in="query",
        *         description="Sort BY",
        *      ),
        *      @OA\Response(
        *          response=201,
        *          description="Students marks are successfully retrieved",
        *          @OA\JsonContent()
        *       ),
        *      @OA\Response(
        *          response=422,
        *          description="Unprocessable Entity",
        *          @OA\JsonContent()
        *       ),
        *      @OA\Response(response=400, description="Bad request"),
        *      @OA\Response(response=404, description="Resource Not Found"),
        * )
        */

    public function all_class(Request $request)
    {
        $sort_by = "course_name";
        $sort = "ASC";
        //$limit=$request->limit;
        //$page=$request->page-1;
        //$offset=ceil($limit*$page);
        $no_of_students = DB::table("students")
            ->select("*")
            ->where([
                ["school_id", "=", $request->school_id],
                ["classroom", "=", $request->class_id],
            ])
            ->get()
            ->count();
        $all_students = DB::table("students")
            ->select("*")
            ->where([
                ["school_id", "=", $request->school_id],
                ["classroom", "=", $request->class_id],
            ])
            //->offset($offset)
            //->limit($limit)
            ->orderBy("name", "ASC")
            ->get();

        $data = [
            "pointsranges.school_id" => $request->school_id,
            "pointsranges.class_id" => $request->class_id,
            "term" => $request->term,
        ];

        $PointsRanges = PointsRanges::getData($data);
        $disciplines = DB::table("disciplines")
            ->select(
                "name",
                "disciplines.student_id",
                "disciplines.class_id",
                "first_term",
                "second_term",
                "third_term"
            )
            ->join(
                "students",
                "students.student_id",
                "=",
                "disciplines.student_id"
            )
            ->where([
                ["disciplines.school_id", "=", $request->school_id],
                ["disciplines.class_id", "=", $request->class_id],
            ])
            //->offset($offset)
            //->limit($limit)
            ->orderBy("name", "ASC")
            ->get();

        $ranks_from_view = DB::table("report_form_view")
            ->select(
                "name",
                "student_id",
                "class_id",
                "term1_maximum_marks",
                "term2_maximum_marks",
                "term3_maximum_marks",
                "annual_maximum_marks"
            )
            ->selectRaw("RANK() OVER (ORDER BY `name` ASC) my_id")
            ->selectRaw(
                "RANK() OVER (ORDER BY `term1_total_marks` DESC) rank_term1"
            )
            ->selectRaw(
                "RANK() OVER (ORDER BY `term2_total_marks` DESC) rank_term2"
            )
            ->selectRaw(
                "RANK() OVER (ORDER BY `term3_total_marks` DESC) rank_term3"
            )
            ->selectRaw(
                "RANK() OVER (ORDER BY `annual_marks` DESC) rank_annual"
            )
            ->where([
                ["school_id", "=", $request->school_id],
                ["class_id", "=", $request->class_id],
            ])
            //->offset($offset)
            //->limit($limit)
            ->get();

        $student_marks = [];

        for ($i = 0; $i <= $all_students->count() - 1; $i++) {
            $Marks = DB::table("marks")
                ->select(
                    "name",
                    "marks.term1_quiz",
                    "marks.course_id",
                    "marks.term1_exam",
                    "marks.term1_total_marks",
                    "marks.term2_quiz",
                    "marks.term2_exam",
                    "marks.term2_total_marks",
                    "marks.term3_quiz",
                    "marks.term3_exam",
                    "marks.term3_total_marks",
                    "marks.student_id",
                    "course_name",
                    "rank1",
                    "rank2",
                    "rank3"
                )
                ->selectRaw(
                    "`out_of_marks`.`term1_quiz` as out_of_marks_quiz_term1"
                )
                ->selectRaw(
                    "`out_of_marks`.`term1_exam` as out_of_marks_exam_term1"
                )
                ->selectRaw(
                    "`out_of_marks`.`term1_total_marks` as out_of_marks_term1_total_marks"
                )
                ->selectRaw(
                    "`out_of_marks`.`term2_quiz` as out_of_marks_quiz_term2"
                )
                ->selectRaw(
                    "`out_of_marks`.`term2_exam` as out_of_marks_exam_term2"
                )
                ->selectRaw(
                    "`out_of_marks`.`term2_total_marks` as out_of_marks_term2_total_marks"
                )
                ->selectRaw(
                    "`out_of_marks`.`term3_quiz` as out_of_marks_quiz_term3"
                )
                ->selectRaw(
                    "`out_of_marks`.`term3_exam` as out_of_marks_exam_term3"
                )
                ->selectRaw(
                    "`out_of_marks`.`term3_total_marks` as out_of_marks_term3_total_marks"
                )
                ->join(
                    "students",
                    "students.student_id",
                    "=",
                    "marks.student_id"
                )
                ->join("courses", "courses.course_id", "=", "marks.course_id")
                ->join(
                    "out_of_marks",
                    "out_of_marks.course_id",
                    "=",
                    "marks.course_id"
                )
                ->where([
                    ["marks.school_id", "=", $request->school_id],
                    ["marks.student_id", "=", $all_students[$i]->student_id],
                    ["out_of_marks.class_id", "=", $request->class_id],
                ])

                ->orderBy($sort_by, $sort)
                ->get();

            $student_marks[$i] = $Marks;
        }

        $classroom = classrooms::select("classroom_name")
            ->where([["class_id", "=", $request->class_id]])
            ->first();

        //$number_of_courses=$Marks->count();
        $course = "all";

        return response()->json(
            [
                "Ranges" => $PointsRanges,
                "Marks" => $student_marks,
                "Ranks" => $ranks_from_view,
                "disciplines" => $disciplines,
                "no_of_students" => $no_of_students,
                "offset" => 0,
                "course" => $course,
                "classroom" => $classroom->classroom_name,
                "message" => "Retrieved successfully",
            ],
            200
        );
    }

    /**
        * @OA\Get(
        * path="/api/assessment/{school_id}/{class_id}",
        * operationId="getAssessmentList",
        * tags={"Get assessment list API"},
        * security={
        *  {
        *  "passport": {}},
        *  },
        *      @OA\Parameter(
        *         name="school_id",
        *         in="path",
        *         description="School ID",
        *      ),
        *      @OA\Parameter(
        *         name="class_id",
        *         in="path",
        *         description="Class ID",
        *      ),
        *      @OA\Parameter(
        *         name="limit",
        *         in="query",
        *         description="Limit",
        *      ),
        *      @OA\Parameter(
        *         name="sort_by",
        *         in="query",
        *         description="Sort By",
        *      ),
        *      @OA\Parameter(
        *         name="sort",
        *         in="query",
        *         description="Sort",
        *      ),
        *      @OA\Response(
        *          response=200,
        *          description="Marks assessment is successfully retrieved",
        *          @OA\JsonContent()
        *       ),
        *      @OA\Response(
        *          response=422,
        *          description="Unprocessable Entity",
        *          @OA\JsonContent()
        *       ),
        *      @OA\Response(response=400, description="Bad request"),
        *      @OA\Response(response=404, description="Resource Not Found"),
        * )
        */

    public function marks_assessment(Request $request)
    {
        $sort_by = $request->sort_by;
        $sort = $request->sort;

        $limit = $request->limit;
        $page = $request->page - 1;
        $offset = ceil($limit * $page);

        $count_all_students = DB::table("students")
            ->select("id", "name", "student_id")
            ->where([
                ["school_id", "=", $request->school_id],
                ["classroom", "=", $request->class_id],
            ])
            ->count();

        $all_students = DB::table("report_form_view")
            ->select("name", "student_id")
            ->selectRaw(
                "RANK() OVER (ORDER BY `term1_total_marks` DESC) rank_term1"
            )
            ->selectRaw(
                "RANK() OVER (ORDER BY `term2_total_marks` DESC) rank_term2"
            )
            ->selectRaw(
                "RANK() OVER (ORDER BY `term3_total_marks` DESC) rank_term3"
            )
            ->selectRaw(
                "RANK() OVER (ORDER BY `annual_marks` DESC) rank_annual"
            )
            ->where([
                $request->search_query != ""
                    ? ["name", "LIKE", "%$request->search_query%"]
                    : ["id", ">", 0],
                ["school_id", "=", $request->school_id],
                ["class_id", "=", $request->class_id],
            ])
            ->offset($offset)
            ->limit($limit)
            ->orderBy($sort, $sort_by)
            ->get();

        $student_marks = [];

        for ($i = 0; $i <= $all_students->count() - 1; $i++) {
            $Marks = DB::table("marks")
                ->select(
                    "marks.course_id",
                    "marks.term1_total_marks",
                    "marks.term2_total_marks",
                    "marks.term3_total_marks",
                    "course_name",
                    "rank1",
                    "rank2",
                    "rank3"
                )
                ->join(
                    "students",
                    "students.student_id",
                    "=",
                    "marks.student_id"
                )
                ->join("courses", "courses.course_id", "=", "marks.course_id")
                ->where([
                    ["marks.school_id", "=", $request->school_id],
                    ["marks.student_id", "=", $all_students[$i]->student_id],
                ])
                ->orderBy("courses.course_name", "ASC")
                ->get();

            $all_students[$i]->courses = $Marks;
        }

        $classroom = classrooms::select("classroom_name")
            ->where([["class_id", "=", $request->class_id]])
            ->first();

        //$number_of_courses=$Marks->count();
        $course = "all";

        return response()->json(
            [
                "Marks" => $all_students,
                "no_of_students" => $count_all_students,
                "offset" => $offset,
                "course" => $course,
                "classroom" => $classroom->classroom_name,
                "message" => "Retrieved successfully",
            ],
            200
        );
    }

        /**
        * @OA\Post(
        * path="/api/marks/average",
        * operationId="getAverageList",
        * tags={"Get average list API"},
        * security={
        *  {
        *  "passport": {}},
        *  },
        *     @OA\RequestBody(
        *         @OA\JsonContent(),
        *         @OA\MediaType(
        *            mediaType="multipart/form-data",
        *            @OA\Schema(
        *               type="object",
        *               required={"school_id","class_id"},
        *               @OA\Property(property="school_id", type="text"),
        *               @OA\Property(property="class_id", type="number"),
        *            ),
        *        ),
        *    ),
        *      @OA\Response(
        *          response=200,
        *          description="Average marks is successfully retrieved",
        *          @OA\JsonContent()
        *       ),
        *      @OA\Response(
        *          response=422,
        *          description="Unprocessable Entity",
        *          @OA\JsonContent()
        *       ),
        *      @OA\Response(response=400, description="Bad request"),
        *      @OA\Response(response=404, description="Resource Not Found"),
        * )
        */

    public function display_average(Request $request)
    {
        $all_students = DB::table("report_form_view")
            ->select("*")
            ->where([
                ["school_id", "=", $request->school_id],
                ["class_id", "=", $request->class_id],
            ])
            ->get();
        $number_of_students = $all_students->count();

        $average_marks = DB::table("marks")
            ->select("marks.course_id", "users.name", "courses.course_name")
            ->selectRaw("SUM(  `marks`.`term1_quiz`) as term1_quiz")
            ->selectRaw("SUM(  `marks`.`term2_quiz`) as term2_quiz")
            ->selectRaw("SUM(  `marks`.`term3_quiz`) as term3_quiz")
            ->selectRaw("SUM(  `marks`.`term1_total_marks`) as total_term1")
            ->selectRaw("SUM(  `marks`.`term2_total_marks`) as total_term2")
            ->selectRaw("SUM(  `marks`.`term3_total_marks`) as total_term3")
            ->join("courses", "courses.course_id", "=", "marks.course_id")
            ->join("users", "users.account_id", "=", "marks.teacher_id")
            ->where([
                ["marks.school_id", "=", $request->school_id],
                ["marks.class_id", "=", $request->class_id],
            ])
            ->distinct()
            ->orderBy("courses.course_name")
            ->groupBy("marks.course_id","users.name","courses.course_name")
            ->get();

        $average_max = DB::table("out_of_marks")
            ->select("out_of_marks.course_id")
            ->selectRaw(
                "(`term1_quiz`)*$number_of_students as total_term1_quiz_max"
            )
            ->selectRaw(
                "(`term2_quiz`)*$number_of_students as total_term2_quiz_max"
            )
            ->selectRaw(
                "(`term3_quiz`)*$number_of_students as total_term3_quiz_max"
            )

            ->selectRaw(
                "(`term1_quiz`+`term1_exam`)*$number_of_students as total_term1_max"
            )
            ->selectRaw(
                "(`term2_quiz`+`term2_exam`)*$number_of_students as total_term2_max"
            )
            ->selectRaw(
                "(`term3_quiz`+`term3_exam`)*$number_of_students as total_term3_max"
            )
            ->join(
                "courses",
                "courses.course_id",
                "=",
                "out_of_marks.course_id"
            )
            ->where([
                ["out_of_marks.school_id", "=", $request->school_id],
                ["out_of_marks.class_id", "=", $request->class_id],
            ])
            ->orderBy("courses.course_name")
            ->get();

        return response()->json(
            ["Marks" => $average_marks, "Average_max" => $average_max],
            200
        );
    }
    /**
     * Display sorted listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
      /**
        * @OA\Get(
        * path="/api/report_form/{school_id}/{class_id}",
        * operationId="getReportFormList",
        * tags={"Get report form sorts API"},
        * security={
        *  {
        *  "passport": {}},
        *  },
        *      @OA\Parameter(
        *         name="school_id",
        *         in="path",
        *         description="School ID",
        *      ),
        *      @OA\Parameter(
        *         name="class_id",
        *         in="path",
        *         description="Class ID",
        *      ),
        *      @OA\Parameter(
        *         name="sort_by",
        *         in="query",
        *         description="Sort By",
        *      ),
        *      @OA\Parameter(
        *         name="sort",
        *         in="query",
        *         description="Sort",
        *      ),
        *      @OA\Parameter(
        *         name="page",
        *         in="query",
        *         description="Page",
        *      ),
        *      @OA\Parameter(
        *         name="limit",
        *         in="query",
        *         description="Limit",
        *      ),
        *      @OA\Response(
        *          response=200,
        *          description="Report form is successfully retrieved",
        *          @OA\JsonContent()
        *       ),
        *      @OA\Response(
        *          response=422,
        *          description="Unprocessable Entity",
        *          @OA\JsonContent()
        *       ),
        *      @OA\Response(response=400, description="Bad request"),
        *      @OA\Response(response=404, description="Resource Not Found"),
        * )
        */
    public function report_form(Request $request)
    {
        //**************FETCH STUDENTS FROM CLASSROOM FOR SPECIFIED SCHOOL***************
        if (!empty($request->school_id) && !empty($request->class_id)) {
            $limit = $request->limit;
            $page = $request->page - 1;
            $offset = ceil($limit * $page);
            $sort_by = empty($request->sort_by) ? "name" : $request->sort_by;
            $sort = empty($request->sort) ? "ASC" : $request->sort;
            //###############################RANKING SYSTEM###########################################
            $students = Students::select("*")
                ->where([
                    ["school_id", $request->school_id],
                    ["classroom", $request->class_id],
                ])
                ->get();
            for ($i = 0; $i <= $students->count() - 1; $i++) {
                $school_id = $request->school_id;
                $class_id = $request->class_id;
                $student_id = $students[$i]->student_id;
                $student_name = $students[$i]->name;

                $this->update_report_form(
                    $school_id,
                    $student_id,
                    $student_name,
                    $class_id
                );
            }
            //#############################//RANKING SYSTEM###########################################
            $all_students = DB::table("report_form_view")
                ->select("*")
                ->where([["class_id", "=", $request->class_id]])
                ->get();

            $sorts = DB::table("report_form_view")
                ->select("*")

                ->selectRaw("RANK() OVER (ORDER BY `name` ASC) my_id")
                ->selectRaw(
                    "RANK() OVER (ORDER BY `term1_quiz` DESC) rank_term1_quiz"
                )
                ->selectRaw(
                    "RANK() OVER (ORDER BY `term2_quiz` DESC) rank_term2_quiz"
                )
                ->selectRaw(
                    "RANK() OVER (ORDER BY `term3_quiz` DESC) rank_term3_quiz"
                )

                ->selectRaw(
                    "RANK() OVER (ORDER BY `term1_total_marks` DESC) rank_term1"
                )
                ->selectRaw(
                    "RANK() OVER (ORDER BY `term2_total_marks` DESC) rank_term2"
                )
                ->selectRaw(
                    "RANK() OVER (ORDER BY `term3_total_marks` DESC) rank_term3"
                )
                ->selectRaw(
                    "RANK() OVER (ORDER BY `annual_marks` DESC) rank_annual"
                )
                ->where([["class_id", "=", $request->class_id]])
                ->offset($offset)
                ->limit($limit)
                ->orderBy($sort_by, $sort)
                ->get();

            $number_of_students = $all_students->count();

            return response()->json(
                [
                    "Sorts" => $sorts,
                    "no_of_students" => $number_of_students,
                    "offset" => $offset,
                    "message" => "Retrieved successfully",
                ],
                200
            );
        }
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Marks  $marks
     * @return \Illuminate\Http\Response
     */
    /**
        * @OA\Post(
        * path="/api/report_form_search/{school_id}/{class_id}",
        * operationId="searchReportForm",
        * tags={"Search report form API"},
        * security={
        *  {
        *  "passport": {}},
        *  },
        *      @OA\Parameter(
        *         name="school_id",
        *         in="path",
        *         description="School ID",
        *      ),
        *      @OA\Parameter(
        *         name="student_name",
        *         in="query",
        *         description="Students Name",
        *      ),
        *      @OA\Parameter(
        *         name="class_id",
        *         in="path",
        *         description="Class ID",
        *      ),
        *      @OA\Parameter(
        *         name="sort_by",
        *         in="query",
        *         description="Sort By",
        *      ),
        *      @OA\Parameter(
        *         name="sort",
        *         in="query",
        *         description="Sort",
        *      ),
        *      @OA\Parameter(
        *         name="page",
        *         in="query",
        *         description="Page",
        *      ),
        *      @OA\Parameter(
        *         name="limit",
        *         in="query",
        *         description="Limit",
        *      ),
        *      @OA\Response(
        *          response=200,
        *          description="Report form is successfully retrieved",
        *          @OA\JsonContent()
        *       ),
        *      @OA\Response(
        *          response=422,
        *          description="Unprocessable Entity",
        *          @OA\JsonContent()
        *       ),
        *      @OA\Response(response=400, description="Bad request"),
        *      @OA\Response(response=404, description="Resource Not Found"),
        * )
        */
    public function report_form_search(Request $request)
    {
        //
        //**************FETCH STUDENTS FROM CLASSROOM FOR SPECIFIED SCHOOL***************
        if (!empty($request->school_id) && !empty($request->class_id)) {
            $limit = $request->limit;
            $page = $request->page - 1;
            $offset = ceil($limit * $page);
            $sort_by = empty($request->sort_by) ? "name" : $request->sort_by;
            $sort = empty($request->sort) ? "ASC" : $request->sort;

            $all_students = DB::table("report_form_view")
                ->select("*")
                ->where([
                    ["school_id", "=", $request->school_id],
                    ["class_id", "=", $request->class_id],
                ])
                ->get();

            $sorts = DB::table("report_form_view")
                ->select("*")
                ->selectRaw(
                    "RANK() OVER (ORDER BY `term1_total_marks` DESC) rank_term1"
                )
                ->selectRaw(
                    "RANK() OVER (ORDER BY `term2_total_marks` DESC) rank_term2"
                )
                ->selectRaw(
                    "RANK() OVER (ORDER BY `term3_total_marks` DESC) rank_term3"
                )
                ->where([
                    ["name", "like", "%" . $request->student_name . "%"],
                    ["school_id", "=", $request->school_id],
                    ["class_id", "=", $request->class_id],
                ])

                ->orderBy($sort_by, $sort)
                ->get();

            $number_of_students = $all_students->count();

            return response()->json(
                [
                    "Sorts" => $sorts,
                    "no_of_students" => $number_of_students,
                    "offset" => $offset,
                    "message" => "Retrieved successfully",
                ],
                200
            );
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

          /**
        * @OA\Post(
        * path="/api/marks",
        * operationId="saveStudentsMarks",
        * tags={"Import students marks API"},
        * security={
        *  {
        *  "passport": {}},
        *  },
        *     @OA\RequestBody(
        *         @OA\JsonContent(),
        *         @OA\MediaType(
        *            mediaType="multipart/form-data",
        *            @OA\Schema(
        *               type="object",
        *               required={"school_id","course_id","teacher_id","classroom"},
        *               @OA\Property(property="school_id", type="text"),
        *               @OA\Property(property="course_id", type="number"),
        *               @OA\Property(property="teacher_id", type="number"),
        *               @OA\Property(property="class_id", type="number"),
        *               @OA\Property(property="page", type="number"),
        *               @OA\Property(property="limit", type="number"),
        *               @OA\Property(property="sort_by", type="text"),
        *               @OA\Property(property="sort", type="text"),
        *            ),
        *        ),
        *    ),

        *      @OA\Response(
        *          response=201,
        *          description="Students marks is successfully stored",
        *          @OA\JsonContent()
        *       ),
        *      @OA\Response(
        *          response=422,
        *          description="Unprocessable Entity",
        *          @OA\JsonContent()
        *       ),
        *      @OA\Response(response=400, description="Bad request"),
        *      @OA\Response(response=404, description="Resource Not Found"),
        * )
        */
    public function store(Request $request)
    {
        //########################Check whether license of the school expired or not
        $elapsed_time = license_keys::getLicense($request->school_id);
        $remain_sec = $elapsed_time["remain_sec"];
        //########################//Check whether license of the school expired or not
        if ($remain_sec < 0) {
            return response()->json(
                ["message" => "message.license_expired"],
                401
            );
        } else {
            $school_id = $request->school_id;
            $course_id = $request->course_id;
            $teacher_id = $request->account_id;
            $class_id = $request->class_id;
            $rows = 0;
            $today = strtotime(date("Y-m-d"));
            $academic_year = academic_year::get();
            $from = strtotime($academic_year[0]->term1_from);
            $to = strtotime($academic_year[0]->term3_to);
            if ($today >= $from && $today <= $to) {
                $academic_year = date("Y") . "-" . (date("Y") + 1);
            }

            $students = Students::select("*")
                ->where([
                    ["school_id", "=", $school_id],
                    ["classroom", "=", $class_id],
                ])
                ->get();
            for ($i = 0; $i <= $students->count() - 1; $i++) {
                $student_id = $students[$i]->student_id;
                $marks = Marks::select("*")
                    ->where([
                        ["student_id", "=", $student_id],
                        ["course_id", "=", $course_id],
                    ])
                    ->count();

                if ($marks == 0) {
                    $rows++;
                    $now = date("Y-m-d H:i:s");
                    $student_marks = new Marks();
                    $student_marks->academic_year = $academic_year ;
                    $student_marks->school_id = $school_id;
                    $student_marks->student_id = $student_id;
                    $student_marks->course_id = $course_id;
                    $student_marks->teacher_id = $teacher_id;
                    $student_marks->class_id = $class_id;
                    $student_marks->term1_quiz = 0;
                    $student_marks->term1_exam = 0;
                    $student_marks->term1_total_marks = 0;
                    $student_marks->rank1 = 0;
                    $student_marks->term2_quiz = 0;
                    $student_marks->term2_exam = 0;
                    $student_marks->term2_total_marks = 0;
                    $student_marks->rank2 = 0;                    
                    $student_marks->term3_quiz = 0;
                    $student_marks->term3_exam = 0;
                    $student_marks->term3_total_marks = 0;
                    $student_marks->rank3 = 0;
                    $student_marks->save();
                }
            }
           

            return response()->json(
                [
                    "message" => "Imported ($rows) students",
                ],
                201
            );
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Marks  $marks
     * @return \Illuminate\Http\Response
     */
    /**
        * @OA\Post(
        * path="/api/marks/update",
        * operationId="updateStudentsMarks",
        * tags={"Update students marks API"},
        * security={
        *  {
        *  "passport": {}},
        *  },
        *     @OA\RequestBody(
        *         @OA\JsonContent(),
        *         @OA\MediaType(
        *            mediaType="multipart/form-data",
        *            @OA\Schema(
        *               type="object",
        *               required={"school_id","course_id","course_id","student_id","account_id","class_id","term_quiz","term_exam","term"},
        *               @OA\Property(property="school_id", type="text"),
        *               @OA\Property(property="course_id", type="number"),
        *               @OA\Property(property="student_id", type="number"),
        *               @OA\Property(property="account_id", type="number"),
        *               @OA\Property(property="class_id", type="number"),
        *               @OA\Property(property="term_quiz", type="number"),
        *               @OA\Property(property="term_exam", type="number"),
        *               @OA\Property(property="term", type="number"),
        *            ),
        *        ),
        *    ),
        *      @OA\Response(
        *          response=200,
        *          description="Students marks is successfully updated",
        *          @OA\JsonContent()
        *       ),
        *      @OA\Response(
        *          response=422,
        *          description="Unprocessable Entity",
        *          @OA\JsonContent()
        *       ),
        *      @OA\Response(response=400, description="Bad request"),
        *      @OA\Response(response=404, description="Resource Not Found"),
        * )
        */
    public function update(Request $request)
    {
        //
        //########################Check whether license of the school expired or not
        $elapsed_time = license_keys::getLicense($request->school_id);
        $remain_sec = $elapsed_time["remain_sec"];
        //########################//Check whether license of the school expired or not
        if ($remain_sec < 0) {
            return response()->json(
                ["message" => "message.license_expired"],
                401
            );
        } else {
            $school_id = $request->school_id;
            $course_id = $request->course_id;
            $teacher_id = $request->account_id;
            $class_id = $request->class_id;
            $student_id = $request->student_id;
            $now = date("Y-m-d H:i:s");
            $today = strtotime(date("Y-m-d"));
            $academic_year = academic_year::first();
            $term1_from = strtotime($academic_year->term1_from);
            $term1_to = strtotime($academic_year->term1_to);
            $term2_from = strtotime($academic_year->term2_from);
            $term2_to = strtotime($academic_year->term2_to);
            $term3_from = strtotime($academic_year->term3_from);
            $term3_to = strtotime($academic_year->term3_to);
            $student_marks = Marks::select("*")
                ->where([
                    ["student_id", "=", $student_id],
                    ["teacher_id", "=", $teacher_id],
                    ["course_id", "=", $course_id],
                    ["class_id", "=", $class_id],
                    ["school_id", "=", $school_id],
                ])
                ->first();

            ##########################################################################################
            ##########################################################################################
            ############################CREATE MARKS VIEW FOR REPORT FORM#############################
            $sort_by = empty($request->sort_by)
                ? "course_name"
                : $request->sort_by;
            $sort = empty($request->sort) ? "ASC" : $request->sort;

            $courses = DB::table("courses")
                ->select("*")
                ->join(
                    "out_of_marks",
                    "out_of_marks.course_id",
                    "=",
                    "courses.course_id"
                )
                ->where([
                    ["out_of_marks.school_id", "=", $request->school_id],
                    ["out_of_marks.class_id", "=", $request->class_id],
                ])
                ->get();

            foreach ($courses as $key => $course) {
                # code...
                $ranks[] = DB::table("marks")
                    ->select(
                        "name",
                        "marks.student_id",
                        "course_name",
                        "marks.course_id",
                        "marks.term1_total_marks",
                        "marks.term2_total_marks",
                        "marks.term3_total_marks"
                    )
                    ->selectRaw(
                        "RANK() OVER (ORDER BY `marks`.`term1_total_marks` DESC) rank_term1"
                    )
                    ->selectRaw(
                        "RANK() OVER (ORDER BY `marks`.`term2_total_marks` DESC) rank_term2"
                    )
                    ->selectRaw(
                        "RANK() OVER (ORDER BY `marks`.`term3_total_marks` DESC) rank_term3"
                    )

                    ->join(
                        "students",
                        "students.student_id",
                        "=",
                        "marks.student_id"
                    )
                    ->join(
                        "courses",
                        "courses.course_id",
                        "=",
                        "marks.course_id"
                    )
                    ->where([
                        ["marks.school_id", "=", $request->school_id],
                        ["marks.course_id", "=", $course->course_id],
                        ["marks.class_id", "=", $request->class_id],
                    ])
                    ->orderBy($sort_by, $sort)
                    ->get();

                foreach ($ranks[$key] as $key => $value) {
                    # code...

                    if ($value->student_id == $request->student_id) {
                        $update_ranks[] = DB::table("marks")
                            ->where([
                                ["student_id", "=", $request->student_id],
                                ["class_id", "=", $request->class_id],
                                ["course_id", "=", $value->course_id],
                                ["school_id", "=", $request->school_id],
                            ])
                            ->update([
                                "rank1" => $value->rank_term1,
                                "rank2" => $value->rank_term2,
                                "rank3" => $value->rank_term3,
                            ]);
                    }
                }
            }

            ############################//CREATE MARKS VIEW FOR REPORT FORM###########################
            ##########################################################################################
            ##########################################################################################
            if ($request->term == 1) {
                if ($today >= $term1_from && $today <= $term3_to) {
                    $student = DB::table("students")
                        ->where("student_id", $student_id)
                        ->first();

                    $update = DB::table("marks")
                        ->where([
                            ["student_id", "=", $student_id],
                            ["teacher_id", "=", $teacher_id],
                            ["course_id", "=", $course_id],
                            ["class_id", "=", $class_id],
                            ["school_id", "=", $school_id],
                        ])
                        ->update([
                            "term1_quiz" =>
                                $student_marks->term1_quiz +
                                $request->term_quiz,
                            "term1_exam" => $request->term_exam,
                            "term1_total_marks" =>
                                $student_marks->term1_quiz +
                                ($request->term_quiz + $request->term_exam),
                            "updated_at" => $now,
                        ]);

                    $this->update_report_form(
                        $school_id,
                        $student_id,
                        $student->name,
                        $class_id
                    );

                    return response()->json(
                        ["message" => "Updated successfully"],
                        200
                    );
                } else {
                    return response()->json(
                        ["message" => "marks_vue.failed_edit_marks_term1"],
                        401
                    );
                }
            } elseif ($request->term == 2) {
                if ($today >= $term2_from && $today <= $term3_to) {
                    $update = DB::table("marks")
                        ->where([
                            ["student_id", "=", $student_id],
                            ["teacher_id", "=", $teacher_id],
                            ["course_id", "=", $course_id],
                            ["class_id", "=", $class_id],
                            ["school_id", "=", $school_id],
                        ])
                        ->update([
                            "term2_quiz" =>
                                $student_marks->term2_quiz +
                                $request->term_quiz,
                            "term2_exam" => $request->term_exam,
                            "term2_total_marks" =>
                                $student_marks->term2_quiz +
                                ($request->term_quiz + $request->term_exam),
                            "updated_at" => $now,
                        ]);

                    return response()->json(
                        ["message" => "Updated successfully"],
                        200
                    );
                } else {
                    return response()->json(
                        ["message" => "marks_vue.failed_edit_marks_term2"],
                        401
                    );
                }
            } elseif ($request->term == 3) {
                if ($today >= $term3_from && $today <= $term3_to) {
                    $update = DB::table("marks")
                        ->where([
                            ["student_id", "=", $student_id],
                            ["teacher_id", "=", $teacher_id],
                            ["course_id", "=", $course_id],
                            ["class_id", "=", $class_id],
                            ["school_id", "=", $school_id],
                        ])
                        ->update([
                            "term3_quiz" =>
                                $student_marks->term3_quiz +
                                $request->term_quiz,
                            "term3_exam" => $request->term_exam,
                            "term3_total_marks" =>
                                $student_marks->term3_quiz +
                                ($request->term_quiz + $request->term_exam),
                            "updated_at" => $now,
                        ]);

                    return response()->json(
                        ["message" => "Updated successfully"],
                        200
                    );
                } else {
                    return response()->json(
                        ["message" => "marks_vue.failed_edit_marks_term3"],
                        401
                    );
                }
            }
        }
    }

    /**
     * Update report form table
     */

    public function update_report_form(
        $school_id,
        $student_id,
        $student_name,
        $class_id
    ) {
        $records_exist = DB::table("report_form_view")
            ->select("*")
            ->where([
                ["class_id", "=", $class_id],
                ["student_id", "=", $student_id],
            ])
            ->get()
            ->count();

        if ($records_exist == 0) {
            $insert_user = DB::insert(
                "INSERT INTO `report_form_view`(`school_id`, `student_id`, `name`, `class_id`, `term1_quiz`, `term2_quiz`, `term3_quiz`, `term1_total_marks`, `term2_total_marks`,`term3_total_marks`, `annual_marks`, `term1_maximum_marks`, `term2_maximum_marks`, `term3_maximum_marks`, `annual_maximum_marks`) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)",
                [
                    $school_id,
                    $student_id,
                    $student_name,
                    $class_id,
                    0,
                    0,
                    0,
                    0,
                    0,
                    0,
                    0,
                    0,
                    0,
                    0,
                    0,
                ]
            );
        }

        $select_from_marks = DB::table("marks")
            ->selectRaw("SUM(`marks`.`term1_quiz`) as term1_quiz")
            ->selectRaw("SUM(`marks`.`term2_quiz`) as term2_quiz")
            ->selectRaw("SUM(`marks`.`term3_quiz`) as term3_quiz")
            ->selectRaw("SUM(`marks`.`term1_total_marks`) AS term1_total_marks")
            ->selectRaw("SUM(`marks`.`term2_total_marks`) AS term2_total_marks")
            ->selectRaw("SUM(`marks`.`term3_total_marks`) AS term3_total_marks")
            ->selectRaw(
                "(SUM(`marks`.`term1_total_marks`) +SUM(`marks`.`term2_total_marks`) + SUM(`marks`.`term3_total_marks`))  AS annual_marks"
            )

            ->where([
                ["marks.class_id", $class_id],
                ["marks.student_id", $student_id],
            ])
            ->first();

        $update_ranks = DB::table("report_form_view")
            ->where([
                ["student_id", "=", $student_id],
                ["class_id", "=", $class_id],
            ])
            ->update([
                "term1_quiz" => $select_from_marks->term1_quiz ?? 0,
                "term2_quiz" => $select_from_marks->term2_quiz ?? 0,
                "term3_quiz" => $select_from_marks->term3_quiz ?? 0,
                "term1_total_marks" => $select_from_marks->term1_total_marks ?? 0,
                "term2_total_marks" => $select_from_marks->term2_total_marks ?? 0,
                "term3_total_marks" => $select_from_marks->term3_total_marks ?? 0,
                "annual_marks" => $select_from_marks->annual_marks ?? 0,
            ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Marks  $marks
     * @return \Illuminate\Http\Response
     */
        /**
        * @OA\Post(
        * path="/api/marks/search",
        * operationId="SearchStudentsMarks",
        * tags={"Search students marks API"},
        * security={
        *  {
        *  "passport": {}},
        *  },
        *     @OA\RequestBody(
        *         @OA\JsonContent(),
        *         @OA\MediaType(
        *            mediaType="multipart/form-data",
        *            @OA\Schema(
        *               type="object",
        *               required={"school_id","class_id","course_id","student_name"},
        *               @OA\Property(property="school_id", type="text"),
        *               @OA\Property(property="class_id", type="number"),
        *               @OA\Property(property="course_id", type="number"),
        *               @OA\Property(property="student_name", type="text"),

        *            ),
        *        ),
        *    ),
        *      @OA\Response(
        *          response=200,
        *          description="Students marks is successfully retrieved",
        *          @OA\JsonContent()
        *       ),
        *      @OA\Response(
        *          response=422,
        *          description="Unprocessable Entity",
        *          @OA\JsonContent()
        *       ),
        *      @OA\Response(response=400, description="Bad request"),
        *      @OA\Response(response=404, description="Resource Not Found"),
        * )
        */
    public function search(Request $request)
    {
        //

        $Marks = DB::table("marks")
            ->select(
                "name",
                "term1_quiz",
                "term1_exam",
                "term1_total_marks",
                "term2_quiz",
                "term2_exam",
                "term2_total_marks",
                "term3_quiz",
                "term3_exam",
                "term3_total_marks",
                "marks.student_id"
            )
            ->selectRaw(
                "RANK() OVER (ORDER BY `term1_total_marks` DESC) rank_term1"
            )
            ->selectRaw(
                "RANK() OVER (ORDER BY `term2_total_marks` DESC) rank_term2"
            )
            ->selectRaw(
                "RANK() OVER (ORDER BY `term3_total_marks` DESC) rank_term3"
            )
            ->join("students", "students.student_id", "=", "marks.student_id")
            ->where([
                ["students.name", "like", "%" . $request->student_name . "%"],
                ["marks.school_id", "=", $request->school_id],
                ["classroom", "=", $request->class_id],
                ["marks.course_id", "=", $request->course_id],
            ])
            ->orderBy("name", "ASC")
            ->get();

        $number_of_students = $Marks->count();

        return response()->json(
            [
                "Marks" => $Marks,
                "no_of_students" => $number_of_students,
                "offset" => 0,
                "message" => "Retrieved successfully",
            ],
            200
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Marks  $marks
     * @return \Illuminate\Http\Response
     */
    public function destroy(Marks $marks)
    {
        //
    }
}
