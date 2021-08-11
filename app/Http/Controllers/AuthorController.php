<?php

namespace App\Http\Controllers;
use App\Models\Article;
use App\Models\ArticleKeyword;
use App\Models\Action;
use Illuminate\Http\Request;
use App\Services\NotifyService;
use Auth;
use Illuminate\Support\Str;
use DB;

class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->hasRole('Author')){
            $data = Article::join('authors', function ($leftJoin) {
                $leftJoin->on('authors.article_id', '=', 'articles.id');
                $leftJoin->on('authors.email', '=', DB::raw("'".Auth::user()->email."'"));
                $leftJoin->on('authors.type', '=', DB::raw("'Author'"));
            })
            ->select('articles.id','articles.title','articles.abstract','articles.created_at',)
            ->paginate(10);
            return view('author.mysubmissions',compact('data'));
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
        if(Auth::user()->hasRole('Author')){
            $data = Article::paginate(5);
            return view('author.submit',compact('data'));
        }else{
            return  redirect('/home');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function submit()
    {
        if(Auth::user()->hasRole('Author')){
            $data = Article::paginate(5);
            return view('author.submit',compact('data'));
        }else{
            return  redirect('/home');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, NotifyService $notifyService)
    {

        
        if(Auth::user()->hasRole('Author')){
            $request->validate([
                'title' => 'required',
                'abstract' => 'required',
                'signed_author_agreement'  => 'required|mimetypes:application/pdf',
                'file'  => 'required|mimes:doc,docx',
                'cover_letter' => 'required|mimetypes:application/pdf',
                'first_name.*' => 'required',
                'last_name.*' => 'required',
                'email.*' => 'required',
                'keyword.*' => 'required',
                'type.*'    => 'required'
            ]);
            
            $latest_article = Article::whereYear('created_at', '2021')->orderBy('created_at','DESC')->first();
            if(!$latest_article)
            $ref_no = 1;
            else
            $ref_no = $latest_article->ref_no+1;
            $manuscript_reference_no = "E&D-J-".date("y")."-".sprintf("%02d", $ref_no);
            
            $article = new Article;
            if($request->hasFile('signed_author_agreement')){
                $signed_author_agreement = $request->file('signed_author_agreement');
                $fileName = Str::random(40).time() . '.' . $request->signed_author_agreement->extension();
                $request->signed_author_agreement->move(public_path('signed_author_agreement_forms'), $fileName);
                $article->signed_author_agreement = $fileName;
            }
            $article->status = 'Submitted';
            if($request->hasFile('file')){
                $file = $request->file('file');
                $fileName = Str::random(40).time() . '.' . $request->file->extension();
                $request->file->move(public_path('articles'), $fileName);
                $article->file = $fileName;
            }
            if($request->hasFile('cover_letter')){
                $cover_letter = $request->file('cover_letter');
                $fileName = Str::random(40).time() . '.' . $request->cover_letter->extension();
                $request->cover_letter->move(public_path('cover_letters'), $fileName);
                $article->cover_letter = $fileName;
            }
            $article->title = $request->input('title');
            $article->abstract = $request->input('abstract');
            $article->temp_role_owner = 3;
            $article->manuscript_reference_no = $manuscript_reference_no;
            $article->ref_no = $ref_no;
            
            $article->save();
            $keywords_arr = array();
            $author_arr = array();
            if($request->has('keyword')){
                foreach($request->input('keyword') as $key => $value)
                {
                    $keywords_arr[] = array(
                                    'article_id'=>$article->id, 
                                    'keyword'=>$request->input('keyword')[$key],
                                    'created_at'=> now(),
                                    'updated_at'=> now(),   
                    );
                }
            }

            foreach($request->input('first_name') as $key => $value)
            {
                $author_arr[] = array(
                                'article_id'    =>  $article->id, 
                                'first_name'    =>  $request->input('first_name')[$key],
                                'middle_name'     =>  $request->input('middle_name')[$key],
                                'last_name'     =>  $request->input('last_name')[$key],
                                'email'         =>  $request->input('email')[$key],
                                'type'         =>  $request->input('type')[$key],
                                'corresponding_author' => 1,
                                'created_at'    =>  now(),
                                'updated_at'    =>  now(),   
                );
                if($request->input('type')[$key]=='Author')
                $author_email = $request->input('email')[$key];
            }
            $keywords = $article->keywords()->insert($keywords_arr);
            $authors = $article->authors()->insert($author_arr);

            $action = new Action;
            $action->article_id = $article->id;
            $action->file = $article->file;
            $action->action_type_id = 1;
            $action->action_by = Auth::user()->id;
            $action->save();

            //new object for email
            $data = (object) [
                'name' => $request->input('first_name')[$key]." ".$request->input('middle_name')[$key]." ".$request->input('last_name')[$key],
                'title' => $request->input('title'),
                'email' => $author_email,
                'manuscript_reference_no' => $manuscript_reference_no,
                'subject'   => "Submission Receipt Manuscript Ref No.:".$manuscript_reference_no,
            ];
            $notifyService->articleSubmissionNotification($data);

            return redirect()->route('my-submissions')
            ->with('success','Article submitted successfully.');
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
        if(Auth::user()->hasRole('Author')){
            $data = Article::with('keywords')
                    ->with('authors')
                    ->find($id);
            if($data){
                return view('author.article',compact('data'));
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
        if(Auth::user()->hasRole('Author')){
            $data = Article::leftJoin('actions','articles.id','=','actions.article_id')
            ->where('articles.id',"=",$id)
            ->whereRaw('(action_type_id=1 OR action_type_id=3)')
            ->orderBy('actions.created_at', 'desc')
            ->first(['signed_author_agreement','cover_letter','actions.file']);
            if($type=='cover_letter'){
                $pathToFile = public_path()."/cover_letters/".$data->cover_letter;
            }
            else if($type=='article'){
                $pathToFile = public_path()."/articles/".$data->file;
            }
            else if($type=='signed_author_agreement'){
                $pathToFile = public_path()."/signed_author_agreement_forms/".$data->signed_author_agreement;
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
