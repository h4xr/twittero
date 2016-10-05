<?php
  ini_set('display_errors', false);
  include('classes/TwitterClient.php');

  /**
  * Used for AJAX calls by the Twitter Client
  *
  * @author Saurabh Badhwar <sbsaurabhbadhwar9@gmail.com>
  * @license MIT License
  */

  //Setup the access control
  $settings = array(
    'oauth_access_token' => 'OAUTH_TOKEN',
    'oauth_access_token_secret' => 'OAUTH_SECRET',
    'consumer_key' => 'CONSUMER_KEY',
    'consumer_secret' => 'CONSUMER_SECRET'
  );

  //Create a new Twitter Client Instance
  $client = new TwitterClient('#custserv', 1, $settings);

  //Return data with valid MIME Types
  header("Content-Type: application/json");
  echo $client->makeRequest();
