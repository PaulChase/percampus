<?php

namespace App\Jobs;

use App\Models\Post;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Coderjerk\BirdElephant\BirdElephant;
use Coderjerk\BirdElephant\Compose\Tweet;
use Coderjerk\BirdElephant\Compose\Media;
use Abraham\TwitterOAuth\TwitterOAuth;
use App\Models\Category;

class RetweetJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        $marketplace = Category::find(2);

        $post = $marketplace->posts()->inRandomOrder()->first();


        // make connection
        $connection = new TwitterOAuth(env('TWITTER_CONSUMER_KEY'), env('TWITTER_CONSUMER_SECRET'), env('TWITTER_ACCESS_TOKEN'), env('TWITTER_ACCESS_TOKEN_SECRET'));

        // set the timeouts incase of network delay
        $connection->setTimeouts(10, 20);

        // get trending keywords in nigeria
        $trendingNow = $connection->get("trends/place", ["id" => 1398823]);

        $trendingTopics = [];

        // this if because of how the the data is structured
        foreach ($trendingNow as $hash) {

            $inner = $hash->trends;

            foreach ($inner as $in) {

                $value = $in->name;

                array_push($trendingTopics, $value);

                if (count($trendingTopics) === 10) {
                    break;
                }
            }
        }

        shuffle($trendingTopics);

        $trendingKeywords = "{$trendingTopics[0]} {$trendingTopics[1]}";

        $credentials = array(
            'bearer_token' => env('TWITTER_BEARER_TOKEN'), // OAuth 2.0 Bearer Token requests
            'consumer_key' =>  env('TWITTER_CONSUMER_KEY'), // identifies your app, always needed
            'consumer_secret' => env('TWITTER_CONSUMER_SECRET'), // app secret, always needed
            'token_identifier' => env('TWITTER_ACCESS_TOKEN'), // OAuth 1.0a User Context requests
            'token_secret' => env('TWITTER_ACCESS_TOKEN_SECRET'), // OAuth 1.0a User Context requests
        );

        $twitter = new BirdElephant($credentials);

        // $image = $twitter->tweets()->upload("https://elasticbeanstalk-us-east-2-481189719363.s3.us-east-2.amazonaws.com/public/images/{$post->images()->first()->Image_name}");


        // $media = (new Media)->mediaIds([$image->media_id_string]);

        // $tweet = (new Tweet)->text("title: '{$post->title}'. \r\n \r\n If interested, visit our website for more info: https://www.percampus.com/{$post->user->campus->nick_name}/{$post->subcategory->slug}/{$post->slug} \r\n \r\n {$trendingKeywords} ")->media($media);

        $tweet = (new Tweet)->text("god is great {$trendingKeywords}");

        $twitter->tweets()->tweet($tweet);



        // $post = new Post;
        // // add post to Database
        // $post->title = 'title one';
        // $post->description = 'lorem ipsum ondjdjd';
        // $post->price = 12345;
        // $post->venue = 'eskay estate';
        // $post->contact_info = 9087875656;
        // $post->item_condition = 'new';
        // $post->in_stock = 'no';
        // $post->subcategory_id = 2;
        // $post->user_id = 23;
        // $post->status = 'pending';


        // $post->save();
    }
}
