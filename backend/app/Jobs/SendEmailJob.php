<?php

namespace App\Jobs;

use App\Services\MailService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class SendEmailJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    private $to;
    private $subject;
    private $text;
    private $html;
    public function __construct(
        $to, $subject, $text, $html
    )
    {
        $this->to = $to;
        $this->subject = $subject;
        $this->text = $text;
        $this->html = $html;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        (new MailService())->send($this->to, $this->subject, $this->text, $this->html);
    }
}
