<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\ImageManagerStatic as Image;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Mail;
use Storage;
use Session; 
use Hash;
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
use App\Answer;
use App\Subjects_class_course;
use App\Schoolbranch;
use App\User;
use App\Users;
use App\User_class_course;
use App\Codegenerators;
use App\User_regi_code;
use App\Mail\ResendOtp;

class MasterController extends Controller
{
    public function view_class(Request $request) // Viewall catalogues.
	{		
		if ($request->input('_token')) {
			$user = Auth::guard('admin')->user();
			
			$classtable = $request->input('cl_id') == '0'?new Classtable:Classtable::where('cl_id',$request->input('cl_id'))->first();
			if($request->input('cl_id') == '0'){$classtable->slug = CommonModel::add_slug('classtable',bin2hex(openssl_random_pseudo_bytes(5)));} 
			$classtable->cl_name = $request->input('cl_name');
			$classtable->cl_description = $request->input('cl_description');
			$classtable->cl_price = $request->input('cl_price');
			//$classtable->cl_logo = CommonModel::upload_file('classcourse',$request->file('cl_logo'),$path = 'classcourse');			
			$classtable->cl_logo =  $request->file('cl_logo')?CommonModel::upload_file('classcourse',$request->file('cl_logo'),$path = 'classcourse'):$request->input('bk_cl_logo');	

	$classtable->type = $request->input('type');		
			$classtable->added_by = $user->id;
			$classtable->save();
			if ($classtable->save()) {
				return redirect('view_class')->with('msg',$request->input('cl_id') == '0'?'Added succesfully!':'Updated succesfully!');
			}else{
				return redirect('view_class')->with('errmsg', 'Error!');
			}
		}
		$where = ['cl_delete'=>1];
		$data['tabledata'] = Classtable::view_all($where);
		return view('master.view_class',['data'=>$data]);	
	}

	public function view_subjects(Request $request) // Viewall catalogues.
	{		
		if ($request->input('_token')) {
			$user = Auth::guard('admin')->user();
			$subjecttable = $request->input('su_id') == '0'?new Subjects:Subjects::where('su_id',$request->input('su_id'))->first();
			$subjecttable->slug = CommonModel::add_slug('subjects',bin2hex(openssl_random_pseudo_bytes(5))); 
			$subjecttable->fk_class_id = $request->input('fk_class_id');	
			$subjecttable->fk_type_id = $request->input('fk_type_id');			
			$subjecttable->su_name = $request->input('su_name');		
			$subjecttable->added_by = $user->id;
			//	print_r($subjecttable);exit;
			$subjecttable->save();
			if ($subjecttable->save()) {
				return redirect('view_subject')->with('msg',$request->input('su_id') == '0'?'Added succesfully!':'Updated succesfully!');
			}else{
				return redirect('view_subject')->with('errmsg', 'Error!');
			}
		}
		$whereclass = ['cl_delete'=>1];
		$data['classtable'] = Classtable::view_all($whereclass);
		$where = ['su_delete'=>1];
		$data['tabledata'] = Subjects::view_all($where);
		$data['tabledata']->transform(function($i){                   
            $classdata = Classtable::view_single(array('cl_id'=>$i['fk_class_id']));           
            $i['cl_name'] = $classdata['cl_name'];

				$classdata = Subjects_class_course::view_all_comma_seprated_name(array('fk_subject_id'=>$i['su_id']));           
            $i['all_cl_name'] = $classdata['all_cl_name'];
            return $i;
        });
		// print_r($data['tabledata'][0]['all_su_name']);exit;
		return view('master.view_subjects',['data'=>$data]);	
	}

	public function add_subjects(Request $request) // Viewall catalogues.
	{		
		if ($request->input('_token')) {
			$user = Auth::guard('admin')->user();
			$subjecttable = new Subjects;
			$subjecttable->slug = CommonModel::add_slug('subjects',bin2hex(openssl_random_pseudo_bytes(5))); 
			
			$subjecttable->book_image = CommonModel::upload_file('book_image',$request->file('book_image'),$path = 'book_image');			
			$subjecttable->su_name = $request->input('su_name');		
			$subjecttable->description = $request->input('description');	
			$subjecttable->auther_name = $request->input('auther_name');
			$subjecttable->su_price = $request->input('su_price');		
			$subjecttable->added_by = $user->id;
			//	print_r($subjecttable);exit;
			$subjecttable->save();
			if ($subjecttable->save()) {
			
				// if(strlen($request->input('str_fk_class_id')) > 1){
				// 	$str_fk_class_id = explode(",",$request->input('str_fk_class_id'));
				// 	foreach($str_fk_class_id as $cid){
				// 		$scc = new Subjects_class_course;
				// 		$scc->fk_class_id = $cid;	
				// 		$scc->slug = CommonModel::add_slug('subjects_class_course',bin2hex(openssl_random_pseudo_bytes(5))); 
				// 		$scc->fk_subject_id = $subjecttable->su_id;	
				// 		$scc->save();
				// 	}					
				// }

					foreach($request->input('subcourse') as $cid){
						$scc = new Subjects_class_course;
						$scc->fk_class_id = $cid;	
						$scc->slug = CommonModel::add_slug('subjects_class_course',bin2hex(openssl_random_pseudo_bytes(5))); 
						$scc->fk_subject_id = $subjecttable->su_id;	
						$scc->save();
					}

				return redirect('view_subject')->with('msg','Added succesfully!');
			}else{
				return redirect('view_subject')->with('errmsg', 'Error!');
			}
		}
		$whereclass = ['cl_delete'=>1];
		$data['classtable'] = Classtable::view_all($whereclass);
		$where = ['su_delete'=>1];
		$data['tabledata'] = Subjects::view_all($where);
		$data['tabledata']->transform(function($i){                   
            $classdata = Classtable::view_single(array('cl_id'=>$i['fk_class_id']));           
            $i['cl_name'] = $classdata['cl_name'];
            return $i;
        });
	 //print_r($data['classtable']);exit;
		return view('master.add_subjects',['data'=>$data]);	
	}

	
	public function edit_subjects(Request $request) // Viewall catalogues.
	{		
		if ($request->input('_token')) {
			$user = Auth::guard('admin')->user();
			$subjecttable = Subjects::where('su_id',$request->input('su_id'))->first();
			$subjecttable->book_image = $request->hasFile('book_image')?CommonModel::upload_file('book_image',$request->file('book_image'),$path = 'book_image'):$request->input('bk_book_image');	
			$subjecttable->su_name = $request->input('su_name');		
			$subjecttable->description = $request->input('description');	
			$subjecttable->auther_name = $request->input('auther_name');	
			$subjecttable->su_price = $request->input('su_price');
			
			//	print_r($subjecttable);exit;
			$subjecttable->save();
			if ($subjecttable->save()) {

				// if(strlen($request->input('str_fk_class_id')) > 1){
				// 	$str_fk_class_id = explode(",",$request->input('str_fk_class_id'));
				// 	Subjects_class_course::where('fk_subject_id',$request->input('su_id'))->delete();
				// 	foreach($str_fk_class_id as $cid){
				// 		$scc = new Subjects_class_course;
				// 		$scc->fk_class_id = $cid;	
				// 		$scc->slug = CommonModel::add_slug('subjects_class_course',bin2hex(openssl_random_pseudo_bytes(5))); 
				// 		$scc->fk_subject_id = $subjecttable->su_id;	
				// 		$scc->save();
				// 	}					
				// }

	Subjects_class_course::where('fk_subject_id',$request->input('su_id'))->delete();
					foreach($request->input('subcourse') as $cid){
						$scc = new Subjects_class_course;
						$scc->fk_class_id = $cid;	
						$scc->slug = CommonModel::add_slug('subjects_class_course',bin2hex(openssl_random_pseudo_bytes(5))); 
						$scc->fk_subject_id = $subjecttable->su_id;	
						$scc->save();
					}

				return redirect('view_subject')->with('msg','Added succesfully!');
			}else{
				return redirect('view_subject')->with('errmsg', 'Error!');
			}
		}
		$whereclass = ['cl_delete'=>1];
		$data['classtable'] = Classtable::view_all($whereclass);
		$where = ['su_delete'=>1,'su_id'=>$request->input('id')];
		$data['row'] = Subjects::view_single($where);
		$wherescc = ['scc_delete'=>1,'fk_subject_id'=>$request->input('id')];
		$data['allrow'] = Subjects_class_course::view_all_single($wherescc);
		$data['allrow_sccid'] = explode(",",$data['allrow']['scc_id_str']);
	// print_r($data['allrow']['allrow_sccid']);exit;
	// echo in_array("33", $data['allrow_sccid'])?'selected':'';exit;
		 //print_r($data['allrow']['scc_id']);exit;
		 
		return view('master.edit_subjects',['data'=>$data]);	
	
}

	public function view_subjects_details(Request $request) // Viewall catalogues.
	{		
		
		$whereclass = ['cl_delete'=>1];
		$data['classtable'] = Classtable::view_all($whereclass);
		$where = ['su_delete'=>1,'su_id'=>$request->input('id')];
		$data['row'] = Subjects::view_single($where);
		$wherescc = ['scc_delete'=>1,'fk_subject_id'=>$request->input('id')];
		$data['allrow'] = Subjects_class_course::view_all_single($wherescc);
		$data['allrow_sccid'] = explode(",",$data['allrow']['scc_id_str']);
	// print_r($data['allrow']['allrow_sccid']);exit;
	// echo in_array("33", $data['allrow_sccid'])?'selected':'';exit;
		 //print_r($data['allrow']['scc_id']);exit;
		 
		return view('master.view_subjects_details',['data'=>$data]);	
	
}
	
	public function autosearch_class(Request $request) // Viewall catalogues.
	{
		$whereclass = ['cl_delete'=>1];
		return $data['classtable'] = Classtable::autosearch_class($whereclass,$request->input('search_string'));
			
	}

	public function view_audiovideo(Request $request) // Viewall catalogues.
	{		
		
		$whereav = ['av_delete'=>1];
		$data['tabledata'] = Audiovideo::view_all($whereav);
		// print_r($data['tabledata']);exit;
		return view('master.view_audiovideo',['data'=>$data]);	
	}

	public function add_audiovideo(Request $request) // Viewall catalogues.
	{		
		if ($request->input('_token')) {
			$user = Auth::guard('admin')->user();
		
			  $data = $request->all();
echo "<pre>";	print_r($data);


			$av_name = $request->input('av_name');
			$av_url = $request->file('av_url');
			$av_url_url = $request->input('av_url');
			$video_type = $request->input('video_type');
			$countmore = $request->input('countmore');
			$video_type_url_file = $request->input('video_type_url_file');
       
			$count = 0;
		
			if(isset($av_name)){			
			foreach($av_name as $rowdata){	
				$urltype = $video_type_url_file[$count];
		if($urltype == 'file'){	
				$av_url = CommonModel::upload_file('audiovideo',$request->file('av_url'.$countmore[$count]),$path = 'audiovideo'); 
    	}
		if($urltype == 'url'){		
			 $av_url = $request->input('av_url'.$countmore[$count]); 			
		}
	
					$audvid = new Audiovideo;
					$audvid->slug = CommonModel::add_slug('audiovideo',bin2hex(openssl_random_pseudo_bytes(5))); 
					$audvid->fk_subject_id = $request->input('fk_subject_id');	
					$audvid->fk_chapter_id = $request->input('fk_chapter_id');	
					$audvid->av_name  = $av_name[$count];	
					$audvid->av_url =	 $av_url;													
					$audvid->video_type =  $video_type[$count];	
               $audvid->video_type_url_file  = $urltype;	
					$audvid->added_by = $user->id;
					$audvid->save();
				$count++;
			}}else{
				return redirect('view_audiovideo')->with('errmsg','Please Add Audio/Video Details');
			}

			if ($audvid->save()) {
				return redirect('view_audiovideo')->with('msg','Added succesfully!');
			}else{
				return redirect('view_audiovideo')->with('errmsg', 'Error!');
			}
		}
		$whereclass = ['ch_delete'=>1,'ch_id'=>$request->input('id')];
		$data['rowch'] = Chapter::view_single($whereclass);

		$wheresu = ['su_delete'=>1,'su_id'=>$data['rowch']['fk_subject_id']];
		$data['rowsu'] = Subjects::view_single($wheresu);
		//print_r($data['rowsu']);exit;
		return view('master.add_audiovideo',['data'=>$data]);	
	}

	public function edit_audiovideo(Request $request) // Viewall catalogues.
	{		
		if ($request->input('_token')) {
				if($request->input('video_type_url_file') == 'file'){
						$av_url = $request->hasFile('av_url')?CommonModel::upload_file('audiovideo',$request->file('av_url'),$path = 'audiovideo'):$request->input('bk_av_url'); 
				}else{
						$av_url = $request->input('av_url');		
				}
			$user = Auth::guard('admin')->user();
			$audvid = Audiovideo::where('av_id',$request->input('av_id'))->first();
					
			$audvid->av_name = $request->input('av_name');	
			$audvid->av_url = $av_url;	
			$audvid->video_type = $request->input('video_type');		
         $audvid->video_type_url_file = $request->input('video_type_url_file');		
			//	print_r($audvid);exit;
			$audvid->save();
			if ($audvid->save()) {
				return redirect('view_audiovideo')->with('msg','Updated succesfully!');
			}else{
				return redirect('view_audiovideo')->with('errmsg', 'Error!');
			}
		}
		$wheresu = ['av_delete'=>1,'av_id'=>$request->input('id')];
		$data['row'] = Audiovideo::view_single($wheresu);	

		$whereclass = ['ch_delete'=>1,'ch_id'=>$request->input('id')];
		$data['rowch'] = Chapter::view_single($whereclass);

		$wheresu = ['su_delete'=>1,'su_id'=>$data['rowch']['fk_subject_id']];
		$data['rowsu'] = Subjects::view_single($wheresu);
		//print_r($data['row'] );exit;
		return view('master.edit_audiovideo',['data'=>$data]);	
	}

	public function get_subject_from_courseclass(Request $request) // Viewall catalogues.
	{		
		$wheresu = ['su_delete'=>1,'fk_class_id'=>$request->input('id')];
		return $subjects = Subjects::get_subject_from_courseclass($wheresu);		
	}

	public function get_chapter_from_subject(Request $request) // Viewall catalogues.
	{		
		$wheresu = ['ch_delete'=>1,'fk_subject_id'=>$request->input('id')];
		return $chapter = Chapter::view_all($wheresu);
	}

	public function get_class_from_type(Request $request) // Viewall catalogues.
	{		
		$wheresu = ['cl_delete'=>1,'type'=>$request->input('id')];
		return $subjects = Classtable::view_all($wheresu);		
	}

	public function chech_onkeyup(Request $request) // Viewall catalogues.
	{		
	
			$onkeyupval = $request->input('onkeyupval');
			$table_name = $request->input('table_name');
			$column_name = $request->input('column_name');			
			$delete_column_name = $request->input('delete_prefix');
		
			return $rowcount = \DB::table($table_name)->
			where($column_name,$onkeyupval)->
			where($delete_column_name,'1')->
			count();  	
	}

	public function view_all_array_in(Request $request) // Viewall catalogues.
	{		
		$wheresu = ['su_delete'=>1];
		$array_in = explode(',',$request->input('post_commaseprated_id'));
		return $subjects = Subjects::view_all_array_in($wheresu,$array_in);			
	}

	public function deleterow(Request $request)
    {
        $slug = $request->input('slug');
        $column_name = $request->input('column_name');
        $table_name = $request->input('table_name');
        $data = array($column_name => 0);
        $updatestatus =  \DB::table($table_name)->where('slug',$slug)->update($data);            
        if($updatestatus == true){
            $msg = "success";
        }else{
            $msg = "error";
        }
        exit;
	}

	public function view_questions(Request $request) // Viewall catalogues.
	{		
		
		$whereav = ['q_delete'=>1,'questions.fk_chapter_id'=>$request->has('id')?$request->input('id'):'','questions.pagename'=>$request->has('type')?$request->input('type'):''];
		
		$data['tabledata'] = Questions::view_all(array_filter($whereav));
		// print_r($data['tabledata']);exit;
		return view('master.view_questions',['data'=>$data]);	
	}
	
	public function add_mcq(Request $request) // Viewall catalogues.
	{		
		if ($request->input('_token')) {
			$user = Auth::guard('admin')->user();
			 
			$option_a = $request->input('optiona');
			$option_b = $request->input('optionb');
			$option_c = $request->input('optionc');
			$option_d = $request->input('optiond');
			$answer = $request->input('answer');
			$marks = $request->input('marks');
			$q_audio = $request->file('q_audio');
			$question = $request->input('question');
		//print_r($q_audio);exit;
		if(isset($answer)){
			$count = 0;
			foreach($answer as  $rows){
			$ques = new Questions;
			$ques->slug = CommonModel::add_slug('questions',bin2hex(openssl_random_pseudo_bytes(5))); 		
			$ques->fk_subject_id = $request->input('fk_subject_id');	
			$ques->fk_chapter_id = $request->input('fk_chapter_id');	
			$ques->question = $question[$count];	
			$ques->q_audio = CommonModel::upload_file('questionaudio',$q_audio[$count],$path = 'questionaudio');

			$ques->marks = $marks[$count];	
			$ques->answer = $answer[$count];
			$ques->type_name = 'MCQ';
			$ques->table_name = 'ques_mcq';	
			$ques->table_id = 'mcq_id';	
			$ques->pagename = 'mcq';	
			$ques->created_by = $user->id;
			$ques->save();		
			
			$secondary = new Ques_mcq;
			$secondary->fk_question_id = $ques->q_id;
			$secondary->op_a = $option_a[$count];
			$secondary->op_b = $option_b[$count];
			$secondary->op_c = $option_c[$count];
			$secondary->op_d = $option_d[$count];
			$secondary->save();
			$count++;
			}
			return redirect('view_questions?id='.$request->input('fk_chapter_id'))->with('msg','Added succesfully!');
			
		}else{
			return redirect('view_questions?id='.$request->input('fk_chapter_id'))->with('errmsg', 'Please Fill Up Questions Details');
		}	
		}
		
		
		$where = ['ch_delete'=>1,'chapter.ch_id'=>$request->has('chapter_id')?$request->input('chapter_id'):''];
		$data['row'] = Chapter::view_all_withjoin(array_filter($where));
		//print_r($data['row']);exit;
		return view('master.add_mcq',['data'=>$data]);	
	}

	public function edit_mcq(Request $request) // Viewall catalogues.
	{		
		if ($request->input('_token')) {
			$user = Auth::guard('admin')->user();
			 
			$option_a = $request->input('optiona');
			$option_b = $request->input('optionb');
			$option_c = $request->input('optionc');
			$option_d = $request->input('optiond');
			$answer = $request->input('answer');
			$marks = $request->input('marks');
			$question = $request->input('question');
		
			$ques = Questions::where('q_id',$request->input('id'))->first();
			$ques->question = $question;			
			$ques->marks = $marks;	
			$ques->answer = $answer;
			$ques->q_audio = $request->hasFile('q_audio')?CommonModel::upload_file('questionaudio',$request->file('q_audio'),$path = 'questionaudio'):$request->input('bk_q_audio');	

			$ques->save();
	
			$secondary = Ques_mcq::where('fk_question_id',$request->input('id'))->first();
			$secondary->op_a = $option_a;
			$secondary->op_b = $option_b;
			$secondary->op_c = $option_c;
			$secondary->op_d = $option_d;
			$secondary->save();

			if ($secondary->save()) {
				return redirect('view_questions')->with('msg','Updated succesfully!');
			}else{
				return redirect('view_questions')->with('errmsg', 'Error!');
			}	
		}
		
		
		$where = ['q_delete'=>1,'q_id'=>$request->input('id')];
		$data['rowques'] = Questions::view_single($where);
		$wheresubq = ['fk_question_id'=>$request->input('id')];
		$data['rowsubques'] = Ques_mcq::view_single($wheresubq);
		//  print_r($data['rowques']['question']);exit;
		return view('master.edit_mcq',['data'=>$data]);	
	}

	public function add_fillin_blanks(Request $request) // Viewall catalogues.
	{		
		if ($request->input('_token')) {

			$user = Auth::guard('admin')->user();			 
			$option_a = $request->input('optiona');
			$option_b = $request->input('optionb');
			$option_c = $request->input('optionc');
			$option_d = $request->input('optiond');		
			$marks = $request->input('marks');
			$question = $request->input('question');
			$q_audio = $request->file('q_audio');
		if(isset($question)){
			$count = 0;
			foreach($question as  $rows){
			$ques = new Questions;
			$ques->slug = CommonModel::add_slug('questions',bin2hex(openssl_random_pseudo_bytes(5))); 		
			$ques->fk_subject_id = $request->input('fk_subject_id');	
			$ques->fk_chapter_id = $request->input('fk_chapter_id');	
			$ques->question = $question[$count];			
			$ques->marks = $marks[$count];	
			$ques->q_audio = CommonModel::upload_file('questionaudio',$q_audio[$count],$path = 'questionaudio');

			//$ques->answer = $answer[$count];
			$ques->type_name = 'Fill In The Blank';
			$ques->table_name = 'ques_fillin_the_blank';	
			$ques->table_id = 'ftb_id';	
			$ques->pagename = 'fillin_blanks';	
			$ques->created_by = $user->id;
			$ques->save();		
			
			$secondary = new Ques_fillin_the_blank;
			$secondary->fk_question_id = $ques->q_id;
			$secondary->op_a = $option_a[$count];
			$secondary->op_b = $option_b[$count];
			$secondary->op_c = $option_c[$count];			
			$secondary->save();
			$count++;
			}
			return redirect('view_questions?id='.$request->input('fk_chapter_id'))->with('msg','Added succesfully!');
			
		}else{
			return redirect('view_questions?id='.$request->input('fk_chapter_id'))->with('errmsg', 'Please Fill Up Questions Details');
		}	
		}
		
		$where = ['ch_delete'=>1,'chapter.ch_id'=>$request->has('chapter_id')?$request->input('chapter_id'):''];
		$data['row'] = Chapter::view_all_withjoin(array_filter($where));
		return view('master.add_fillin_blanks',['data'=>$data]);	
	}

	public function edit_fillin_blanks(Request $request) // Viewall catalogues.
	{		
		if ($request->input('_token')) {
			$user = Auth::guard('admin')->user();
			 
			$option_a = $request->input('optiona');
			$option_b = $request->input('optionb');
			$option_c = $request->input('optionc');			
			$answer = $request->input('answer');
			$marks = $request->input('marks');
			$question = $request->input('question');
		
			$ques = Questions::where('q_id',$request->input('id'))->first();
			$ques->question = $question;			
			$ques->marks = $marks;
				$ques->q_audio = $request->hasFile('q_audio')?CommonModel::upload_file('questionaudio',$request->file('q_audio'),$path = 'questionaudio'):$request->input('bk_q_audio');	
	
			$ques->save();
	
			$secondary = Ques_fillin_the_blank::where('fk_question_id',$request->input('id'))->first();
			$secondary->op_a = $option_a;
			$secondary->op_b = $option_b;
			$secondary->op_c = $option_c;
			$secondary->save();

			if ($secondary->save()) {
				return redirect('view_questions')->with('msg','Updated succesfully!');
			}else{
				return redirect('view_questions')->with('errmsg', 'Error!');
			}	
		}
		
		
		$where = ['q_delete'=>1,'q_id'=>$request->input('id')];
		$data['rowques'] = Questions::view_single($where);
		$wheresubq = ['fk_question_id'=>$request->input('id')];
		$data['rowsubques'] = Ques_fillin_the_blank::view_single($wheresubq);
		 //print_r($data['rowsubques']['op_c']);exit;
		return view('master.edit_fillin_blanks',['data'=>$data]);	
	}


	public function add_match_pairs(Request $request) // Viewall catalogues.
	{		
		if ($request->input('_token')) {
			$user = Auth::guard('admin')->user();
			 
			$lastcount = $request->input('lastcount');
			$checkid = $request->input('checkid');
			$option_a = $request->input('optiona');
			$option_b = $request->input('optionb');
			$option_c = $request->input('optionc');
			$option_d = $request->input('optiond');		
			$marks = $request->input('marks');
			$question = $request->input('question');
			$noof_pairs = $request->input('noof_pairs');
			$pair_type = $request->input('mtp_type');
			$q_audio = $request->file('q_audio');

		if(isset($question)){
			$count = 0;
			foreach($question as  $rows){
			$ques = new Questions;
			$ques->slug = CommonModel::add_slug('questions',bin2hex(openssl_random_pseudo_bytes(5))); 		
			$ques->fk_subject_id = $request->input('fk_subject_id');	
			$ques->fk_chapter_id = $request->input('fk_chapter_id');	
			$ques->question = $question[$count];	
			$ques->q_audio = CommonModel::upload_file('questionaudio',$q_audio[$count],$path = 'questionaudio');
		
			$ques->marks = $marks[$count];	
			$ques->noof_pairs = (int)$noof_pairs[$count];	
			$ques->pair_type = $pair_type[$count];	
			//$ques->answer = $answer[$count];
			$ques->type_name = 'Match The Pair';
			$ques->table_name = 'ques_match_the_pair';	
			$ques->table_id = 'mtp_id';	
			$ques->pagename = 'match_pairs';	
			$ques->created_by = $user->id;
			$ques->save();	
			$cnt = (int)$checkid[$count];				
				$mtp_option = $request->input('mtp_option_'.$cnt);
				$mtp_answer_ans = $request->input('mtp_answer_ans_'.$cnt);
				
				$countq = 0;
				if(isset($mtp_answer_ans)){
				foreach($mtp_answer_ans as  $qrow){					
					
					if($pair_type[$count] == 'text'){	
						$mtp_answer = $request->input('mtp_answer_'.$cnt);					
						$pair_option = $mtp_answer[$countq];
					}else{			
						$mtp_answer = $request->file('mtp_answer_'.$cnt);	
					//	$opfile = $request->file($mtp_answer[$countq]);	
						//$audvid->av_url =	 CommonModel::upload_file('audiovideo', $av_url[$count],$path = 'audiovideo'); 		
						$pair_option = CommonModel::upload_file('audiovideo',$mtp_answer[$countq],$path = 'audiovideo');
					}
					$secondary = new Ques_match_the_pair;
					$secondary->fk_question_id = $ques->q_id;
					$secondary->pair_option = $pair_option;
					$secondary->pair = $mtp_option[$countq];
					$secondary->mtp_answer = $mtp_answer_ans[$countq];			
					$secondary->save();
					$countq++;
				}
				}
				$cnt++;					
			$count++;
			}
			
			return redirect('view_questions?id='.$request->input('fk_chapter_id'))->with('msg','Added succesfully!');
			
		}else{
			return redirect('view_questions?id='.$request->input('fk_chapter_id'))->with('errmsg', 'Please Fill Up Questions Details');
		}	
		}
		
		$where = ['ch_delete'=>1,'chapter.ch_id'=>$request->has('chapter_id')?$request->input('chapter_id'):''];
		$data['row'] = Chapter::view_all_withjoin($where);
		return view('master.add_match_pairs',['data'=>$data]);	
	}

	public function edit_match_pairs(Request $request) // Viewall catalogues.
	{		
		if ($request->input('_token')) {
			$user = Auth::guard('admin')->user();
			 
			$option_a = $request->input('optiona');
			$option_b = $request->input('optionb');
			$option_c = $request->input('optionc');			
			$answer = $request->input('answer');
			$marks = $request->input('marks');
			$question = $request->input('question');

			$ques = Questions::where('q_id',$request->input('id'))->first();
			$ques->question = $question;			
			$ques->marks = $marks;	
			//$ques->q_audio = $request->hasFile('q_audio')?CommonModel::upload_file('questionaudio',$request->file('q_audio'),$path = 'questionaudio'):$request->input('bk_q_audio');
			$ques->save();
	
			$secondary = Ques_match_the_pair::where('fk_question_id',$request->input('id'))->first();
			$secondary->op_a = $option_a;
			$secondary->op_b = $option_b;
			$secondary->op_c = $option_c;
			$secondary->save();

			if ($secondary->save()) {
				return redirect('view_questions')->with('msg','Updated succesfully!');
			}else{
				return redirect('view_questions')->with('errmsg', 'Error!');
			}	
		}
		
		
		$where = ['q_delete'=>1,'q_id'=>$request->input('id')];
		$data['rowques'] = Questions::view_single($where);
		$wheresubq = ['fk_question_id'=>$request->input('id')];
		$data['rowsubques'] = Ques_match_the_pair::view_single($wheresubq);
		//print_r($data);
		return view('master.edit_match_pairs',['data'=>$data]);	
	}


	public function add_alphabet_tracing(Request $request) // Viewall catalogues.
	{		
		if ($request->input('_token')) {
			$user = Auth::guard('admin')->user();
			 
			$option_a = $request->input('optiona');
			$option_b = $request->input('optionb');
			$option_c = $request->input('optionc');
			$option_d = $request->input('optiond');
			$answer = $request->input('answer');
			$marks = $request->input('marks');
			$question = $request->input('question');
		
		if(isset($answer)){
			$count = 0;
			foreach($answer as  $rows){
				$ques = new Questions;
			$ques->slug = CommonModel::add_slug('questions',bin2hex(openssl_random_pseudo_bytes(5))); 
			$ques->fk_type_id = $request->input('fk_type_id');	
			$ques->fk_class_id = $request->input('fk_class_id');	
			$ques->fk_subject_id = $request->input('fk_subject_id');	
			$ques->question = $question[$count];			
			$ques->marks = $marks[$count];	
			//$ques->answer = $answer[$count];
			$ques->table_name = 'ques_mcq';	
			$ques->table_id = 'mcq_id';	
			$ques->pagename = 'alphabet_tracing';	
			$ques->created_by = $user->id;
			$ques->save();		
			
			$secondary = new Ques_mcq;
			$secondary->fk_question_id = $ques->q_id;
			$secondary->op_a = $option_a[$count];
			$secondary->op_b = $option_b[$count];
			$secondary->op_c = $option_c[$count];
			$secondary->op_d = $option_d[$count];
			$secondary->save();
			$count++;
			}
			return redirect('view_questions')->with('msg','Added succesfully!');
			
		}else{
			return redirect('view_questions')->with('errmsg', 'Please Fill Up Questions Details');
		}	
		}
		
		$where = ['ch_delete'=>1,'chapter.ch_id'=>$request->has('chapter_id')?$request->input('chapter_id'):''];
		$data['row'] = Chapter::view_all_withjoin($where);
		return view('master.add_alphabet_tracing',['data'=>$data]);	
	}

	public function add_truefalse(Request $request) // Viewall catalogues.
	{		
		if ($request->input('_token')) {
			$user = Auth::guard('admin')->user();
			 
			$answer = $request->input('answer');
			$marks = $request->input('marks');
			$question = $request->input('question');
			$q_audio = $request->file('q_audio');
		if(isset($question)){
			$count = 0;
			foreach($question as  $rows){
			$ques = new Questions;
			$ques->slug = CommonModel::add_slug('questions',bin2hex(openssl_random_pseudo_bytes(5))); 		
			$ques->fk_subject_id = $request->input('fk_subject_id');	
			$ques->fk_chapter_id = $request->input('fk_chapter_id');	
			$ques->question = $question[$count];	
			$ques->q_audio = CommonModel::upload_file('questionaudio',$q_audio[$count],$path = 'questionaudio');		
			$ques->marks = $marks[$count];	
			$ques->answer = $answer[$count];
			$ques->type_name = 'True False';
			$ques->table_name = 'ques_truefalse';	
			$ques->table_id = 'tf_id';	
			$ques->pagename = 'truefalse';
			$ques->created_by = $user->id;
			$ques->save();		
			
			$secondary = new Ques_truefalse;
			$secondary->fk_question_id = $ques->q_id;
			$secondary->save();
			$count++;
			}
			return redirect('view_questions?id='.$request->input('fk_chapter_id'))->with('msg','Added succesfully!');
			
		}else{
			return redirect('view_questions?id='.$request->input('fk_chapter_id'))->with('errmsg', 'Please Fill Up Questions Details');
		}	
		}
		
		
		$where = ['ch_delete'=>1,'chapter.ch_id'=>$request->has('chapter_id')?$request->input('chapter_id'):''];
		$data['row'] = Chapter::view_all_withjoin($where);
		//print_r($data['row']);exit;
		return view('master.add_truefalse',['data'=>$data]);	
	}

	public function edit_truefalse(Request $request) // Viewall catalogues.
	{		
		if ($request->input('_token')) {
			$user = Auth::guard('admin')->user();
			 
					
			$answer = $request->input('answer');
			$marks = $request->input('marks');
			$question = $request->input('question');
		
			$ques = Questions::where('q_id',$request->input('id'))->first();
			$ques->question = $question;			
			$ques->marks = $marks;
			$ques->answer = $answer;
				$ques->q_audio = $request->hasFile('q_audio')?CommonModel::upload_file('questionaudio',$request->file('q_audio'),$path = 'questionaudio'):$request->input('bk_q_audio');	
	
			$ques->save();
	
			if ($ques->save()) {
				return redirect('view_questions')->with('msg','Updated succesfully!');
			}else{
				return redirect('view_questions')->with('errmsg', 'Error!');
			}	
		}
		
		
		$where = ['q_delete'=>1,'q_id'=>$request->input('id')];
		$data['rowques'] = Questions::view_single($where);
		$wheresubq = ['fk_question_id'=>$request->input('id')];
		$data['rowsubques'] = Ques_truefalse::view_single($wheresubq);
		 //print_r($data['rowsubques']['op_c']);exit;
		return view('master.edit_truefalse',['data'=>$data]);	
	}

	public function view_school(Request $request) // Viewall catalogues.
	{
		$whereav = ['sc_delete'=>1];
		$data['tabledata'] = School::view_all($whereav);
		// print_r($data['tabledata']);exit;
		return view('master.view_school',['data'=>$data]);	
	}
	


	public function add_school(Request $request) // Viewall catalogues.
	{		
		if ($request->input('_token')) {
			$user = Auth::guard('admin')->user();
			$school = new School;
			$school->slug = CommonModel::add_slug('school',bin2hex(openssl_random_pseudo_bytes(5))); 
			$school->sc_name = $request->input('sc_name');	
			$school->sc_location = $request->input('sc_location');
			$school->sc_city = $request->input('sc_city');
			$school->sc_baord_affilation = $request->input('sc_baord_affilation');
			$school->sc_contact_person = $request->input('sc_contact_person');
			$school->sc_contact_number = $request->input('sc_contact_number');	
			$school->sc_email_id = $request->input('sc_email_id');
			$school->sc_website = $request->input('sc_website');
			$school->added_by = $user->id;
			//	print_r($audvid);exit;
			$school->save();

		

			if ($school->save()) {

				$table = new Schoolbranch;
				$table->slug = CommonModel::add_slug('schoolbranch',bin2hex(openssl_random_pseudo_bytes(5)));	
				$table->fk_school_slug = $school->slug;		
				$table->sb_location = $request->input('sc_location');
				$table->sb_city = $request->input('sc_city');
				$table->sb_baord_affilation = $request->input('sc_baord_affilation');
				$table->sb_contact_person = $request->input('sc_contact_person');
				$table->sb_contact_number = $request->input('sc_contact_number');	
				$table->sb_email_id = $request->input('sc_email_id');
				//$table->sb_website = $request->input('sb_website');
				$table->added_by = $user->id;
				$table->save();

				return redirect('view_school')->with('msg','Added succesfully!');
			}else{
				return redirect('view_school')->with('errmsg', 'Error!');
			}
		}
		$data = array();
		return view('master.add_school',['data'=>$data]);	
	}

	public function edit_school(Request $request) // Viewall catalogues.
	{		
		if ($request->input('_token')) {
			$user = Auth::guard('admin')->user();
			$school = School::where('sc_id',$request->input('sc_id'))->first();
			$school->sc_name = $request->input('sc_name');	
			$school->sc_location = $request->input('sc_location');	
			$school->sc_city = $request->input('sc_city');
			$school->sc_baord_affilation = $request->input('sc_baord_affilation');
			$school->sc_contact_person = $request->input('sc_contact_person');
			$school->sc_contact_number = $request->input('sc_contact_number');	
			$school->sc_email_id = $request->input('sc_email_id');
			$school->sc_website = $request->input('sc_website');
			$school->added_by = $user->id;
			//	print_r($audvid);exit;
			$school->save();
			if ($school->save()) {
				return redirect('view_school')->with('msg','Updated succesfully!');
			}else{
				return redirect('view_school')->with('errmsg', 'Error!');
			}
		}
		$whereav = ['sc_delete'=>1,'sc_id'=>$request->input('id')];
		$data['row'] = School::view_single($whereav);
		return view('master.edit_school',['data'=>$data]);	
	}


	public function view_school_details(Request $request) // Viewall catalogues.
	{
		$whereav = ['sc_delete'=>1,'sc_id'=>$request->input('id')];
		$data['row'] = School::view_single($whereav);
		// print_r($data['tabledata']);exit;
		return view('master.view_school_details',['data'=>$data]);	
	}

	public function view_user(Request $request) // Viewall catalogues.
	{
		$whereav = ['ma_delete'=>1];
		$data['tabledata'] = Master_admin::view_all($whereav);
		// print_r($data['tabledata']);exit;
		return view('master.view_user',['data'=>$data]);	
	}

	public function add_user(Request $request) // Viewall catalogues.
	{		
		if ($request->input('_token')) {
			$users = Auth::guard('admin')->user();
			$user = new Master_admin;
			$user->slug = CommonModel::add_slug('master_admin',bin2hex(openssl_random_pseudo_bytes(5))); 
			$user->fk_role_id = $request->input('fk_role_id');	
		//	$user->regi_code = $request->has('regi_code')?$request->input('regi_code'):'';	
			$user->full_name = $request->input('full_name');	
			$user->phone_number = $request->input('phone_number');	
			$user->email = $request->input('email');	
			$user->password = $request->input('password');	
		//	$user->dob = date('Y-m-d', strtotime($request->input('dob')));	
			$user->gender = $request->has('gender')?$request->input('gender'):'';	
			$user->fk_school_id = $request->has('fk_school_id')?$request->input('fk_school_id'):0;	
			$user->fk_class_id = $request->has('fk_class_id')?$request->input('fk_class_id'):0;		
			$user->created_by = $users->id;

			//	print_r($audvid);exit;
			$user->save();
			if ($user->save()) {

				if($request->input('fk_role_id') == 6){
			
					if(strlen($request->input('str_fk_class_id')) > 1){
						$str_fk_class_id = explode(",",$request->input('str_fk_class_id'));
						print_r($str_fk_class_id);
						foreach($str_fk_class_id as $cid){
							$ucc = new User_class_course;
							$ucc->fk_class_id = $cid;	
							$ucc->slug = CommonModel::add_slug('user_class_course',bin2hex(openssl_random_pseudo_bytes(5))); 
							$ucc->fk_user_id = $user->id;	
							$ucc->save();
						}					
					}
				}

			
				return redirect('view_user')->with('msg','Added succesfully!');
			}else{
				return redirect('view_user')->with('errmsg', 'Error!');
			}
		}
		$whererole = ['ro_delete'=>1];
		$data['roletable'] = Role::view_all($whererole);
		$whereschool = ['sc_delete'=>1];
		$data['schooltable'] = School::view_all($whereschool);
		$whereclass = ['cl_delete'=>1];
		$data['classtable'] = Classtable::view_all($whereclass);
		
		return view('master.add_user',['data'=>$data]);	
	}

	public function edit_user(Request $request) // Viewall catalogues.
	{		
		if ($request->input('_token')) {
			$users = Auth::guard('admin')->user();
			$user = Master_admin::where('id',$request->input('id'))->first();
			$user->slug = CommonModel::add_slug('master_admin',bin2hex(openssl_random_pseudo_bytes(5))); 
			$user->fk_role_id = $request->input('fk_role_id');	
			$user->regi_code = $request->has('regi_code')?$request->input('regi_code'):'';	
			$user->full_name = $request->input('full_name');	
			$user->phone_number = $request->input('phone_number');	
			$user->email = $request->input('email');	
			$user->password = $request->input('password');	
			$user->dob = date('Y-m-d', strtotime($request->input('dob')));	
			$user->gender = $request->input('gender');	
			$user->fk_school_id = $request->has('fk_school_id')?$request->input('fk_school_id'):0;	
			$user->fk_class_id = $request->has('fk_class_id')?$request->input('fk_class_id'):0;		
			$user->created_by = $users->id;

			//	print_r($audvid);exit;
			$user->save();
			if ($user->save()) {
				return redirect('view_user')->with('msg','Updated succesfully!');
			}else{
				return redirect('view_user')->with('errmsg', 'Error!');
			}
		}
		$whererole = ['ro_delete'=>1];
		$data['roletable'] = Role::view_all($whererole);
		$whereschool = ['sc_delete'=>1];
		$data['schooltable'] = School::view_all($whereschool);
		$whereclass = ['cl_delete'=>1];
		$data['classtable'] = Classtable::view_all($whereclass);
		$wherema = ['ma_delete'=>1,'id'=>$request->input('id')];
		$data['row'] = Master_admin::view_single($wherema);
		//echo "<pre>";print_r($data);
		return view('master.edit_user',['data'=>$data]);	
	}


	public function view_user_details(Request $request) // Viewall catalogues.
	{
		$whererole = [];
		$data['roletable'] = Role::view_all($whererole);
		$whereschool = ['sc_delete'=>1];
		$data['schooltable'] = School::view_all($whereschool);
		$whereclass = ['cl_delete'=>1];
		$data['classtable'] = Classtable::view_all($whereclass);
		$wherema = ['ma_delete'=>1,'id'=>$request->input('id')];
		$data['row'] = Master_admin::view_single($wherema);
		//echo "<pre>";print_r($data);
		// print_r($data['tabledata']);exit;
		return view('master.view_user_details',['data'=>$data]);	
	}

	public function view_chapter(Request $request) // Viewall catalogues.
	{		
		$where = ['ch_delete'=>1];
		$data['tabledata'] = Chapter::view_all($where);
		$data['tabledata']->transform(function($i){                   
            $subject = Subjects::view_single(array('su_id'=>$i['fk_subject_id']));           
            $i['su_name'] = $subject['su_name'];
            return $i;
        });
		// print_r($data['tabledata']);exit;
		return view('master.view_chapter',['data'=>$data]);	
	}

	public function add_chapter(Request $request) // Viewall catalogues.
	{		
		if ($request->input('_token')) {
			$user = Auth::guard('admin')->user();
			
			$ch_name = $request->input('ch_name');		
			$ch_description = $request->input('ch_description');

			$count = 0;
			if(isset($ch_name)){
			foreach($ch_name as $ch){
				$subjecttable = new Chapter;
			    $subjecttable->slug = CommonModel::add_slug('chapter',bin2hex(openssl_random_pseudo_bytes(5))); 
				$subjecttable->ch_name = $ch_name[$count];		
				$subjecttable->ch_description = $ch_description[$count];	
				$subjecttable->fk_subject_id = $request->input('fk_subject_id');
				$subjecttable->added_by = $user->id;
				$subjecttable->save();
				$count++;
			}
			}else{
				return redirect('view_chapter')->with('errmsg','Please Add Chapter Name Description');
			}
			
			if ($subjecttable->save()) {			
				return redirect('view_chapter')->with('msg','Added succesfully!');
			}else{
				return redirect('view_chapter')->with('errmsg', 'Error!');
			}
		}
		$where = ['su_delete'=>1,'su_id'=>$request->input('id')];
		$data['row'] = Subjects::view_single($where);
	 //print_r($data['classtable']);exit;
		return view('master.add_chapter',['data'=>$data]);	
	}


	public function edit_chapter(Request $request) // Viewall catalogues.
	{		
	
			$user = Auth::guard('admin')->user();	
			
			if ($request->input('_token')) {
				$table = Chapter::where('slug',$request->input('slug'))->first();		
				$table->ch_name = $request->input('ch_name');
				$table->ch_description = $request->input('ch_description');		
				if ($table->save()) {			
					return redirect('view_chapter')->with('msg','Updated succesfully!');
				}else{
					return redirect('view_chapter')->with('errmsg', 'Error!');
				}		
			}	
		$where = ['ch_delete'=>1,'slug'=>$request->input('slug')];
		$data['row'] = Chapter::view_single($where);
	  // print_r($data['row']['ch_name']);exit;
		return view('master.edit_chapter',['data'=>$data]);	
	}

	public function view_chapter_details(Request $request) // Viewall catalogues.
	{		
	
			
		$where = ['ch_delete'=>1,'slug'=>$request->input('slug')];
		$data['row'] = Chapter::view_single($where);
	  // print_r($data['row']['ch_name']);exit;
		return view('master.view_chapter_details',['data'=>$data]);	
	}

	public function view_branch(Request $request) // Viewall catalogues.
	{
		$whereav = ['school.sc_delete'=>1,'sb_delete'=>1,'fk_school_slug'=>$request->has('fk_school_slug')?$request->input('fk_school_slug'):''];
		$data['tabledata'] = Schoolbranch::view_all(array_filter($whereav));
		$data['tabledata']->transform(function($i){                   
            $classdata = School::view_single(array('slug'=>$i['fk_school_slug']));           
            $i['sc_name'] = $classdata['sc_name'];
            return $i;
		});
		
		$whereavsc = ['sc_delete'=>1];
		$data['schooltable'] = School::view_all($whereavsc);
		 //  print_r($data['tabledata']);exit;
		return view('master.view_branch',['data'=>$data]);	
	}
	


	public function add_branch(Request $request) // Viewall catalogues.
	{		
		if ($request->input('_token')) {


			$user = Auth::guard('admin')->user();
			$table = new Schoolbranch;
			$table->slug = CommonModel::add_slug('schoolbranch',bin2hex(openssl_random_pseudo_bytes(5))); 
			$table->fk_school_slug = $request->input('fk_school_slug');	
			$table->sb_location = $request->input('sb_location');
			$table->sb_city = $request->input('sb_city');
			$table->sb_baord_affilation = $request->input('sb_baord_affilation');
			$table->sb_contact_person = $request->input('sb_contact_person');
			$table->sb_contact_number = $request->input('sb_contact_number');	
			$table->sb_email_id = $request->input('sb_email_id');
			// $table->sb_website = $request->input('sb_website');
			$table->added_by = $user->id;
			//	print_r($audvid);exit;
			$table->save();
			if ($table->save()) {
				return redirect('view_branch')->with('msg','Added succesfully!');
			}else{
				return redirect('view_branch')->with('errmsg', 'Error!');
			}
		}
		$whereav = ['sc_delete'=>1,'slug'=>$request->input('slug')];
		$data['row'] = School::view_single($whereav);
		return view('master.add_branch',['data'=>$data]);	
	}

	public function edit_branch(Request $request) // Viewall catalogues.
	{		
		if ($request->input('_token')) {
			$user = Auth::guard('admin')->user();
			$table = Schoolbranch::where('slug',$request->input('slug'))->first();			
			$table->sb_location = $request->input('sb_location');	
			$table->sb_city = $request->input('sb_city');
			$table->sb_baord_affilation = $request->input('sb_baord_affilation');
			$table->sb_contact_person = $request->input('sb_contact_person');
			$table->sb_contact_number = $request->input('sb_contact_number');	
			$table->sb_email_id = $request->input('sb_email_id');
		//	$table->sb_website = $request->input('sb_website');
			$table->added_by = $user->id;
			//	print_r($audvid);exit;
			$table->save();
			if ($table->save()) {
				return redirect('view_branch')->with('msg','Updated succesfully!');
			}else{
				return redirect('view_branch')->with('errmsg', 'Error!');
			}
		}
		$whereav = ['sb_delete'=>1,'sb_id'=>$request->input('id')];
		$data['row'] = Schoolbranch::view_single($whereav);
		$whereavsc = ['slug'=>$data['row']['fk_school_slug']];
		$data['schooltable'] = School::view_single($whereavsc);
		return view('master.edit_branch',['data'=>$data]);	
	}
	
	
	public function view_units(Request $request) // Viewall catalogues.
	{		
		$where = ['un_delete'=>1];
		$data['tabledata'] = Units::view_all($where);
		return view('master.view_units',['data'=>$data]);	
	}

	public function add_units(Request $request) // Viewall catalogues.
	{		
		if ($request->input('_token')) {
			$user = Auth::guard('admin')->user();			
			$table = new units;
			$table->slug = CommonModel::add_slug('units',bin2hex(openssl_random_pseudo_bytes(5)));
			$table->un_name = $request->input('un_name');		
			
			$table->added_by = $user->id;
			$table->save();
			if ($table->save()) {
				return redirect('view_units')->with('msg','Added succesfully!');
			}else{
				return redirect('view_units')->with('errmsg', 'Error!');
			}
		}
		$data = array();
		return view('master.add_units',['data'=>$data]);	
	}

	public function edit_units(Request $request) // Viewall catalogues.
	{		
		if ($request->input('_token')) {
			$user = Auth::guard('admin')->user();
			$table = Units::where('slug',$request->input('slug'))->first();
			$table->un_name = $request->input('un_name');		
				
			$table->save();
			if ($table->save()) {
				return redirect('view_units')->with('msg','Updated succesfully!');
			}else{
				return redirect('view_units')->with('errmsg', 'Error!');
			}
		}
		$where = ['un_delete'=>1,'slug'=>$request->input('slug')];
		$data['row'] = Units::view_single($where);
		
		// print_r($data['row']);exit;
		return view('master.edit_units',['data'=>$data]);	
	}


		
public function view_codegenerators(Request $request) // Viewall catalogues.
	{		
		$where = ['co_delete'=>1];
		$data['tabledata'] = Codegenerators::view_all($where);
		$data['tabledata']->transform(function($i){    
				$schoolname =  School::view_single(array('slug'=>$i['fk_school_slug']));        
				$i['school_name'] = $schoolname['sc_name'];
				$branchname =  Schoolbranch::view_single(array('slug'=>$i['fk_branch_slug']));   
				$i['branch_name'] = $branchname['sb_location'];
				$coursename =  Classtable::view_single(array('cl_id'=>$i['fk_course_id']));   
				$i['course_name'] = $coursename['cl_name'];
				$subjectname =  Subjects::view_single(array('su_id'=>$i['fk_subject_id']));   
				$i['subject_name'] = $subjectname['su_name'];
				return $i;
			});
//print_r($data['tabledata']);exit;
		return view('master.view_codegenerators',['data'=>$data]);	
	}

	public function add_codegenerators(Request $request) // Viewall catalogues.
	{		
		if ($request->input('_token')) {
			$user = Auth::guard('admin')->user();	

		$whereschool = ['sc_delete'=>1,'slug'=>$request->input('fk_school_slug')];
		$data['schooldata'] = School::view_single($whereschool);

		$whereschoolbranch = ['sb_delete'=>1,'slug'=>$request->input('fk_branch_slug')];
		$data['schoolbranchdata'] = Schoolbranch::view_single($whereschoolbranch);

		$whereschoolclass = ['cl_delete'=>1,'cl_id'=>$request->input('fk_class_id')];
		$data['coursedata'] = Classtable::view_single($whereschoolclass);

		$whereschoolsubject = ['su_delete'=>1,'su_id'=>$request->input('fk_subject_slug')];
		$data['subjectdata'] = Subjects::view_single($whereschoolsubject);


		$schoolcode = substr($data['schooldata']['sc_name'],0,3); 
		$schoolbranchcode = $data['schoolbranchdata']['sb_location'] == ''?'NA':substr($data['schoolbranchdata']['sb_location'],0,2);
		$coursecode = substr($data['coursedata']['cl_name'],0,4);
		$subjectcode = substr($data['subjectdata']['su_name'],0,2);
		

		$co_code = $schoolcode.$schoolbranchcode.$coursecode.$subjectcode;

		for ($x = 1; $x <= $request->input('noof_codes'); $x++) {
			$string = bin2hex(openssl_random_pseudo_bytes(3));
			$table = new Codegenerators;
			$table->slug = CommonModel::add_slug('codegenerators',bin2hex(openssl_random_pseudo_bytes(5)));
			$table->fk_school_slug = $request->input('fk_school_slug');
			$table->fk_branch_slug = $request->input('fk_branch_slug');
			$table->fk_course_id = $request->input('fk_class_id');
			$table->fk_subject_id = $request->input('fk_subject_slug');
			$table->co_code = $co_code.$string;
			
			$table->added_by = $user->id;
			$table->save();
		
		}
		
			if ($table->save()) {
				return redirect('view_codegenerators')->with('msg','Added succesfully!');
			}else{
				return redirect('view_codegenerators')->with('errmsg', 'Error!');
			}
		}
		$whereschool = ['sc_delete'=>1];
		$data['schooltable'] = School::view_all($whereschool);
				$whereclass = ['cl_delete'=>1];
		$data['classtable'] = Classtable::view_all($whereclass);
		return view('master.add_codegenerators',['data'=>$data]);	
	}

	public function edit_codegenerators(Request $request) // Viewall catalogues.
	{		
		if ($request->input('_token')) {
			$user = Auth::guard('admin')->user();
			$table = Codegenerators::where('slug',$request->input('slug'))->first();
			$table->co_code = $request->input('un_name');		
				
			$table->save();
			if ($table->save()) {
				return redirect('view_codegenerators')->with('msg','Updated succesfully!');
			}else{
				return redirect('view_codegenerators')->with('errmsg', 'Error!');
			}
		}
		$where = ['co_delete'=>1,'slug'=>$request->input('slug')];
		$data['row'] = Codegenerators::view_single($where);
		
		// print_r($data['row']);exit;
		return view('master.edit_codegenerators',['data'=>$data]);	
	}

public function get_branch_from_school(Request $request) 
	{		
		$where = ['sb_delete'=>1,'sb_status'=>1,'fk_school_slug'=>$request->input('fk_school_slug')];
		
		$data = Schoolbranch::view_all($where);
		return $data;	
  }

		public function get_bookorsubject_from_course(Request $request) 
			{		
				$where = ['scc_delete'=>1,'su_delete'=>1,'fk_class_id'=>$request->input('fk_class_id')];				
				$data = Subjects_class_course::join_courseand_subject($where);
				//print_r($data);exit;
				return $data;	
		}

		public function checkclassname(Request $request) 
			{		
				$where = ['cl_delete'=>1,'type'=>$request->input('type'),'cl_name'=>$request->input('cl_name')];				
				

			if($request->input('cl_id') == 0){
						$data = Classtable::view_all($where);				
			}else{

							$data = Classtable::view_all_not_same_id($where,$request->input('cl_id'));				
			}

			if(count($data) > 0){
					echo 'success';
				}else{
					echo 'error';
				}
				exit;
		}


		
public function forget_passwod(Request $request) // Viewall catalogues.
	{		
          if ($request->input('_token')) {
			
  				$wherecheck = array('email'=>$request->input('email'),'ma_delete'=>1);
			
					
						$user = Users::where($wherecheck)->get();
					
					
					if(count($user) == 0){
						return redirect('forget_passwod')->with('errmsg', "We couldn't find any user registered with that email.");
					}
				//print_r($user);exit;
				$otp = rand(100000,999999);
				$user = Users::where('email',$request->input('email'))->orderby('id','desc')->firstOrFail();
				$user->password_reset_token = $otp;			
				$user->save();
				if ($user->save()) {
				Mail::to($user['email'])->send(new ResendOtp($user));
				return redirect('create_password')->with('msg','Reset Password Otp Send Succesfully!');
			}else{
				return redirect('forget_passwod')->with('errmsg', 'Error!');
			}
				

			  }
		$data = array();
//print_r($data['tabledata']);exit;
		return view('master.forget_passwod',['data'=>$data]);	
	}

			//create_password?password_reset_token=
public function create_password(Request $request) // Viewall catalogues.
	{			


           if ($request->input('_token')) {

					$wherecheck = array('password_reset_token'=>$request->input('password_reset_token'),'ma_delete'=>1);
				$user = Users::view_all($wherecheck);
				if(count($user) == 0){
						return redirect('forget_passwod')->with('errmsg', 'Wrong OTP');
				}
			
					$user = Master_admin::where(array('password_reset_token'=>$request->input('password_reset_token')))->first();		 
					$user->password_reset_token = 0;			
					$user->password = $request->input('password');
					$user->save();
					
					if ($user->save()) {
						return redirect('login?cp=1')->with('msg','Password Updated Succesfully!');
					}else{
						return redirect('login?cp=0')->with('errmsg', 'Error!');
					}
			  }

		$data = array();
		return view('master.create_password',['data'=>$data]);	
	}

public function view_codegenerators_details(Request $request) // Viewall catalogues.
	{		
		
			$where = ['co_delete'=>1,'slug'=>$request->input('slug')];
        $data['tabledata'] = Codegenerators::view_all(array_filter($where));
		
		$data['tabledata']->transform(function($i){                   
            $schooldata = School::view_single(array('slug'=>$i['fk_school_slug']));           
            $i['schooldata'] = $schooldata;
				$branchdata = Schoolbranch::view_single(array('slug'=>$i['fk_branch_slug']));           
            $i['branchdata'] = $branchdata;
				$classcoursedata = Classtable::view_single(array('cl_id'=>$i['fk_course_id']));           
            $i['classcoursedata'] = $classcoursedata;
				$subjectdata = Subjects::view_single(array('su_id'=>$i['fk_subject_id']));           
            $i['subjectdata'] = $subjectdata;
            return $i;
        });
		// print_r($data['tabledata'][0]['subjectdata']['su_name']);exit;
 
		return view('master.view_codegenerators_details',['data'=>$data]);	
	
}



	
	
}
