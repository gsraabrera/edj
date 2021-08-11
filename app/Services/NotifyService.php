<?php 

namespace App\Services;
use App\Services\TemplateService;
use Mail;

class NotifyService
{

    protected $template;
    /**
     * Create a new controller instance.
     *
     * @param  UserRepository  $users
     * @return void
     */
    public function __construct(TemplateService $templateService)
    {
        $this->template = $templateService;
    }
    public function articleSubmissionNotification($data) {
            $details = ['body' => $this->template->authorSubmitted($data)];
            try{
                $mail_status = Mail::send('email.template', ['details'=>$details], function ($m) use ($data) {
                    $m->from('raabrera@up.edu.ph', 'Ecosystems and Development Journal');
                    $m->replyTo('raabrera@up.edu.ph', $name = null);
                    $m->to($data->email, $data->name)->subject($data->subject);
                });
                return 'success';
                // return redirect()->route('me.article', ['id' => $request->input('id')])
                // ->with('success','Notification Sent.'.$author->email);
            }
            catch(\Exception $e){
                return $e;
            }
    }
    
}