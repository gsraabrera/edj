<?php

namespace App\Http\Controllers;

use App\Models\PublishedArticle;
use App\Models\PublishedArticleAuthor;

use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Str;
use App\Models\PublishedArticleKeyword;
use DB;

class PublishedArticleController extends Controller
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
                'file'  => 'required|mimes:pdf|max:10000',
                'issue_id'  => 'required',
                'title'  => 'required',
                'abstract'  => 'required',
                'keyword.*' => 'required',
                'authors.*' => 'required',
            ]);
            $publishedArticle = new PublishedArticle;
            $publishedArticle->issue_id = $request->input('issue_id');
            $publishedArticle->title = $request->input('title');
            $publishedArticle->abstract = $request->input('abstract');
            $publishedArticle->slug = Str::slug($request->input('title'), '-');
            if($request->hasFile('file')){
                $file = $request->file('file');
                $fileName = Str::random(40).time() . '.' . $request->file->extension();
                $request->file->move(public_path('published_articles'), $fileName);
                $publishedArticle->file = $fileName;
            }
            $publishedArticle->save();
            if($request->has('keyword')){
                foreach($request->input('keyword') as $key => $value)
                {
                    $keywords_arr[] = array(
                        'published_article_id'=>$publishedArticle->id, 
                        'keyword'=>$request->input('keyword')[$key],
                        'created_at'=> now(),
                        'updated_at'=> now(),   
                    );
                }
            }
            if($request->has('author')){
                foreach($request->input('author') as $key => $value)
                {
                    $authors_arr[] = array(
                        'published_article_id'=>$publishedArticle->id, 
                        'name'=>$request->input('author')[$key],
                        'created_at'=> now(),
                        'updated_at'=> now(),   
                    );
                }
            }
            $publishedArticle->authors()->insert($authors_arr);
            $publishedArticle->keywords()->insert($keywords_arr);
            return back()->with('success','Article updated successfully.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PublishedArticle  $publishedArticle
     * @return \Illuminate\Http\Response
     */
    public function show($issueSlug,$slug)
    {
        $data = PublishedArticle::join('issues','issues.id',"=","published_articles.issue_id")
        ->where("issues.slug","=",$issueSlug)
        ->where("published_articles.id","=",$slug)
        ->first(['published_articles.id','title','abstract','file','issues.slug as issue_slug','published_articles.slug','issue_no','volume','year','cover_image','date_published']);
        // return $data;
        return view('pages.article',compact('data'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PublishedArticle  $publishedArticle
     * @return \Illuminate\Http\Response
     */
    public function edit(PublishedArticle $publishedArticle)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PublishedArticle  $publishedArticle
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PublishedArticle $publishedArticle)
    {
        if(Auth::user()->hasRole(['Managing Editor','Managing Editor'])){
            $request->validate([
                'file'  => 'nullable|mimes:pdf|max:10000',
                'title'  => 'required',
                'abstract'  => 'required',
                'keyword.*' => 'required',
            ]);
            $publishedArticle->title = $request->input('title');
            $publishedArticle->abstract = $request->input('abstract');
            $publishedArticle->slug = Str::slug($request->input('title'), '-');

            if($request->hasFile('file')){
                $file = $request->file('file');
                $pathToFile = public_path()."/published_articles/".$publishedArticle->file;
                if(file_exists($pathToFile))
                $fileName = Str::random(40).time() . '.' . $request->file->extension();
                $request->file->move(public_path('published_articles'), $fileName);
                $publishedArticle->file = $fileName;
            }
            
        

            if($request->has('keyword')){
                foreach($request->input('keyword') as $key => $value)
                {
                        $keywords_arr[] = array(
                            'id'=>$request->input('keyword_id')[$key],
                            'published_article_id'=>$publishedArticle->id, 
                            'keyword'=>$request->input('keyword')[$key],
                            'created_at'=> now(),
                            'updated_at'=> now(),   
                        );

                }
            }
            if($request->has('author')){
                foreach($request->input('author') as $key => $value)
                {
                    $authors_arr[] = array(
                        'id'=>$request->input('author_id')[$key],
                        'published_article_id'=>$publishedArticle->id, 
                        'name'=>$request->input('author')[$key],
                        'created_at'=> now(),
                        'updated_at'=> now(),   
                    );
                }
            }

            $publishedArticle->save();
            PublishedArticleKeyword::where('published_article_id',$publishedArticle->id)->whereNotIn('id', $request->input('keyword_id'))->delete();
            $publishedArticle->keywords()->upsert($keywords_arr, ['id'], ['keyword']);

            PublishedArticleAuthor::where('published_article_id',$publishedArticle->id)->whereNotIn('id', $request->input('author_id'))->delete();
            $publishedArticle->authors()->upsert($authors_arr, ['id'], ['name']);
            return back()->with('success','Article updated successfully.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PublishedArticle  $publishedArticle
     * @return \Illuminate\Http\Response
     */
    public function destroy(PublishedArticle $publishedArticle)
    {
        if(Auth::user()->hasRole(['Managing Editor','Managing Editor'])){
            
            $pathToFile = public_path()."/published_articles/".$publishedArticle->file;
            if(file_exists($pathToFile))
            unlink($pathToFile);
            $publishedArticle->delete();
            
            return back()
            ->with('success','Issue deleted successfully.');
        }else{
            return  redirect('/home');
        }
    }
}
