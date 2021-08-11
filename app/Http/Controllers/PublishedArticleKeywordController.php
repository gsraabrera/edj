<?php

namespace App\Http\Controllers;

use App\Models\PublishedArticleKeyword;
use Illuminate\Http\Request;
use Auth;

class PublishedArticleKeywordController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        if(Auth::user()->hasRole(['Managing Editor','Managing Editor'])){
            $request->validate([
                'published_article_id'  => 'required',
                'keyword.*' => 'required',
            ]);
            $publishedArticleKeyword = new PublishedArticleKeyword;
            if($request->has('keyword')){
                foreach($request->input('keyword') as $key => $value)
                {
                    $keywords_arr[] = array(
                                    'published_article_id'=>$article->id, 
                                    'keyword'=>$request->input('keyword')[$key],
                                    'created_at'=> now(),
                                    'updated_at'=> now(),   
                    );
                }
            }
            $publishedArticleKeyword->insert($keywords_arr);
            return back()->with('success','Article Added successfully.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PublishedArticleKeyword  $publishedArticleKeyword
     * @return \Illuminate\Http\Response
     */
    public function show(PublishedArticleKeyword $publishedArticleKeyword)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PublishedArticleKeyword  $publishedArticleKeyword
     * @return \Illuminate\Http\Response
     */
    public function edit(PublishedArticleKeyword $publishedArticleKeyword)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PublishedArticleKeyword  $publishedArticleKeyword
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PublishedArticleKeyword $publishedArticleKeyword)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PublishedArticleKeyword  $publishedArticleKeyword
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        if(Auth::user()->hasRole(['Managing Editor','Managing Editor'])){
            $request->validate([
                'id.*'  => 'required',
            ]);
            $publishedArticleKeyword = new PublishedArticleKeyword;
            if($request->has('keyword')){
                foreach($request->input('keyword') as $key => $value)
                {
                    $keywords_arr[] = array(
                                    'id'=>$article->id, 
                    );
                }
            }
            PublishedArticleKeyword::destroy($keywords_arr);
            return back()->with('success','Article Added successfully.');
        }
    }
}
