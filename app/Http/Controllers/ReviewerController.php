<?php

namespace App\Http\Controllers;

use App\Models\Reviewer;
use App\Models\Article;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\ReviewerRecommendation;
use Mail;
use Auth;
use Illuminate\Support\Str;
use Illuminate\Support\HtmlString;
use DB;



class ReviewerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->hasRole('Reviewer')){
            $data = Reviewer::join('articles','articles.id','=','reviewers.article_id')
                    ->where('reviewers.email',Auth::user()->email)
                    ->where('reviewers.status','!=','-')
                    ->select('articles.id','articles.title','articles.abstract','reviewers.id as reviewer_id','reviewers.updated_at','reviewers.status')
                    ->paginate(10);
            return view('reviewer.articles',compact('data'));
        }else{
            return  redirect('/home');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id,$reviewer_id)
    {
        if(Auth::user()->hasRole('Reviewer')){
            
            $data = Article::leftJoin('reviewers', function ($leftJoin) {
                $leftJoin->on('reviewers.article_id', '=', 'articles.id');
            })
            ->where('reviewers.id',$reviewer_id)
            ->where('articles.id',$id)
            ->with('keywords')
            ->select(['articles.id','reviewers.id as reviewer_id','articles.title','abstract','reviewers.status','reviewers.file','reviewers.ref'])
            ->first();
            if($data){
                return view('reviewer.article',compact('data'));
            }else{
                return abort(404, 'Page not found');
            }
            
        }else{
            return abort(401, 'Page not found');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function decline($id)
    {

        if(Auth::user()->hasRole('Reviewer')){
            $reviewer = Reviewer::where("ref",$id)->first();
            if($reviewer && $reviewer->status==="Invitation Sent"){
                $reviewer->status = "Rejected";
                $reviewer->save();
                $reviewer_info = Reviewer::join('articles','articles.id','=','reviewers.article_id')
                ->where("ref",$id)
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
                    'body' => "Manuscript Ref. No.:  E&D-J-".date("y")."-".sprintf("%02d", $reviewer_info->ref_no)." <br/>
                    Title: ".$reviewer_info->title."<br />
                    E&D Journal <br /><br />
                    This is an automated reminder.<br /> <br />
                    
                    Dear ".$reviewer_info->reviewer_title." ".$reviewer_info->first_name." ".$reviewer_info->last_name.",<br /><br />
                    
                    Thank you for your response and we understand that you are not able to reply as a reviewer at this time. We look forward to engaging you as reviewer of E&D Journal articles in the future.
                    <br /><br />
                    
                    Yours sincerely,<br /><br />
                    
                    Managing Editor/ Editor-in-Chief<br />
                    Ecosystems and Development Journal<br />
                    "
                ];
                try{
    
                    Mail::send('email.template', ['details'=>$details], function ($m) use ($reviewer) {
                        $m->from('raabrera@up.edu.ph', 'Ecosystems and Development Journal');
                        $m->replyTo('raabrera@up.edu.ph', $name = null);
                        $m->to($reviewer->email, $reviewer->first_name)->subject('Reviewer Invitation');
                    });
                    return redirect()->route('reviewer.article', ['id' => $reviewer->article_id,'id' => $reviewer->id])
                    ->with('success','Status has been updated.'.$reviewer->email);
            
                }
                catch(\Exception $e){
                    return redirect()->route('me.article', ['id' => $reviewer->id])->withErrors(['Invalid e-mail']);
                }
            }else{
                return abort(404, 'Page not found');
            }
            
            // return redirect()->route('reviewer.article', ['id' => $reviewer->article_id])
            // ->with('success','Succesfully Updated');
        }else{
            return abort(401, 'Page not found');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function accept($id)
    {
        
        if(Auth::user()->hasRole('Reviewer')){
            $reviewer = Reviewer::where("ref",$id)->first();

            if($reviewer && $reviewer->status==="Invitation Sent"){
                $reviewer->status = "Accepted";
                $reviewer->save();
                return redirect()->route('reviewer.article', ['id' => $reviewer->article_id,'reviewer_id' => $reviewer->id])
                ->with('success','Status has been updated');
            }else{
                return abort(404, 'Page not found');
            }

        }else{
            return abort(401, 'Page not found');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function review($id,Request $request)
    {

        if(Auth::user()->hasRole('Reviewer')){
            $request->validate([
                'article_id' => 'required|exists:articles,id',
                'recommendation_type' => 'required',
                'recommendation' => 'required',
            ]);
            $reviewer = Reviewer::where('id',$id)->first();
            if($reviewer && ($reviewer->status==="Accepted" || $reviewer->status==="Re-Submitted")){


                $ReviewerRecommendation = new ReviewerRecommendation;
                $ReviewerRecommendation->reviewer_id = $reviewer->id;
                $ReviewerRecommendation->recommendation_type = $request->input('recommendation_type');
                $ReviewerRecommendation->q1 = $request->input('q1');
                $ReviewerRecommendation->q2 = $request->input('q2');
                $ReviewerRecommendation->q3 = $request->input('q3');
                $ReviewerRecommendation->q4 = $request->input('q4');
                $ReviewerRecommendation->q5 = $request->input('q5');
                $ReviewerRecommendation->q6 = $request->input('q6');
                $ReviewerRecommendation->q7 = $request->input('q7');
                $ReviewerRecommendation->q8 = $request->input('q8');
                $ReviewerRecommendation->q9 = $request->input('q9');
                $ReviewerRecommendation->q10 = $request->input('q10');
                $ReviewerRecommendation->q11 = $request->input('q11');
                $ReviewerRecommendation->q12 = $request->input('q12');
                if($request->input('recommendation') === 'Paper as presently written maybe accepted for publication after complying with the required revisions.'){
                    $ReviewerRecommendation->recommendation = $request->input('recommendation')." ".$request->input('recommendation1');
                }else{
                    $ReviewerRecommendation->recommendation = $request->input('recommendation');
                }
                
                if($request->hasFile('markup_document')){
                    $markup_document = $request->file('markup_document');
                    $fileName = Str::random(40).time() . '.' . $request->markup_document->extension();
                    $request->markup_document->move(public_path('markup_document'), $fileName);
                    $ReviewerRecommendation->markup_document = $fileName;
                }
                if($request->hasFile('recommendation_file')){
                    $markup_document = $request->file('recommendation_file');
                    $fileName = Str::random(40).time() . '.' . $request->recommendation_file->extension();
                    $request->recommendation_file->move(public_path('recommendation_file'), $fileName);
                    $ReviewerRecommendation->recommendation_file = $fileName;
                }
                $ReviewerRecommendation->reviewed_file = $reviewer->file;
                $ReviewerRecommendation->save();
                $reviewer->status = "Review Submitted";
                $reviewer->save();
                return redirect()->route('reviewer.article', ['id' => $reviewer->article_id,'reviewer_id' => $reviewer->id])
                ->with('success','Status has been updated');
            }else{
                return abort(404, 'Page not found');
            }

        }else{
            return abort(401, 'Page not found');
        }
    }

                /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showCoverPDF($id,$type)
    {
        if(Auth::user()->hasRole('Reviewer')){
            $data = Reviewer::find($id);
            if($data->file){
                if($type=='article'){
                    $pathToFile = public_path()."/articles/".$data->file;
                }else{
                    return abort(404, 'Page not found');
                }
            }else{
                return redirect()->route('reviewer.article', ['id' => $data->article_id])->withErrors(['File cannot be found.']);;
            }

            // if($type=='cover_letter'){
            //     $pathToFile = public_path()."/cover_letters/".$data->cover_letter;
            // }
            // else if($type=='article'){
            //     $pathToFile = public_path()."/articles/".$data->file;
            // }
            // else if($type=='signed_author_agreement'){
            //     $pathToFile = public_path()."/signed_author_agreement_forms/".$data->signed_author_agreement;
            // }else{
            //     return abort(404, 'Page not found');
            // }
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
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Reviewer  $reviewer
     * @return \Illuminate\Http\Response
     */
    public function edit(Reviewer $reviewer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Reviewer  $reviewer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Reviewer $reviewer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Reviewer  $reviewer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reviewer $reviewer)
    {
        //
    }
}
