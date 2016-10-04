<?php
include('TwitterAPIExchange.php');

/**
* Twittero: A Simple Twitter Client
*
* PHP Version 5.6.21
*
* @author   Saurabh Badhwar <sbsaurabhbadhwar9@gmail.com>
* @license  MIT License
* @version  0.1.0
*/

/**
* TwitterClient is a simple class used to interact with the Twitter API
*
* TwitterClient is used to implement the functionality of interacting with the
* Twitter API to access the tweets with the specified format.
*
* @access   public
*/
class TwitterClient
{
    /**
    * Request URL
    *
    * @var string
    */
    private $request_url;
    /**
    * The request method
    *
    * @var string
    */
    private $request_method;

    /**
    * The term to be queried in the API
    *
    * @var string
    */
    private $search_term;

    /**
    * Minimum number of retweets
    *
    * @var int
    */
    private $minimum_retweets;

    /**
    * TwitterAPIExchange Object
    *
    * @var object
    */
    private $twitter_api_obj;

    /**
    * @var Mixed
    */
    private $response;

    /**
    * Creates a twitter client object used to retrieve the tweets from the
    * Twitter API. The API keys and OAuth access tokens can be generated from
    * dev.twitter.com
    * cURL is required for functioning of the client
    *
    * @param string $search_term The term to be searched for
    * @param int $minimum_retweets The minimum number of retweets required
    * @param array $settings The settings to authenticate to Twitter API
    */
    public function __construct($search_term, $minimum_retweets, $settings)
    {
      $this->search_term = $search_term;
      $this->minimum_retweets = $minimum_retweets;
      try {
        $this->twitter_api_obj = new TwitterAPIExchange($settings);
      }
      catch(RuntimeException $re)
      {
        echo "Curl Support Not Found";
        $this->twitter_api_obj = false;
      }
      catch(InvalidArgumentException $e)
      {
        echo "Invalid/Incomplete Credentials";
        $this->twitter_api_obj = false;
      }
      $this->request_url = "https://api.twitter.com/1.1/search/tweets.json";
      $this->request_method = "GET";
    }

    /**
    * Make an Twitter Search API request with the provided data and store
    * the response
    *
    * @return \TwitterClient Instance of self for method chaining
    */
    public function makeRequest()
    {
      if($this->twitter_api_obj == false)
      {
        throw new Exception("No instance of TwitterAPIExchange");
      }

      $getfield = "?q=$this->search_term&count=50";
      $this->response = $this->twitter_api_obj->setGetfield($getfield)
                                 ->buildOauth($this->request_url, $this->request_method)
                                 ->performRequest();
      //$this->response = json_decode($this->response, true);
      //var_dump(json_decode($this->response));
      //print_r($this->response);

      return $this->_filterData();
    }

    /**
    * Filter the API Response
    *
    * @access private
    *
    * @return json The json encoded array of filtered tweets
    */
    private function _filterData()
    {
      $filtered_data = array();
      $resp = json_decode($this->response, true);
      foreach($resp['statuses'] as $key=>$value)
      {
        if($value['retweet_count'] > 0)
          array_push($filtered_data, array($value['text'], $value['user']['screen_name'], $value['retweet_count']));
      }
      return json_encode($filtered_data);
    }
}
