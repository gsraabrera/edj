<?php

namespace App\Http\Controllers;

use App\Models\Issue;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Str;

class IssueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->hasRole(['Managing Editor','Managing Editor'])){
            $data = Issue::paginate(10);
            return view('issue.index',compact('data'));
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
                'issue_no'=> 'required',
                'year'  => 'required',
                'date_published' => 'required',
                'cover_image'  => 'required|mimes:jpg,png,jpeg,gif,sv|required|max:10000',

            ]);
            $issue = new Issue;
            $issue->issue_no = $request->input('issue_no');
            $issue->volume = $request->input('volume');
            $issue->year = $request->input('year');
            $issue->date_published = $request->input('date_published');
            $issue->slug = $request->input('volume')."-".$request->input('issue_no')."-".$request->input('year');
            if($request->hasFile('cover_image')){
                // $file = $request->file('cover_image');
                $fileName = Str::random(40).time() . '.' . $request->cover_image->extension();
                $request->cover_image->move(public_path('cover_image'), $fileName);
                $issue->cover_image = $fileName;
            }
            $issue->save();

            return redirect()->route('issue.all')
            ->with('success','Issue added successfully.');
        }else{
            return  redirect('/home');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Issue  $issue
     * @return \Illuminate\Http\Response
     */
    public function show(Issue $issue)
    {
        if(Auth::user()->hasRole(['Managing Editor','Managing Editor'])){
            $data = $issue->load('articles')->load('articles.authors')->load('articles.keywords');
            return view('issue.issue',compact('data'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Issue  $issue
     * @return \Illuminate\Http\Response
     */
    public function edit(Issue $issue)
    {
    
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Issue  $issue
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Issue $issue)
    {
        if(Auth::user()->hasRole(['Managing Editor','Managing Editor'])){
            $request->validate([
                'id'=> 'required',
                'issue_no'=> 'required',
                'year'  => 'required',
                'date_published' => 'required',
                'cover_image'  => 'mimes:jpg,png,jpeg,gif,sv|max:10000|nullable',

            ]);
            $issue = Issue::find($request->input('id'));
            $issue->issue_no = $request->input('issue_no');
            $issue->volume = $request->input('volume');
            $issue->year = $request->input('year');
            $issue->date_published = $request->input('date_published');
            
            $issue->slug = $request->input('volume')."-".$request->input('issue_no')."-".$request->input('year');
            if($request->hasFile('cover_image')){

                // delete the current file
                $pathToFile = public_path()."/cover_image/".$issue->cover_image;
                if(file_exists($pathToFile))
                unlink($pathToFile);
                $fileName = Str::random(40).time() . '.' . $request->cover_image->extension();
                $request->cover_image->move(public_path('cover_image'), $fileName);
                $issue->cover_image = $fileName;
            }
            $issue->save();

            return redirect()->route('issue.all')
            ->with('success','Issue updated successfully.');
        }else{
            return  redirect('/home');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Issue  $issue
     * @return \Illuminate\Http\Response
     */
    public function destroy(Issue $issue)
    {
        
        if(Auth::user()->hasRole(['Managing Editor','Managing Editor'])){
            // $request->validate([
            //     'id'=> 'required',
            // ]);


            // delete the current file
            
            $pathToFile = public_path()."/cover_image/".$issue->cover_image;
            if(file_exists($pathToFile))
            unlink($pathToFile);
            // return $issue;
            // $issue = Issue::find($id);
            $issue->delete();
            
            return redirect()->route('issue.all')
            ->with('success','Issue deleted successfully.');
        }else{
            return  redirect('/home');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Issue  $issue
     * @return \Illuminate\Http\Response
     */
    public function archive($year)
    {
        $data =  Issue::where('year',$year)->get();
        return view('pages.archive',compact('data'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Issue  $issue
     * @return \Illuminate\Http\Response
     */
    public function issue($slug)
    {
        $data =  Issue::where('slug',$slug)
        ->with('articles')
        ->first();
        return view('pages.issue',compact('data'));
    }

}
