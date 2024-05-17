<?php

namespace App\Jobs;

use App\Mail\PostMail;
use App\Models\Post;
use App\Models\SendMail;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendPostMailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $userId;
    protected $post;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($userId, Post $post)
    {
        $this->userId = $userId;
        $this->post = $post;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $user = User::findOrFail($this->userId);
        $subject = 'News from: ' . $this->post->website->name;

        try {
            Mail::to($user)->send(new PostMail($subject, $this->post->title, $this->post->content));
            SendMail::where('user_id', $this->userId)
                ->where('post_id', $this->post->id)
                ->update(['sent_success' => true]);
        } catch (\Throwable $th) {
            Log::error('SendPostMailJob | handle | error : ', [$th->getMessage()]);
        }
    }
}
