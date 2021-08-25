<?php

namespace App\Api\V1\Controllers;

use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\JWTAuth;
use App\Http\Controllers\Controller;
//use App\Api\V1\Requests\LoginRequest;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Illuminate\Support\Facades\Mail;
use App\Mail\PasswordResetEmailNew;
use App\Mail\ResendOtp;

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
use App\Country;
use App\School;
use App\Chapter;
use App\Subjects_class_course;
use App\User;
use App\Users;
use App\User_class_course;
use App\User_regi_code;
use App\Codegenerators;

class LoginController extends Controller
{
    /**
     * Log the user in
     *
     * @param LoginRequest $request
     * @param JWTAuth $JWTAuth
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request, JWTAuth $JWTAuth)
    {      
        //$otp = rand(100000,999999);
        $otp = 1234;
        if (strpos($request->input('email'), '@') !== false) {
            $credentials = array('email'=>$request->input('email'),'password'=>$request->input('password'),'ma_delete'=>1,'mobile_verification_status'=>1);
            $where = array('email'=>$request->input('email'));  // ,'ma_delete'=>1,'mobile_verification_status'=>1
            $wherealldata = array('email'=>$request->input('email'),'ma_delete'=>1,'mobile_verification_status'=>1); 
        }else{
            $credentials = array('phone_number'=>$request->input('email'),'password'=>$request->input('password'),'ma_delete'=>1,'mobile_verification_status'=>1);
            $where = array('phone_number'=>$request->input('email'));  // ,'ma_delete'=>1,'mobile_verification_status'=>1
            $wherealldata = array('phone_number'=>$request->input('email'),'ma_delete'=>1,'mobile_verification_status'=>1);
        }

                 $user = Users::view_all($where); 

        if(count($user) != 0){
            if($user[0]['ma_delete'] == 0){
                return response()->json(['status' => false,'message' => 'User Deleted By Admin.']);
            }
            if($user[0]['mobile_verification_status'] == 0){
                $responsemessage = $user[0]['country_type']==0?'Please verify otp received on your email':'Please verify otp received on your mobile';
                if($user[0]['country_type'] == 0){                
                    Mail::to($user[0]['email'])->send(new ResendOtp($user[0]));
                    return response()->json(['status' => false,'otp_status' => 0,'phone_number'=>$user[0]['phone_number'],'message' => $responsemessage ]);
                }else{
                    $apiKey = urlencode('f6zCK18gyUY-guf0t2s83znZcTm0Y5YW8EMVu097uk	');
                    $mob = '91'.$user[0]['phone_number'];
                    $numbers = array((int)$mob);
                    $sender = urlencode('TXTLCL');
                    $msg= "Your OTP is".$otp;
                    $message = rawurlencode($msg);                
                    $numbers = implode(',', $numbers);
                    $data = array('apikey' => $apiKey, 'numbers' => $numbers, "sender" => $sender, "message" => $message);
                    $ch = curl_init('https://api.textlocal.in/send/');
                    curl_setopt($ch, CURLOPT_POST, true);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    $response = curl_exec($ch);
                    curl_close($ch);
                    return response()->json(['status' => false,'response'=>$response,'otp_status' => 1,'message' => $responsemessage,'otp'=>$otp,'phone_number'=>$user[0]['phone_number'] ]);
                }
            }else{
                    try {
                        $token = Auth::guard()->attempt($credentials);                        
                        if(!$token) {                        
                            return response()->json(['status' => false,'message' => 'Credentials do not match our records.','token' => $token,
                            //  'alldata' => '', //'expires_in' => Auth::guard()->factory()->getTTL() * 60
                            ]);
                        }
                    }catch (JWTException $e) {
                        throw new HttpException(500);
                    }
                    $alldata = Master_admin::where($wherealldata)->get();
                    if($alldata[0]['fk_role_id'] == 1){
                            return response()
                        ->json(['status' => true,'message' => 'Login Successfully','token' => $token,'alldata' => $alldata,]);
                    }

                    $alldata->transform(function($i){                   
                        $classdata = Classtable::view_single(array('cl_id'=>$i['fk_class_id']));           
                        $i['cl_name'] = $classdata['cl_name'];
                        $i['fk_class_slug'] = $classdata['slug'];
                        $schooldata = School::view_single(array('sc_id'=>$i['fk_school_id']));           
                        $i['sc_name'] = $schooldata['sc_name'];
                        $countrydata = Country::view_single(array('id'=>$i['fk_country_id']));           
                        $i['iso3'] = $countrydata['iso3'];
                        $user_regicode_where = array('co_delete'=>1,'urc_delete'=>1,'fk_user_slug'=>$i['slug']);
                        $all_regicode_data =  User_regi_code::view_all_join($user_regicode_where);        
                        $i['all_regicode_data'] = $all_regicode_data;
                        $i['birth_date'] = date('d-m-Y', strtotime($i['dob']));
                        $view_all_join_single =  User_regi_code::view_all_join_single($user_regicode_where);        
                        $i['school_name'] = $view_all_join_single['sc_name'];
                         $i['branch_name'] = $view_all_join_single['sb_location'];
                        return $i;
                    });

                    
                    return response()
                        ->json(['status' => true,'message' => 'Login Successfully','token' => $token,'alldata' => $alldata,
                            //'expires_in' => Auth::guard()->factory()->getTTL() * 60
                    ]);
                }
        }else{
            return response()->json(['status' => false,'message' => 'Credentials do not match our records.']);
        }


        
    }

    public function signup_user(Request $request,JWTAuth $JWTAuth)
    {     
        //$otp = rand(100000,999999);
        $otp = 123456;
        if($request->input('fk_role_id') == 3){
            if($request->has('regi_code') == true){
                    $check_regicode_where = array('co_code'=>$request->input('regi_code'));
                    $all_regicode_data =  Codegenerators::view_all($check_regicode_where);
                    if(count($all_regicode_data) == 0){
                    return response()->json(['status' => false,'message' => 'Invalid Registarion Code.']); 
                    }
                }
        }

        $where_verified_email = array('ma_delete'=>1,'mobile_verification_status'=>1,'email'=>$request->input('email'));
        $user_verified_email = Users::view_all($where_verified_email); // verified and email already exist;
        if(count($user_verified_email) != 0){
                if($user_verified_email[0]['phone_number'] == $request->input('phone_number')){
                     return response()->json(['status' => false,'message' => 'Email and Mobile Number Already Exsist;']);
                }else{
                    return response()->json(['status' => false,'message' => 'Email Already Exsist;']); 
                }
        }

        $where_verified_phone_number = array('ma_delete'=>1,'mobile_verification_status'=>1,'phone_number'=>$request->input('phone_number'));
        $user_verified_phone_number = Users::view_all($where_verified_phone_number); 
        if(count($user_verified_phone_number) != 0){
                if($user_verified_phone_number[0]['email'] == $request->input('email')){
                     return response()->json(['status' => false,'message' => 'Email and Mobile Number Already Exsist;']);
                }else{
                    return response()->json(['status' => false,'message' => 'Mobile Number Already Exsist;']); 
                }
        }

        $where_notverified_email = array('ma_delete'=>1,'mobile_verification_status'=>0,'email'=>$request->input('email'));
        $user_notverified_email = Users::view_all($where_notverified_email);
        $where_notverified_phone_number = array('ma_delete'=>1,'mobile_verification_status'=>0,'phone_number'=>$request->input('phone_number'));
        $user_notverified_phone_number = Users::view_all($where_notverified_phone_number);

        if(count($user_notverified_email) != 0){
           $user = Users::where($where_notverified_email)->first();
        }elseif(count($user_notverified_phone_number) != 0){
           $user = Users::where($where_notverified_phone_number)->first();
        }else{
            $user = new Users;
            $user->slug = CommonModel::add_slug('users',bin2hex(openssl_random_pseudo_bytes(5))); 
        } 	
			
			$user->fk_role_id = $request->input('fk_role_id');  // 3 = regi code , 4 = without regi code	
			$user->full_name = $request->input('full_name');	
			$user->country_type = $request->input('country_type');
            $user->phone_number = $request->input('phone_number');
			$user->email = $request->input('email');	
			$user->password = $request->input('password');	
			$user->dob = $request->has('dob')?date('Y-m-d', strtotime($request->input('dob'))):''; 
			$user->gender = $request->has('gender')?$request->input('gender'):''; 
			$user->fk_school_id = $request->has('fk_school_id')?$request->input('fk_school_id'):0;	
			$user->fk_class_id = $request->has('fk_class_id')?$request->input('fk_class_id'):0;		
            $user->email_verification_status = 0;
			$user->email_verification_token = (string)time()+3600*24;
			$user->mobile_verification_status = 0;
			$user->mobile_verification_otp = $otp;
			$user->created_by = 0;         
			$user->save();
			if ($user->save()) {
                if($request->input('fk_role_id') == 3){
                if($request->has('regi_code') == true){
                        $subtable = new User_regi_code;
                        $subtable->slug = CommonModel::add_slug('user_regi_code',bin2hex(openssl_random_pseudo_bytes(5))); 
                        $subtable->fk_user_slug = $user->slug;	
                        $subtable->regi_code = $request->input('regi_code');	
                        $subtable->save();
                }}

                
                if($request->input('country_type') == 0){                
                    Mail::to($user['email'])->send(new ResendOtp($user));
                    return response()->json(['status' => false,'otp_status' => 0,'message' => 'OTP share on your register email id.' ]);
                }else{
                                $apiKey = urlencode('f6zCK18gyUY-guf0t2s83znZcTm0Y5YW8EMVu097uk	');
                                $mob = '91'.$user['phone_number'];
                                $numbers = array((int)$mob);
                                $sender = urlencode('TXTLCL');
                                $msg= $otp. " is your Digiteacher OTP.";
                                $message = rawurlencode($msg);                
                                $numbers = implode(',', $numbers);
                                $data = array('apikey' => $apiKey, 'numbers' => $numbers, "sender" => $sender, "message" => $message);
                                $ch = curl_init('https://api.textlocal.in/send/');
                                curl_setopt($ch, CURLOPT_POST, true);
                                curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                                $response = curl_exec($ch);
                                curl_close($ch);
                }

                // $credentials = array('email'=>$request->input('email'),'password'=>$request->input('password'));
                // $token = Auth::guard()->attempt($credentials);

        // $user_regicode_where = array('co_delete'=>1,'urc_delete'=>1,'fk_user_slug'=>$subtable->slug,'regi_code'=>$request->input('regi_code'));
        // $userdate_regicode = User_regi_code::view_all_join($user_regicode_where);

        //     $whereuser = array('email'=>$request->input('email'),'ma_delete'=>1);
        //     $alldata = Master_admin::where($whereuser)->get();
        // $alldata->transform(function($i) use($subtable) {                   
        //     $classdata = Classtable::view_single(array('cl_id'=>$i['fk_class_id']));           
        //     $i['cl_name'] = $classdata['cl_name'];
        //     $i['fk_class_slug'] = $classdata['slug'];
        //     $schooldata = School::view_single(array('sc_id'=>$i['fk_school_id']));           
        //     $i['sc_name'] = $schooldata['sc_name'];
        //     $countrydata = Country::view_single(array('id'=>$i['fk_country_id']));           
        //     $i['iso3'] = $countrydata['iso3'];
        //      $user_regicode_where = array('co_delete'=>1,'urc_delete'=>1,'fk_user_slug'=>$subtable->fk_user_slug);
        //      $all_regicode_data =  User_regi_code::view_all_join($user_regicode_where);        
        //     $i['all_regicode_data'] = $all_regicode_data;
        //     $i['birth_date'] = date('d-m-Y', strtotime($i['dob']));


        //     return $i;
        // });

                $message = $request->input('country_type')==0?'Please verify otp received on your email':'Please verify otp received on your mobile';
                return response()->json(['status' => true,'message' =>$message, 'otp_message'=>$msg, 'otp_status'=>$response ]); 
			}else{
                return response()->json(['status' => false,'message' => 'Error']); 
            }

        // check fk_role_id = 3 and regi_code not avilable in Codegenerators table then show invalid code
        
       // print_r($user_notverified);exit;

         
        
    }

   
public function forgot_password(Request $request)
    {

           $wherecheck = array('email'=>$request->input('email'),'ma_delete'=>1,'mobile_verification_status'=>1);
            try {
                $user = Users::where($wherecheck)->firstOrFail();
            }
            catch (\Exception $e) {
                throw new NotFoundHttpException("We couldn't find any user registered with that email.");
            }

             //$otp = rand(100000,999999);
            $otp = 1234;
            
            $user = Users::where($wherecheck)->firstOrFail();
            $user->mobile_verification_otp = $otp;			
            $user->save();   
            

                        if($user['country_type'] == 0){                
                            Mail::to($user['email'])->send(new ResendOtp($user));
                            return response()->json(['status' => false,'otp_status' => 0,'message' => 'OTP share on your register email id.' ]);
                        }else{
                                $apiKey = urlencode('f6zCK18gyUY-guf0t2s83znZcTm0Y5YW8EMVu097uk	');
                                $mob = '91'.$user['phone_number'];
                                $numbers = array((int)$mob);
                                $sender = urlencode('TXTLCL');
                                $msg= "Your OTP is".$otp;
                                $message = rawurlencode($msg);                
                                $numbers = implode(',', $numbers);
                                $data = array('apikey' => $apiKey, 'numbers' => $numbers, "sender" => $sender, "message" => $message);
                                $ch = curl_init('https://api.textlocal.in/send/');
                                curl_setopt($ch, CURLOPT_POST, true);
                                curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                                $response = curl_exec($ch);
                                curl_close($ch);
                                return response()->json(['status' => false,'response'=>$response,'otp_status' => 1,'message' => 'Please Verify Your Mobile Number Otp Send On Your Register Mobile Number','otp'=>$otp ]);
	                       }
    }

        
  	public function verify_email(Request $request)
    	{     

			// $userdata = Users::user_singledata_select(array('slug'=>'38c1d4b414'));
		
			$where = array('email_verification_token'=>$request->input('email_verification_token'),"ma_delete" => 1);        
			$user = Users::user_singledata($where);	
			 		
			if(isset($user) > 0)
			{
				if(time() < $user['email_verification_token'])
				{
					$data = array(					
						'email_verification_token'=>0,
						'email_verification_status'=>1,
					);

					Users::where(array('slug'=>$user['slug']))->update($data);

					return response()->json(['status'=>true,'message'=>'Email verified successfully.']);
				}else{
					return response()->json(['status'=>false,'message'=>'Token expired']);
				}
			}else{
					return response()->json(['status'=>false,'message'=>'Invalid Token.']);
			}
		}


        
	public function verify_number(Request $request, JWTAuth $JWTAuth)
    	{			
				
			$where = array('phone_number'=>$request->input('phone_number'),'mobile_verification_otp'=>$request->input('otp'),"ma_delete" => 1);        
			$user = Users::user_singledata($where);
		//	print_r($where);exit;			 		
			if(isset($user) > 0)
			{			
                    $user = Users::where($where)->first();			
                    $user->mobile_verification_status = 1;
                    $user->mobile_verification_otp = 0;
                    $user->save();
                
                    $credentials = array('email'=>$user->email,'password'=>$request->input('password'));
                    $token = Auth::guard()->attempt($credentials);            
                    
                        $wherealldata = array('email'=>$user->email);
                        $alldata = Master_admin::where($wherealldata)->get();
                        $alldata->transform(function($i)  {                   
                            $classdata = Classtable::view_single(array('cl_id'=>$i['fk_class_id']));           
                            $i['cl_name'] = $classdata['cl_name'];
                            $i['fk_class_slug'] = $classdata['slug'];
                            $schooldata = School::view_single(array('sc_id'=>$i['fk_school_id']));           
                            $i['sc_name'] = $schooldata['sc_name'];
                            $countrydata = Country::view_single(array('id'=>$i['fk_country_id']));           
                            $i['iso3'] = $countrydata['iso3'];
                            $user_regicode_where = array('co_delete'=>1,'urc_delete'=>1,'fk_user_slug'=>$i['slug']);
                            $all_regicode_data =  User_regi_code::view_all_join($user_regicode_where);        
                            $i['all_regicode_data'] = $all_regicode_data;
                            $i['birth_date'] = date('d-m-Y', strtotime($i['dob']));                                    
                        $i['school_name'] = $view_all_join_single['sc_name'];
                         $i['branch_name'] = $view_all_join_single['sb_location'];
                            return $i;
                        });
                    return response()
                    ->json([
                        'status' => true,
                        'message' => 'Number verified successfully.',
                        'token' => $token,
                        'alldata' => $alldata,
                        //'expires_in' => Auth::guard()->factory()->getTTL() * 60
                    ]); 
            }else{
				return response()->json(['status'=>false,'message'=>'Invalid OTP.']);
			}
		}

        
      
	public function resend_otp(Request $request,JWTAuth $JWTAuth)
	{			

        //$otp = rand(100000,999999);
        $otp = 1234;
		if($request->input('country_type') == 0){           
            $user = Users::where('phone_number', $request->input('phone_number'))->firstOrFail();
            $user->mobile_verification_otp = $otp;			
            $user->save();        
            //  print_r($user['email']);exit;
        Mail::to($user['email'])->send(new ResendOtp($user));
			return response()->json(['status' => false,'otp_status' => 0,'message' => 'OTP share on your register email id.' ]);
		}

		$wherecheck = array('phone_number'=>$request->input('phone_number'),"ma_delete" => 1);        
		$userscountcheck = Users::user_alldata($wherecheck);
		//  print_r($userscountcheck);exit;
		if(count($userscountcheck) == 0){
			return response()->json(['status' => false,'otp_status' => 0,'message' => 'Mobile Number Not Found.' ]);
		}else{
			

                   
                            // Account details
                    $apiKey = urlencode('f6zCK18gyUY-guf0t2s83znZcTm0Y5YW8EMVu097uk	');
                    
                    // Message details
                    $mob = '91'.$request->input('phone_number');
                    $numbers = array((int)$mob);
                    $sender = urlencode('TXTLCL');
                    $msg= "Your OTP is".$otp;
                    $message = rawurlencode($msg);
                
                    $numbers = implode(',', $numbers);
                
                    // Prepare data for POST request
                    $data = array('apikey' => $apiKey, 'numbers' => $numbers, "sender" => $sender, "message" => $message);
                // print_r($data);
                    // Send the POST request with cURL
                    $ch = curl_init('https://api.textlocal.in/send/');
                    curl_setopt($ch, CURLOPT_POST, true);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    $response = curl_exec($ch);
                    curl_close($ch);
                    
                    // Process your response here
                    //echo $response;
			return response()->json(['status' => false,'response'=>$response,'otp_status' => 1,'message' => 'Please Verify Your Mobile Number Otp Send On Your Register Mobile Number','otp'=>$otp ]);
	
		}
	}

            public function edit_profile(Request $request,JWTAuth $JWTAuth)
    {     
        	$usersdata = CommonModel::userdetails($JWTAuth->parseToken());						
			//print_r($usersdata);exit;
            $user = Users::where('slug',$usersdata['slug'])->first();
			$user->full_name = $request->input('full_name');	
			$user->phone_number = $request->input('phone_number');	
			$user->email = $request->input('email');	
			$user->password = $request->input('password');	
			//$user->dob = date('Y-m-d', strtotime($request->input('dob')));	
			$user->gender = $request->input('gender');	
			//$user->fk_school_id = $request->has('fk_school_id')?$request->input('fk_school_id'):0;	
			//$user->fk_class_id = $request->has('fk_class_id')?$request->input('fk_class_id'):0;      
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

        public function setpin(Request $request,JWTAuth $JWTAuth)
            {     
                    $usersdata = CommonModel::userdetails($JWTAuth->parseToken());
                    $user = Users::where('slug',$usersdata['slug'])->first();
                    $user->setpin = $request->input('setpin');	
                    $user->videomode = $request->input('videomode');	
                    $user->save();
                    if ($user->save()) {
                        return response()->json(['status' => true,'message' => 'Successfully Updated']); 
                    }else{
                        return response()->json(['status' => false,'message' => 'Error']); 
                    }        
            }



            
        // $checkemailwhere = array('ma_delete'=>1,'email'=>$request->input('email'),'mobile_verification_status'=>1);
        // $checkemailcount = Master_admin::checkcount($checkemailwhere);       

        // $checkphonewhere = array('ma_delete'=>1,'phone_number'=>$request->input('phone_number'),'mobile_verification_status'=>1);
        // $checkphonecount = Master_admin::checkcount($checkphonewhere);

        // if($checkemailcount != 0 && $checkphonecount != 0) {
        //     return response()->json(['status' => false,'message' => 'Email and Mobile Number Already Exsist;']); 
        // }elseif($checkphonecount != 0){
        //     return response()->json(['status' => false,'message' => 'Mobile Number Already Exsist;']); 
        // }elseif($checkemailcount != 0){
        //     return response()->json(['status' => false,'message' => 'Email Already Exsist;']); 
        // }


       
        //         if($request->has('regi_code') == true){
        //             $check_regicode_where = array('co_code'=>$request->input('regi_code'));
        //             $all_regicode_data =  Codegenerators::view_all($check_regicode_where); 

        //             if(count($all_regicode_data) == 0){
        //             return response()->json(['status' => false,'message' => 'Invalid Registarion Code.']); 
        //                 }
        //         }
		// 	//$otp = rand(100000,999999);
        //         $otp = 1234;
		// 	$user = new Users;
		// 	$user->slug = CommonModel::add_slug('users',bin2hex(openssl_random_pseudo_bytes(5))); 
		// 	$user->fk_role_id = $request->input('fk_role_id');	
		// //	$user->regi_code = $request->has('regi_code')?$request->input('regi_code'):'';	
		// 	$user->full_name = $request->input('full_name');	
		// 	$user->phone_number = $request->input('phone_number');	
		// 	$user->email = $request->input('email');	
		// 	$user->password = $request->input('password');	
		// 	$user->dob = date('Y-m-d', strtotime($request->input('dob')));	
		// 	$user->gender = $request->input('gender');	
		// 	$user->fk_school_id = $request->has('fk_school_id')?$request->input('fk_school_id'):0;	
		// 	$user->fk_class_id = $request->has('fk_class_id')?$request->input('fk_class_id'):0;		
        //     $user->email_verification_status = 0;
		// 	$user->email_verification_token = (string)time()+3600*24;
		// 	$user->mobile_verification_status = 0;
		// 	$user->mobile_verification_otp = $otp;
		// 	$user->created_by = 0;
        //     //	print_r($audvid);exit;   
        //             $credentials = array('email'=>$request->input('email'),'password'=>$request->input('password'),'ma_delete'=>1);
        //             $token = Auth::guard()->attempt($credentials);
		// 	$user->save();
		// 	if ($user->save()) {
 
        //         if($request->has('regi_code') == true){
        //                 $subtable = new User_regi_code;
        //                 $subtable->slug = CommonModel::add_slug('user_regi_code',bin2hex(openssl_random_pseudo_bytes(5))); 
        //                 $subtable->fk_user_slug = $user->slug;	
        //                 $subtable->regi_code = $request->input('regi_code');	
        //                 $subtable->save();
        //         }

                
        //         if($request->input('country_type') == 0){                
        //             Mail::to($user['email'])->send(new ResendOtp($user));
        //             return response()->json(['status' => false,'otp_status' => 0,'message' => 'OTP share on your register email id.' ]);
        //         }

        //         $credentials = array('email'=>$request->input('email'),'password'=>$request->input('password'));
        //         $token = Auth::guard()->attempt($credentials);

        // // $user_regicode_where = array('co_delete'=>1,'urc_delete'=>1,'fk_user_slug'=>$subtable->slug,'regi_code'=>$request->input('regi_code'));
        // // $userdate_regicode = User_regi_code::view_all_join($user_regicode_where);

        //     $whereuser = array('email'=>$request->input('email'),'ma_delete'=>1);
        //     $alldata = Master_admin::where($whereuser)->get();
        // $alldata->transform(function($i) use($subtable) {                   
        //     $classdata = Classtable::view_single(array('cl_id'=>$i['fk_class_id']));           
        //     $i['cl_name'] = $classdata['cl_name'];
        //     $i['fk_class_slug'] = $classdata['slug'];
        //     $schooldata = School::view_single(array('sc_id'=>$i['fk_school_id']));           
        //     $i['sc_name'] = $schooldata['sc_name'];
        //     $countrydata = Country::view_single(array('id'=>$i['fk_country_id']));           
        //     $i['iso3'] = $countrydata['iso3'];
        //      $user_regicode_where = array('co_delete'=>1,'urc_delete'=>1,'fk_user_slug'=>$subtable->fk_user_slug);
        //      $all_regicode_data =  User_regi_code::view_all_join($user_regicode_where);        
        //     $i['all_regicode_data'] = $all_regicode_data;
        //     $i['birth_date'] = date('d-m-Y', strtotime($i['dob']));


        //     return $i;
        // });
            
        //         return response()->json(['status' => true,'message' => 'Successfully Inserted', 'token' => $token,'alldata'=>$alldata]); 
		// 	}else{
        //         return response()->json(['status' => false,'message' => 'Error', 'token' => $token]); 
        //     }        

}
