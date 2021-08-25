<?php

namespace App\Api\V1\Controllers;

use Symfony\Component\HttpKernel\Exception\HttpException;
use Tymon\JWTAuth\JWTAuth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Auth;
use App\Master_admin;
use App\Classtable;
use App\Subjects;
use App\CommonModel;
use App\Audiovideo;
use App\Questions;
use App\Ques_mcq;
use App\Ques_fillin_the_blank;
use App\Ques_match_the_pair;
use App\Ques_truefalse;
use App\Role;
use App\School;
use App\Country;
use App\Chapter;
use App\Answer;
use App\Subjects_class_course;
use App\User;
use App\User_class_course;
use App\Codegenerators;
use App\User_regi_code;
use App\Payments;

class MasterApiController extends Controller
{

    public function view_school(Request $request)
    {
		$whereav = ['sc_delete'=>1];
		$data = School::view_all($whereav);
		return response()->json(['status' =>true,'data' => $data]);
    }
    
    public function view_classand_course(Request $request)
	{
		$where = ['cl_delete'=>1];
		$data = Classtable::view_all($where);
		return response()->json(['status' =>true,'data' => $data]);
	}
   
    public function view_subject(Request $request)
	{
            // 'subjects_class_course.scc_delete'=>1,
		$where = ['su_delete'=>1,'scc_delete'=>1,'fk_class_id'=>$request->input('fk_class_id')];
        $data['tabledata'] = Subjects::view_all_join(array_filter($where));
		// $data['tabledata']->transform(function($i){  
        //     $where = ['subjects_class_course.scc_delete'=>1,'su_id'=>$i['fk_subject_id']];
        //     $subjects_class_course = Subjects_class_course::join_courseand_subject(array_filter($where));                 
        //     $i['subjects_class_course'] = $subjects_class_course;            
        //     // $classdata = Classtable::view_single(array('cl_id'=>$i['fk_class_id']));           
        //     // $i['cl_name'] = $classdata['cl_name'];
        //     return $i;
        // });
        return response()->json(['status' =>true,'data' =>$data['tabledata']]);
    }
    
    public function view_subject_details(Request $request)
	{
		$where = ['su_delete'=>1,'su_id'=>$request->input('su_id')];
        $data['tabledata'] = Subjects::view_all(array_filter($where));	
        return response()->json(['status' =>true,'data' => $data['tabledata']]);
    }
    
    public function view_chapter(Request $request)
	{
		$where = ['ch_delete'=>1,'ch_id'=>$request->input('ch_id'),'fk_subject_id'=>$request->input('fk_subject_id')];
        $data['tabledata'] = Chapter::view_all(array_filter($where));
		$data['tabledata']->transform(function($i){                   
            $subject = Subjects::view_single(array('su_id'=>$i['fk_subject_id']));           
            $i['su_name'] = $subject['su_name'];
            return $i;
        });
        return response()->json(['status' =>true,'data' =>$data['tabledata']]);
    }  

    public function view_audiovideo(Request $request)
	{
		$whereav = ['av_delete'=>1,'av_id'=>$request->input('av_id'),'audiovideo.fk_subject_id'=>$request->input('fk_subject_id'),'audiovideo.fk_chapter_id'=>$request->input('fk_chapter_id')];
		$data['tabledata'] = Audiovideo::view_all(array_filter($whereav));
        return response()->json(['status' =>true,'data' =>$data['tabledata']]);
    }     
	
	public function view_country(Request $request) // Viewall catalogues.
	{				
		$where = array();
		$data['tabledata'] = Country::view_all($where);
		return response()->json(['status' =>true,'data' =>$data['tabledata']]);
    }

    public function view_question(Request $request) // Viewall catalogues.
	{				
		$where = [
            'q_delete'=>1,
            'q_id'=>$request->has('q_id')?$request->input('q_id'):'',
            'questions.fk_subject_id'=>$request->has('fk_subject_id')?$request->input('fk_subject_id'):'',
            'questions.fk_chapter_id'=>$request->has('fk_chapter_id')?$request->input('fk_chapter_id'):'',
        ];
        $data['tabledata'] = Questions::view_all(array_filter($where));
        $data['tabledata']->transform(function($i){                   
            $subquestiondata = CommonModel::sub_question_data($i['table_name'],$i['q_id']);           
            $i['subquestiondata'] = $subquestiondata;
            return $i;
        });
		return response()->json(['status' =>true,'data' =>$data['tabledata']]);
    }

    public function insert_answer(Request $request) // Viewall catalogues.
	{			
						
			$table = new Answer;
			$table->slug = CommonModel::add_slug('answer',bin2hex(openssl_random_pseudo_bytes(5)));
            $table->fk_user_id = $request->input('fk_user_id');		
            $table->selected_answer = $request->input('selected_answer');	
			$table->fixed_answer = $request->input('fixed_answer');		
			$table->date = date('Y-m-d');
			$table->save();
			if ($table->save()) {
				return response()->json(['status' =>true,'message' =>'Added succesfully!' ]);
			}else{
				return response()->json(['status' =>true,'message' =>'Error!'] );
			}		
	}

    public function view_code(Request $request) // Viewall catalogues.
	{				
		$where = array('co_delete'=>1);
		$data['tabledata'] = Codegenerators::view_all($where);
		return response()->json(['status' =>true,'data' =>$data['tabledata']]);
    }

        
    public function edit_profile(Request $request,JWTAuth $JWTAuth)
    {     
        	$usersdata = Common_model::userdetails($JWTAuth->parseToken());			
			
            $user = new Users;
			$user->full_name = $request->input('full_name');	
			$user->phone_number = $request->input('phone_number');	
			$user->email = $request->input('email');	
			$user->password = $request->input('password');	
			//$user->dob = date('Y-m-d', strtotime($request->input('dob')));	
			$user->gender = $request->input('gender');	
			$user->fk_school_id = $request->has('fk_school_id')?$request->input('fk_school_id'):0;	
			$user->fk_class_id = $request->has('fk_class_id')?$request->input('fk_class_id'):0;      
			$user->save();
			if ($user->save()) {
                $count = 0;
                if(is_array($request->input('regi_code'))){
                    foreach($request->input('regi_code') as $rowcode){
                        $subtable = new User_regi_code;
                        $subtable->slug = CommonModel::add_slug('user_regi_code',bin2hex(openssl_random_pseudo_bytes(5))); 
                        $subtable->fk_user_slug = $usersdata['slug'];	
                        $subtable->regi_code = $rowcode[$count];	
                        $subtable->save();
                        $count++;
                    }                        
                }
                
                return response()->json(['status' => true,'message' => 'Successfully Updated']); 
			}else{
                return response()->json(['status' => false,'message' => 'Error']); 
            }        
    }

      public function add_alphabet_tracing(Request $request) // Viewall catalogues.
	{		
	
			$q_audio = $request->file('q_audio');
			$img1 = $request->file('img1');
            $img2 = $request->file('img2');
            $img3 = $request->file('img3');
    // $test = CommonModel::upload_file('albhabetimg',$img1,$path = 'albhabetimg');
	// print_r($test);exit;
		
			$ques = new Questions;
			$ques->slug = CommonModel::add_slug('questions',bin2hex(openssl_random_pseudo_bytes(5))); 
            $ques->fk_course_id = $request->input('fk_course_id');		
			$ques->fk_subject_id = $request->input('fk_subject_id');	
			$ques->fk_chapter_id = $request->input('fk_chapter_id');	
			$ques->alphabet_type = $request->input('alphabet_type');	// practice or activity
			$ques->q_audio = CommonModel::upload_file('albhabetimg',$q_audio,$path = 'albhabetimg');
            $ques->img1 = CommonModel::upload_file('albhabetimg',$img1,$path = 'albhabetimg');
            $ques->img2 = CommonModel::upload_file('albhabetimg',$img2,$path = 'albhabetimg');
            $ques->img3 = CommonModel::upload_file('albhabetimg',$img3,$path = 'albhabetimg');
			$ques->marks = 2;//$marks[$count];	
			$ques->answer = 2;//$answer[$count];
			$ques->cordinate_json = $request->input('cordinate_json');
			$ques->type_name = 'Albhabet Tracing';
			$ques->table_name = 'ques_albhabet_tracing';	
			$ques->table_id = 'qat_id';	
			$ques->pagename = 'albhabet_tracing';	
			$ques->created_by = 1;
			$ques->save();		
			
              if ($ques->save()) {
                return response()->json(['status' =>true,'message' =>'Added Successfully.' ]);
              }else{
                return response()->json(['status' =>false,'message' =>'Error!' ]);
              }	
		}

        public function remove_question(Request $request) // Viewall catalogues.
	{		
			$ques = Questions::where('slug',$request->input('slug'))->first();	
            $ques->q_delete = 0;
			$ques->save();				
              if ($ques->save()) {
                return response()->json(['status' =>true,'message' =>'Dissable Successfully.' ]);
              }else{
                return response()->json(['status' =>false,'message' =>'Error!' ]);
              }	
		}

        public function view_question_alphabet_tracing(Request $request) // Viewall catalogues.
	{				
		$where = [
            'q_delete'=>1,
            'alphabet_type'=>$request->input('alphabet_type'), // practice or activity	
            'q_id'=>$request->has('q_id')?$request->input('q_id'):'',
            'questions.fk_subject_id'=>$request->has('fk_subject_id')?$request->input('fk_subject_id'):'',
            'questions.fk_chapter_id'=>$request->has('fk_chapter_id')?$request->input('fk_chapter_id'):'',
            'questions.fk_course_id'=>$request->has('fk_course_id')?$request->input('fk_course_id'):'',
        ];

        $data['tabledata'] = Questions::view_all_imagetracing(array_filter($where));
        
		return response()->json(['status' =>true,'data' =>$data['tabledata']]);
    }



        public function initial_payment(Request $request){

                //   $user = Common_model::userdetails($JWTAuth->parseToken());		
                    $transaction_id = date('YmdHis');
                    $tablepp = new Payments;       
                    $tablepp->slug = CommonModel::add_slug('questions',bin2hex(openssl_random_pseudo_bytes(5)));  
                    $tablepp->payment_date = date('Y-m-d H:i:s');
                    $tablepp->transaction_id = $transaction_id;
                    $tablepp->fk_user_slug = $request->input('fk_user_slug');
                    $tablepp->fk_subject_slug = $request->input('fk_subject_slug');
                    $tablepp->py_total_amount = $request->input('py_total_amount');
                    $tablepp->py_status = 'initial';
                
                    $tablepp->save();
                    if ($tablepp->save()) { 
                    return response()->json(['status' => true,'message'=>'Payment Initiate Successfully.','transaction_id'=>$transaction_id]);
                    }{
                    return response()->json(['status' => false]);
                    }
        }
       
        public function final_payment(Request $request,JWTAuth $JWTAuth){

                $id = 'rzp_test_PiT5ASjphFkKm0'; 
                $key = '8bLolYS5VxgGSgq9l8AiIvH3';  
                $razorapi = new Api($id, $key);      
                $razor_res = $razorapi->payment->fetch($request->input('razorpay_id'))->capture(array('amount'=>$request->input('total_amount')*100));   
                        $payment = Payments::where('transaction_id',$request->input('transaction_id'))->first();
                        $payment->py_status = $razor_res['status']; 
                        $payment->razorpay_payment_id = $razor_res['id'];
                        if ($payment->save()) {          
                            //// MAIL SENDING          
                                // $user = $JWTAuth->parseToken()->toUser();  
                                // $users = Users::where('email', $user->email)->firstOrFail();        
                                // $mail = Mail::to($user->email)->send(new FinalPayment($users,$payment));
                            //// MAIL SENDING CODE END
                        return response()->json(['status' => true,'message'=>'Payment Status Get','transaction_id'=>$request->input('transaction_id')]);
                        }{
                        return response()->json(['status' => false]);
                        }
        }  
    

}
