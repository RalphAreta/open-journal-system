<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
   public function run(): void
{
    $faqs = [
        // Submissions
        ['category' => 'Submissions', 'sort_order' => 1, 'question' => 'How do I submit a manuscript?', 'answer' => '<a href="/register">Register an account</a> or sign in, then click <strong>New Submission</strong> in your Author Dashboard. Upload your manuscript file (PDF, DOC, or DOCX), fill in the title, abstract and keywords, then click Submit. You\'ll receive a confirmation email with your reference number.'],
        ['category' => 'Submissions', 'sort_order' => 2, 'question' => 'What file formats are accepted?', 'answer' => 'We accept <strong>PDF</strong>, <strong>DOC</strong>, and <strong>DOCX</strong> files for the main manuscript.'],
        ['category' => 'Submissions', 'sort_order' => 3, 'question' => 'Is there a submission fee?', 'answer' => 'Submission and peer review are <strong>free of charge</strong>. An Article Processing Charge (APC) applies only upon acceptance to cover open-access publishing and DOI registration. Authors are notified of the exact fee at the acceptance stage.'],
        ['category' => 'Submissions', 'sort_order' => 4, 'question' => 'Can I submit to multiple journals simultaneously?', 'answer' => 'No. We follow strict <strong>single-submission policy</strong>. Submitting the same manuscript to another journal while it is under review here constitutes a violation of publication ethics and may result in immediate rejection and blacklisting.'],

        // Review Process
        ['category' => 'Review Process', 'sort_order' => 5, 'question' => 'How long does peer review take?', 'answer' => 'Initial screening takes <strong>3–5 days</strong>. Full peer review typically takes <strong>10–14 days</strong>. The total time from submission to first decision is usually 2–3 weeks. Revision and final decision adds another 1–2 weeks depending on the scope of changes requested.'],
        ['category' => 'Review Process', 'sort_order' => 6, 'question' => 'What is double-blind peer review?', 'answer' => 'In double-blind review, both the <strong>reviewers\' identities are hidden from authors</strong> and the <strong>authors\' identities are hidden from reviewers</strong>. This eliminates bias based on institutional affiliation, gender, nationality, or prior reputation, ensuring evaluation is based purely on scholarly merit.'],
        ['category' => 'Review Process', 'sort_order' => 7, 'question' => 'What happens if revisions are requested?', 'answer' => 'You\'ll receive detailed reviewer comments in your dashboard. Address each point in a <strong>point-by-point response letter</strong> and upload the revised manuscript. Revisions are typically due within <strong>14–21 days</strong>. The revised manuscript goes back to the original reviewers for final assessment.'],
        ['category' => 'Review Process', 'sort_order' => 8, 'question' => 'Can I appeal a rejection?', 'answer' => 'Yes. You may submit a formal appeal through your Author Dashboard within <strong>30 days</strong> of the rejection decision. Appeals must include a detailed rebuttal addressing the reviewers\' concerns. The Editor-in-Chief reviews all appeals. Each manuscript is limited to two appeal attempts.'],

        // Publication & Copyright
        ['category' => 'Publication & Copyright', 'sort_order' => 9, 'question' => 'What is the Copyright Transfer Form (CTF)?', 'answer' => 'Upon acceptance, we issue a <strong>Copyright Transfer Form</strong> which assigns publication rights to the journal while allowing authors to retain the right to use their work for educational and research purposes. Download it from your dashboard, sign it, and upload the signed copy. Publication will not proceed until the CTF is received.'],
        ['category' => 'Publication & Copyright', 'sort_order' => 10, 'question' => 'Is my article freely accessible after publication?', 'answer' => 'Yes. All published articles are <strong>open access</strong> — freely available to anyone worldwide, permanently. Each article receives a <strong>DOI</strong> (Digital Object Identifier) for permanent citation, and is indexed and distributed through academic databases and search engines.'],

        // Account & Technical
        ['category' => 'Account & Technical', 'sort_order' => 11, 'question' => 'How do I track my submission status?', 'answer' => 'Sign in to your account and visit the <strong>Author Dashboard</strong>. Each submission shows a real-time status badge: Submitted → Under Review → Revisions Requested → Accepted/Rejected. You\'ll also receive email notifications at every major status change.'],
        ['category' => 'Account & Technical', 'sort_order' => 12, 'question' => 'I forgot my password. How do I reset it?', 'answer' => 'On the <a href="/login">Sign In page</a>, click <strong>"Forgot password?"</strong>. Enter your registered email address and we\'ll send a password reset link within a few minutes. Check your spam folder if you don\'t see it. The link expires after 60 minutes.'],
    ];

    foreach ($faqs as $faq) {
        \App\Models\Faq::create(array_merge($faq, ['is_active' => true]));
    }
}
}
