<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Article;
use App\Models\Action;
use App\Models\SubjectMatterEditorRecommendation;
use App\Models\EditorInChiefDecision;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Str;
use Illuminate\Support\HtmlString;
use DB;

class EditorInChiefController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->hasRole('Editor-in-Chief')){
            $data = Article::paginate(10);
            return view('eic.articles',compact('data'));
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
        if(Auth::user()->hasRole('Editor-in-Chief')){
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
            if($data)
            return view('eic.article',compact('data'));
            else
            return abort(404);
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
    public function showCoverPDF($id,$type, Request $request)
    {
        if(Auth::user()->hasRole('Editor-in-Chief')){
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
    public function decision(Request $request)
    {
        if(Auth::user()->hasRole('Subject Matter Editor')){
            $article = Article::find($request->input('id'));
            $EICecision = new EditorInChiefDecision;
            $EICecision->article_id = $request->input('id');
            $EICecision->decision = $request->input('decision');
            $EICecision->comment = $request->input('comment');
            $EICecision->reviewed_file = $article->file;
            $EICecision->save();
            return redirect()->route('eic.article', ['id' => $request->input('id')])
            ->with('success','Article updated Sucessfully.');
        }else{
            return abort(401, 'Page not found');
        }
    }
}
