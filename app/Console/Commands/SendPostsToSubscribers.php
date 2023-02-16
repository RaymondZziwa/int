<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\subscribers;
use App\Models\posts;
class SendPostsToSubscribers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:name';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        //
         // Retrieve all subscribers
         $subscribers = DB::table('subscribers')->get();

         // Retrieve all stories
         $posts = DB::table('posts')->get();
 
         // Filter out duplicate stories
         $unique_posts = [];
 
         foreach ($posts as $post) {
             $key = $post->title . $post->description;
             if (!array_key_exists($key, $unique_posts)) {
                 $unique_posts[$key] = $post;
             }
         }
 
         // Send email to each subscriber
         foreach ($subscribers as $subscriber) {
             $to = $subscriber->email;
             $subject = 'New posts on our website';
             $body = '';
 
             foreach ($unique_posts as $story) {
                 $body .= '<h2>' . $post->title . '</h2>';
                 $body .= '<p>' . $post->description . '</p>';
                //  $body .= '<p><a href="' . $story->url . '">Read more</a></p>';
             }
 
             // Send the email
             if (!empty($body)) {
                 Mail::send([], [], function ($message) use ($to, $subject, $body) {
                     $message->to($to);
                     $message->subject($subject);
                     $message->setBody($body, 'text/html');
                 });
 
                 $this->info('Email sent to ' . $to);
             } else {
                 $this->info('No new posts to send to ' . $to);
             }
         }
    }
}
