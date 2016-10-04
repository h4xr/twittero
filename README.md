Twittero
===================


Twittero is a simple Twitter Client that uses Twitter search API to provide you with tweets that contain a particular word, feeling or tag.
Currently to customize the type of tweets to return and setup the retweet threshold you can edit <i>json.php</i> and change the first and second parameter for <i>TwitterClient()</i>. 

Requirements
-------------

Twittero is built as a PHP Application having a very simple structure. The requirements for running twittero are:
> PHP 5.6 or higher
> cURL support for PHP

Framework/SDK Used
---------------
Twittero depends on a simple PHP SDK named TwitterAPIExchange, which provides automatic url query and OAuth authetication support for Twitter.
