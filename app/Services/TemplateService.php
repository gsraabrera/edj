<?php 

namespace App\Services;

class TemplateService
{
    public function articleRejected($data)
    {
        foreach ($data->authors as $item) {
            if ($item->type == "Author") {
                $author =  $item;
            }
        }
        return "Manuscript Ref. No.: $data->manuscript_reference_no<br/>
        Title: $data->title<br/>
        E&amp;D Journal<br/><br/>
        Dear $author->title $author->first_name $author->middle_name $author->last_name,<br/><br/>
        Thank you for submitting your paper to the Ecosystems and Development Journal.<br/><br/>
        We regret to inform you that your paper cannot be accepted for publication for the
        following reason/s:<br/><br/><br/>

        For more details, you may contact the Managing Editor (edjournal@up.edu.ph).
        We appreciate your interest in publishing your manuscript in the Ecosystems and
        Development Journal. Thank you for giving us the opportunity to consider your work.<br/><br/>
        Yours sincerely,<br/><br/><br/>
        Editor-in-Chief<br/>
        Ecosystems and Development Journal<br/>";
    }

    public function articleAccepted($data)
    {
        foreach ($data->authors as $item) {
            if ($item->type == "Author") {
                $author =  $item;
            }
        }
        return "Manuscript Ref. No.:  $data->manuscript_reference_no <br/>
        Title: $data->title <br/>
        E&amp;D Journal<br/>
        Dear $author->title $author->first_name $author->middle_name $author->last_name,<br/><br/>
        We are pleased to inform you that your revised manuscript has been accepted for
        publication as a Regular Article in the next available issue of the Ecosystems and
        Development Journal.<br/><br/>
        Kindly submit a final version that strictly complies with the format of a Regular Article as
        explained in the E&amp;D Journal Author’s Guide found in:
        ".route('home').".<br/><br/>
        Please send it to the E&amp;D Journal Managing Editor, Dr. Marilyn S. Combalicer at:
        edjournal@up.edu.ph. The final revised article will be used to produce the galley proof
        in preparation for publication.<br/><br/>
        We look forward to hearing from you soon so as not to delay the publication of your
        work.<br/>
        Kindly direct to the E&amp;D Journal Managing Editor any future inquiry regarding<br/>
        the publication status of your article.<br/><br/>
        Thank you.<br/><br/>
        Yours sincerely,<br/><br/>
        Editor-in-Chief, E&amp;D Journal<br/>
        Professor, Institute of Renewable Natural Resources<br/>
        College of Forestry and Natural Resources<br/>
        University of the Philippines Los Baños<br/>
        College, Laguna<br/>";
    }

    public function articleWithRevision()
    {
        return "Date:<br/>
        -----------------<br/>
        -----------------<br/>
        -----------------<br/><br/>
        
        Dear _________:<br/>
        Thank you for considering the Ecosystems and Development Journal as a venue for<br/>
        publication of your research paper.<br/><br/>
        After a thorough evaluation of specialists in your field, it is recommended that your<br/>
        paper entitled, “__________” [E&amp;D-J-21-00], can be considered for publication only<br/>
        after the following revisions/comments are answered and complied with.<br/><br/>
        Attached is a copy of the reviewers’ comments and recommendations on your paper.<br/>
        Please submit a copy of your revised paper and a checklist of your point-for-point<br/>
        answers to reviewers’ comments not later than four (4) weeks upon receipt of this letter.<br/>
        You may send it through email edjournal@up.edu.ph.<br/><br/>
        Thank you. We hope to receive your revised manuscript soon.<br/><br/>
        Yours sincerely,<br/><br/>
        Editor-in-Chief, E&amp;D Journal<br/>
        Professor, Institute of Renewable Natural Resources<br/>
        College of Forestry and Natural Resources<br/>
        University of the Philippines Los Baños<br/>
        College, Laguna<br/>
        Tel Nos.:<br/>
        COMMENTS ON THE PAPER<br/>";
    }

    public function authorSubmitted($data)
    {
        return "Manuscript Ref. No.: $data->manuscript_reference_no<br/>
        Title: $data->title<br/>
        E&amp;D Journal<br/><br/>
        Dear $data->name,<br/><br/><br/>
        This is to acknowledge the receipt of your article, cover letter, and signed authors’
        agreement form.<br/><br/>
        In reference to your manuscript, &quot;$data->title&quot; submitted for possible publication in
        the Ecosystems and Development Journal, your reference number is $data->manuscript_reference_no.
        Your paper will be forwarded to the Subject Matter Specialist and Editor-in-Chief for
        initial evaluation. You may check the status of your article any time.<br/><br/>
        Thank you.<br/><br/>
        Yours sincerely,<br/>
        Managing Editor<br/>
        Ecosystems and Development Journal";
    }

    
}