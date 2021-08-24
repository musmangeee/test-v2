<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\PublishPostRequest;
use App\Http\Controllers\Controller;
use App\Models\Subscriber;
use App\Models\User;
use App\Notifications\PostPublished;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class PostController extends Controller
{
    public function publish_post(PublishPostRequest $request)
    {

        $post = $request->user()->posts()->create($request->all());

        // Sending email
        $subscribers = Subscriber::all();
        $post->subscribers()->attach($subscribers->pluck('id'));
        Notification::send($subscribers, new PostPublished($post));
        return $post;
    }
}
