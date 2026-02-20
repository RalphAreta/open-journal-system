@component('mail::message')
# Submission Status Update: Initial Screening

Dear {{ $submission->author->name }},

We are writing to inform you about the results of the initial screening for your manuscript submission.

**Manuscript Title:** {{ $submission->title }}

**Screening Result:** 
@if ($submission->hasPassedInitialScreening())
**✓ PASSED**

Congratulations! Your manuscript has passed the initial screening and will proceed to the next stage of the review process. An editor will soon be assigned to manage the review of your manuscript.
@else
**✗ FAILED**

Unfortunately, your manuscript did not pass the initial screening process. Please see the detailed feedback below.
@endif

**Screening Comments:**

{{ $submission->initial_screening_comments }}

**Next Steps:**
@if ($submission->hasPassedInitialScreening())
- Our editorial team will review your manuscript further
- You will be notified once it is assigned to a peer reviewer
- The review process typically takes 4-8 weeks
- You can track the status of your submission on our website
@else
- You may revise your manuscript and resubmit it for consideration
- Please take into account the feedback provided above
- If you have any questions, please contact our editorial office
- We encourage you to reach out if you would like further guidance
@endif

If you have any questions about this decision or need clarification, please don't hesitate to contact our editorial office.

Best regards,

**The Editorial Team**  
{{ config('app.name') }}

@component('mail::subcopy')
This is an automated message. Please do not reply to this email. If you have questions, please visit our website or contact our editorial office directly.
@endcomponent

@endcomponent
