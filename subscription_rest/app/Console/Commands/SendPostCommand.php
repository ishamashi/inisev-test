<?php

namespace App\Console\Commands;

use App\Jobs\SendPostMailJob;
use App\Models\Post;
use App\Models\SendMail;
use App\Models\Subscription;
use Illuminate\Console\Command;

class SendPostCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-post-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
     public function handle()
     {
         $allPosts = Post::all();
 
         foreach ($allPosts as $post) {
             $subscribedUserIds = $post->website->subscriptions()->pluck('user_id');
 
             foreach ($subscribedUserIds as $userId) {
                 if (!$this->isEmailSent($post->id, $userId) && $this->isUserSubscribed($post->website->id, $userId)) {
                     SendMail::create([
                         'user_id' => $userId, 
                         'post_id' => $post->id, 
                         'sent_success' => true
                     ]);
 
                     dispatch(new SendPostMailJob($userId, $post));
                 }
             }
         }
     }
 
     private function isUserSubscribed($websiteId, $userId)
     {
         return Subscription::where('website_id', $websiteId)
             ->where('user_id', $userId)
             ->exists();
     }
 
     private function isEmailSent($postId, $userId)
     {
         return SendMail::where('post_id', $postId)
             ->where('user_id', $userId)
             ->where('sent_success', true)
             ->exists();
     }
 }
 