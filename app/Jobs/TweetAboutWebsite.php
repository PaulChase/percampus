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

class TweetAboutWebsite implements ShouldQueue
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

        $banner1 = $twitter->tweets()->upload("https://elasticbeanstalk-us-east-2-481189719363.s3.us-east-2.amazonaws.com/banners/banner1.jpg");
        $banner2 = $twitter->tweets()->upload("https://elasticbeanstalk-us-east-2-481189719363.s3.us-east-2.amazonaws.com/banners/banner2.jpg");
        $pastry = $twitter->tweets()->upload("https://elasticbeanstalk-us-east-2-481189719363.s3.us-east-2.amazonaws.com/banners/pastry.jpg");
        $trousers = $twitter->tweets()->upload("https://elasticbeanstalk-us-east-2-481189719363.s3.us-east-2.amazonaws.com/banners/trousers.jpg");
        $palms = $twitter->tweets()->upload("https://elasticbeanstalk-us-east-2-481189719363.s3.us-east-2.amazonaws.com/banners/palms.jpg");
        $shoeMaking = $twitter->tweets()->upload("https://elasticbeanstalk-us-east-2-481189719363.s3.us-east-2.amazonaws.com/banners/shoe+making.jpg");
        $makeup = $twitter->tweets()->upload("https://elasticbeanstalk-us-east-2-481189719363.s3.us-east-2.amazonaws.com/banners/makeup.jpg");
        $electric = $twitter->tweets()->upload("https://elasticbeanstalk-us-east-2-481189719363.s3.us-east-2.amazonaws.com/banners/electric.jpg");
        $photoshop = $twitter->tweets()->upload("https://elasticbeanstalk-us-east-2-481189719363.s3.us-east-2.amazonaws.com/banners/photoshop.jpg");


        $mainTweetMedia = (new Media)->mediaIds([$banner1->media_id_string]);

        $mainTweet = (new Tweet)->text("Sell your products and services with US totally free. \r\n \r\n We help  sell your stuff 10X faster. \r\n \r\n visit https://www.percampus.com to get started \r\n \r\n {$trendingKeywords}")->media($mainTweetMedia);

        $mainTweeted =    $twitter->tweets()->tweet($mainTweet);

        $reply = (new Reply)->inReplyToTweetId($mainTweeted->data->id);

        // first Reply
        $firstReplyMedia = (new Media)->mediaIds([$trousers->media_id_string, $palms->media_id_string, $pastry->media_id_string]);

        $firstReply = (new Tweet)->text("Whatever products you have for sale, we gat you covered. \r\n \r\n One of the cool things is that we post your products here on Twitter every 30mins with trending words, \r\n to reach more potential customers.")->media($firstReplyMedia)->reply($reply);

        $twitter->tweets()->tweet($firstReply);

        // Second Reply
        $secondReplyMedia = (new Media)->mediaIds([$shoeMaking->media_id_string, $electric->media_id_string, $makeup->media_id_string, $photoshop->media_id_string]);

        $secondReply = (new Tweet)->text("If you offer services such as: \r\n Graphics Design \r\n Electrical Installation \r\n Shoe Making etc \r\n \r\n You're also welcome to our webiste.")->media($secondReplyMedia)->reply($reply);

        $twitter->tweets()->tweet($secondReply);

        // third Reply
        $thirdReplyMedia = (new Media)->mediaIds([$banner2->media_id_string]);

        $thirdReply = (new Tweet)->text("All you have to do is visit our website at https://www.percampus.com \r\n Register and start posting your products/services. \r\n \r\n Have any questions? \r\n DM us here on Twitter")->media($thirdReplyMedia)->reply($reply);

        $twitter->tweets()->tweet($thirdReply);
    }
}
