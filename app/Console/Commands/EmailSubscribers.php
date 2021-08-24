<?php

namespace App\Console\Commands;

use App\Models\Post;
use App\Models\Subscriber;
use App\Notifications\PostPublished;
use Illuminate\Console\Command;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\DB;

class EmailSubscribers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mail:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send a marketing email to users';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $posts = Post::all();
        foreach ($posts as $post) {
            $already_subscribed = DB::table('mailing_lists')->where('post_id', '=', $post->id)->pluck('subscriber_id');
            $new_subscribers = Subscriber::whereNotIn('id', $already_subscribed);
            Notification::send($new_subscribers, new PostPublished($post));
            return true;
        }

    }
}
