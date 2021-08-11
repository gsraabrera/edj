<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Article;
use App\Models\Action;
use App\Models\SubjectMatterEditorRecommendation;

use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Str;
use Illuminate\Support\HtmlString;
use DB;



class SubjectMatterEditorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->hasRole('Subject Matter Editor')){
            $data = Article::where('temp_user_owner',Auth::user()->id)->paginate(10);
            return view('sme.articles',compact('data'));
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
    public function show($id)
    {
        if(Auth::user()->hasRole('Subject Matter Editor')){
            
            $data = Article::with('keywords')
            ->with('authors')
            ->with('reviewers')
            ->with(array('reviewers.reviewer_recommendations' => function($query) {
                $query->orderBy('created_at','DESC');
                $query->first();
            }))
            ->with(array('subject_matter_editor_recommendations' => function($query) {
                $query->orderBy('created_at','DESC');
                $query->first();
            }))
            ->with(array('editor_in_chief_decisions' => function($query) {
                $query->orderBy('created_at','DESC');
                $query->first();
            }))
            ->where('temp_user_owner',Auth::user()->id)
            ->find($id);
            if($data)
            return view('sme.article',compact('data'));
            else
            return abort(404);
        }else{
            return abort(401, 'Page not found');
        }
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function SMEs()
    {
        if(Auth::user()->hasRole('Subject Matter Editor')){
            $data = User::whereHas("roles", function($q){ $q->where("name", "Subject Matter Editor"); })->get();
            return $data;
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

            return redirect()->route('sme.article', ['id' => $article->id])
            ->with('success','Article updated successfully.');
        }else{
            return  redirect('/home');
        }
    }

    public function forwardEIC(Request $request) {
        if(Auth::user()->hasRole('Subject Matter Editor')){
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
            return redirect()->route('sme.article', ['id' => $request->input('id')])
            ->with('success','Successfully forwarded to EIC.');
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
        if(Auth::user()->hasRole('Subject Matter Editor')){
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function recommend(Request $request)
    {
        if(Auth::user()->hasRole('Subject Matter Editor')){
            $article = Article::find($request->input('id'));
            $SMRecommendation = new SubjectMatterEditorRecommendation;
            $SMRecommendation->article_id = $request->input('id');
            $SMRecommendation->user_id = Auth::user()->id;
            $SMRecommendation->recommendation = $request->input('recommendation');
            $SMRecommendation->comment = $request->input('comment');
            $SMRecommendation->reviewed_file = $article->file;
            $SMRecommendation->save();
            return redirect()->route('sme.article', ['id' => $request->input('id')])
            ->with('success','Recommended Sucessfully.');
        }else{
            return abort(401, 'Page not found');
        }
    }

    public function forwardME(Request $request) {
        if(Auth::user()->hasRole('Subject Matter Editor')){
            $request->validate([
                'id' => 'required|exists:articles,id',
            ]);
            $article = Article::find($request->input('id'));
            $article->temp_role_owner = 3;
            $article->save();

            $action = new Action;
            $action->article_id = $article->id;
            $action->file = $article->file;
            $action->action_type_id = 6;
            $action->to_user = $request->input('temp_user_owner');
            $action->action_by = Auth::user()->id;
            $action->save();
            return redirect()->route('sme.article', ['id' => $request->input('id')])
            ->with('success','Successfully forwarded to Managing Editor.');
        }else{
            return  redirect('/home');
        }
    }
}
