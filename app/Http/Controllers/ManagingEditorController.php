<?php

namespace App\Http\Controllers;
use App\Models\Article;
use App\Models\Action;
use App\Models\ArticleKeyword;
use App\Models\Reviewer;
use App\Models\Author;
use App\Models\User;
use App\Models\ReviewerRecommendation;
use Illuminate\Http\Request;
use App\Services\TemplateService;
use Mail;
use Auth;
use Illuminate\Support\Str;
use Illuminate\Support\HtmlString;
use DB;
use PDF;

class ManagingEditorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $user = Auth::user();
        // $user->assignRole('Managing Editor');
        if(Auth::user()->hasRole('Managing Editor')){
            $data = Article::paginate(10);
            return view('me.articles',compact('data'));
        }else{
            return  redirect('/home');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, TemplateService $templateService)
    {
        if(Auth::user()->hasRole('Managing Editor')){
            $data = Article::with('keywords')
            ->with('authors')
            ->with('reviewers')
            ->with(array('subject_matter_editor_recommendations' => function($query) {
                $query->orderBy('created_at','DESC');
                $query->first();
            }))
            ->with(array('editor_in_chief_decisions' => function($query) {
                $query->orderBy('created_at','DESC');
                $query->first();
            }))
            ->with(array('reviewers.reviewer_recommendations' => function($query) {
                $query->orderBy('created_at','DESC');
                $query->first();
            }))
            ->find($id);

            if($data){
                if(!$data->editor_in_chief_decisions->isEmpty() && $data->editor_in_chief_decisions[0]->decision === "Rejected"){
                    $template = $templateService->articleRejected($data);
                }else if(!$data->editor_in_chief_decisions->isEmpty() && $data->editor_in_chief_decisions[0]->decision === "Accepted"){
                    $template = $templateService->articleAccepted($data);
                }else if(!$data->editor_in_chief_decisions->isEmpty() && $data->editor_in_chief_decisions[0]->decision === "Accepted with revision"){
                    $template = $templateService->withRevision($data);
                }else{
                    $template = "";
                }
                return view('me.article',compact(['data','template']));
            }else{
                return abort(404, 'Page not found'); 
            }
        }else{
            return abort(401, 'Page not found');
        }

    
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateFile(Request $request)
    {
        
        if(Auth::user()->hasRole('Managing Editor')){
            $request->validate([
                'file'  => 'required|mimes:doc,docx',
                'id'  => 'required',
            ]);
            $article = Article::find($request->input('id'));
            // $article->update($request->all());
            $article->status = 'Under Review';
            if($request->hasFile('file')){
                $file = $request->file('file');
                $fileName = Str::random(40).time() . '.' . $request->file->extension();
                $request->file->move(public_path('articles'), $fileName);
                $article->file = $fileName;
            }
            $article->save();
            $action = new Action;
            $action->article_id = $article->id;
            $action->file = $article->file;
            $action->action_type_id = 2;
            $action->action_by = Auth::user()->id;
            $action->save();

            return redirect()->route('me.article', ['id' => $article->id])
            ->with('success','Article updated successfully.');
        }else{
            return  redirect('/home');
        }
    }

            /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showCoverPDF($id,$type, Request $request)
    {
        if(Auth::user()->hasRole('Managing Editor')){
            $data = Article::find($id);
            if($type=='cover_letter'){
                $pathToFile = public_path()."/cover_letters/".$data->cover_letter;
            }
            else if($type=='article'){
                $pathToFile = public_path()."/articles/".$data->file;
            }
            else if($type=='signed_author_agreement'){
                $pathToFile = public_path()."/signed_author_agreement_forms/".$data->signed_author_agreement;
            }else if($type=='markup_document'){
                $data = ReviewerRecommendation::find($request->input('id'));
                $pathToFile = public_path()."/markup_document/".$data->markup_document;
            }else{
                return abort(404, 'Page not found');
            }
            
            // return $data->signed_author_agreement;
            if (file_exists($pathToFile)) {
                return response()->file($pathToFile);
            } else {
                return abort(404, 'Page not found');
            }  
        }else{
            return abort(401, 'Page not found');
        }
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function newReviewer(Request $request)
    {
  
        if(Auth::user()->hasRole('Managing Editor')){
            $request->validate([
                'article_id' => 'required|exists:articles,id',
                'first_name' => 'required',
                'last_name' => 'required',
                'email' => 'required',
                'mobile_no'    => 'required',
                'office_contact_no' => 'required'
            ]);

            $user = User::whereEmail($request->input('email'))->first();
            if(!$user){
                $user = new User;
                $user->title = $request->input('title');
                $user->name = $request->input('first_name');
                $user->first_name = $request->input('first_name');
                $user->middle_name = $request->input('middle_name');
                $user->last_name = $request->input('last_name');
                $user->current_job_title = $request->input('current_job_title');
                $user->department_research_unit = $request->input('department_research_unit');
                $user->email = $request->input('email');
                $user->institution = $request->input('institution');
                $user->password = Str::random(10);
                $user->mobile_no = $request->input('mobile_no');
                $user->contact_no = $request->input('office_contact_no');
                $user->save();

            }
            $user->assignRole('Reviewer');
            $article = Article::find($request->input('article_id'));

            $reviewer = new Reviewer;
            $reviewer->user_id = $user->id;
            $reviewer->email = $request->input('email');
            $reviewer->article_id = $request->input('article_id');
            $reviewer->title = $request->input('title');
            $reviewer->first_name = $request->input('first_name');
            $reviewer->middle_name = $request->input('middle_name');
            $reviewer->last_name = $request->input('last_name');
            $reviewer->institution = $request->input('institution');
            $reviewer->mobile_no = $request->input('mobile_no');
            $reviewer->file = $article->file;
            $reviewer->office_contact_no = $request->input('office_contact_no');
            $reviewer->ref =  Str::random(20).time();
            $reviewer->temp_pass =  Str::random(10).time();
            
            $reviewer->status = "-";
            $reviewer->save();
            $reviewer->ref =  Str::random(20).time().$reviewer->id;
            $reviewer->save();
            
            return redirect()->route('me.article', ['id' => $request->input('article_id')])
            ->with('success','Reviewer added successfully.');
        }else{
            return  redirect('/home');
        }
    }


    public function sendInvitation(Request $request) {
      
        $reviewer = Reviewer::join('articles','articles.id','=','reviewers.article_id')
                ->where("reviewers.id",$request->input('id'))
                ->first([
                            'articles.title',
                            'articles.abstract',
                            'articles.ref_no',
                            'reviewers.title as reviewer_title', 
                            'first_name',
                            'middle_name',
                            'last_name',
                            'reviewers.email',
                            'reviewers.ref',
                            'reviewers.status',
                            'articles.id'
                        ]);


        $details = [
 
            'body' => "Manuscript Ref. No.:  E&D-J-".date("y")."-".sprintf("%02d", $reviewer->ref_no)." <br/>
            Title: ".$reviewer->title."<br />
            E&D Journal <br /><br />
            
            Dear ".$reviewer->first_name." ".$reviewer->last_name.",<br />
            
            The above referenced paper has been submitted to Ecosystems and Development Journal for consideration. Considering your expertise, we would appreciate your technical review of this paper. We have included the abstract below to provide you with the manuscript overview.<br /><br />
            
            Should you accept this invitation, may we request that your comments be submitted in 21 days. In case you are unable to review the paper at this time, kindly suggest alternate reviewers.<br /><br />
            
            If you are willing to review this manuscript, please click on the link below:<br />
            ".url('')."/reviewer/accept/".$reviewer->ref."<br /><br />
            
            If you are unable to review, please click on the link below. We would appreciate receiving suggestions for alternative reviewers:<br />
            ".url('')."/reviewer/decline/".$reviewer->ref."<br /><br />
            
            Alternatively, you may register your response by accessing the E&D Journal as a REVIEWER using the login credentials below:<br /><br />
            
            Your username is: ".$reviewer->email."<br /><br />
            
            If you do not know your confidential password, you may reset it by clicking this link: ".url('')."/reviewer/".$reviewer->ref."<br />.<br />
            
            Click [Reviewer Login]<br />
            This takes you to the Reviewer Main Menu.<br /><br />
            
            Click ".url('')."/reviewer/decline/".$reviewer->ref."<br /><br />
            
            Click either <a href='".url('')."/reviewer/accept/".$reviewer->ref."'> Accept</a>  or <a href='".url('')."/reviewer/decline/".$reviewer->ref."'>Decline</a><br />
            
            I look forward to hearing from you soonest.<br /><br />
            
            Yours sincerely,<br /><br />
            
            Managing Editor/ Editor-in-Chief<br />
            Ecosystems and Development Journal<br />
            "
        ];
        
    
    
        try{
            $mail_status = Mail::send('email.template', ['details'=>$details], function ($m) use ($reviewer) {
                $m->from('raabrera@up.edu.ph', 'Ecosystems and Development Journal');
                $m->replyTo('raabrera@up.edu.ph', $name = null);
                $m->to($reviewer->email, $reviewer->first_name)->subject('Reviewer Invitation');
                $m->attachData($this->abstractToPDF($reviewer), "Abstract.pdf");
            });
  
            $reviewer_update = Reviewer::where("reviewers.id",$request->input('id'))
            ->first();
            $reviewer_update->status = "Invitation Sent";
            $reviewer_update->save();
            return redirect()->route('me.article', ['id' => $reviewer->id])
            ->with('success','An invitation has been successfully sent to '.$reviewer->email);
    
        }
        catch(\Exception $e){
            return redirect()->route('me.article', ['id' => $reviewer->id])->withErrors(['Invalid e-mail']);
        }
    }

    public function forwardSME(Request $request) {
        if(Auth::user()->hasRole('Managing Editor')){
            $request->validate([
                'id' => 'required|exists:articles,id',
                'temp_user_owner' => 'required|exists:users,id',
            ]);
            $article = Article::find($request->input('id'));
            $article->temp_user_owner = $request->input('temp_user_owner');
            $article->temp_role_owner = 7;
            $article->save();

            $action = new Action;
            $action->article_id = $article->id;
            $action->file = $article->file;
            $action->action_type_id = 4;
            $action->to_user = $request->input('temp_user_owner');
            $action->action_by = Auth::user()->id;
            $action->save();
            return redirect()->route('me.article', ['id' => $request->input('id')])
            ->with('success','Successfully forwarded to SME.');
        }else{
            return  redirect('/home');
        }
    }

    public function forwardEIC(Request $request) {
        if(Auth::user()->hasRole('Managing Editor')){
            $request->validate([
                'id' => 'required|exists:articles,id',
            ]);
            $article = Article::find($request->input('id'));
            $article->temp_role_owner = 6;
            $article->save();

            $action = new Action;
            $action->article_id = $article->id;
            $action->file = $article->file;
            $action->action_type_id = 5;
            $action->to_user = $request->input('temp_user_owner');
            $action->action_by = Auth::user()->id;
            $action->save();
            return redirect()->route('me.article', ['id' => $request->input('id')])
            ->with('success','Successfully forwarded to EIC.');
        }else{
            return  redirect('/home');
        }
    }

    public function notify(Request $request) {
        if(Auth::user()->hasRole('Managing Editor')){
            // return $request->all();
            $request->validate([
                'id' => 'required|exists:articles,id',
                'body' => 'required',
            ]);

            $details = ['body' => $request->input('body')];
            $author = Author::author()
            ->leftJoin('articles','articles.id','authors.article_id')
            ->where('article_id',$request->input('id'))
            ->first();
            try{
                $mail_status = Mail::send('email.template', ['details'=>$details], function ($m) use ($author,$request) {
                    $m->from('raabrera@up.edu.ph', 'Ecosystems and Development Journal');
                    $m->replyTo('raabrera@up.edu.ph', $name = null);
                    $m->to($author->email, $author->first_name)->subject($request->input('subject'));
                });

                return redirect()->route('me.article', ['id' => $request->input('id')])
                ->with('success','Notification Sent.'.$author->email);
        
            }
            catch(\Exception $e){
                return $e;
                return redirect()->route('me.article', ['id' => $request->input('id')])->withErrors(['Invalid e-mail']);
            }
        }else{
            return  redirect('/home');
        }
    }
    

    public function abstractToPDF($data) {
        if(Auth::user()->hasRole('Managing Editor')){
            $pdf = PDF::loadHTML("<strong>Title: $data->title</strong><br/><br/><strong>Abstract:</strong><br/>$data->abstract");
            return $pdf->stream();
        }else{
            return  redirect('/home');
        }
    }


}
