<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Coderjerk\BirdElephant\BirdElephant;
use Coderjerk\BirdElephant\Compose\Reply;
use Coderjerk\BirdElephant\Compose\Tweet;
use Coderjerk\BirdElephant\Compose\Media;
use Abraham\TwitterOAuth\TwitterOAuth;

class PostAboutViralocal implements ShouldQueue
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
        $twitterConsumerKey = 'mvxMuxYiGqTPb8tFxOn5Oihne';
        $twitterConsumerSecret = 'zMtUdgidhhTET7PzTb7VPAlghI4mTmdwLJIVEUniWICbIpC2Jt';
        $twitterAccessToken = '1488982920496914433-niGYmStAYrO7ZQgOGOgqTxFddA6wPu';
        $twitterAccessTokenSecret = 'FSMiza1TYd2VKGRHVkwHaizp565UEIloBIJ5n4wplnU2S';
        $twitterBearerToken = 'AAAAAAAAAAAAAAAAAAAAAFoOZAEAAAAAy1JB%2Fw%2FCsDFKjT7S4vZ3T1agytc%3DZGZUTMod5lf5dVsQNoLyN7nWXjdaSjrKf17cocmtlcGrWIjBFS';

        // make connection
        $connection = new TwitterOAuth($twitterConsumerKey, $twitterConsumerSecret, $twitterAccessToken, $twitterAccessTokenSecret);

        // set the timeouts incase of network delay
        $connection->setTimeouts(10, 20);

        // get trending keywords in nigeria
        $trendingNow = $connection->get("trends/place", ["id" => 1404447]);

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

        $trendingKeywords = "{$trendingTopics[0]} {$trendingTopics[1]} {$trendingTopics[2]}";


        $credentials = array(
            'bearer_token' => $twitterBearerToken, // OAuth 2.0 Bearer Token requests
            'consumer_key' =>  $twitterConsumerKey, // identifies your app, always needed
            'consumer_secret' => $twitterConsumerSecret, // app secret, always needed
            'token_identifier' => $twitterAccessToken, // OAuth 1.0a User Context requests
            'token_secret' => $twitterAccessTokenSecret, // OAuth 1.0a User Context requests
        );

        $twitter = new BirdElephant($credentials);

        $dash = $twitter->tweets()->upload("https://elasticbeanstalk-us-east-2-481189719363.s3.us-east-2.amazonaws.com/banners/dash.jpg");
        $welcome = $twitter->tweets()->upload("https://elasticbeanstalk-us-east-2-481189719363.s3.us-east-2.amazonaws.com/banners/welcome.jpg");
        $create = $twitter->tweets()->upload("https://elasticbeanstalk-us-east-2-481189719363.s3.us-east-2.amazonaws.com/banners/create.jpg");



        $mainTweetMedia = (new Media)->mediaIds([$welcome->media_id_string, $create->media_id_string, $dash->media_id_string]);

        $mainTweet = (new Tweet)->text("Are you also tired of your tweets not reaching a lot of users? \r\n \r\n I'm currently using this great online tool that automatically adds the top 5 trending hastags to your tweets for FREE \r\n \r\n Check it out now at https://viralocal.herokuapp.com   \r\n \r\n {$trendingKeywords}")->media($mainTweetMedia);

        $twitter->tweets()->tweet($mainTweet);
    }
}
