/**
* File: index.js
* Description: We make our twitter client dynamic by asynchronously
* retreiving data from the backend.
* Author: Saurabh Badhwar <sbsaurabhbadhwar9@gmail.com>
* License: MIT License
*/
$(document).ready(function(){
  getTweets();
  var timer = setInterval(getTweets, 10000);
});

function getTweets() {
  var $tweets;
  //Make an ajax call to the backend and get the response
  $.ajax({
    url: "json.php",
    dataType: "json",
    success: function(data) {
      $tweets = data;
      appendTweets($tweets);
    }
  });
}

function appendTweets($tweets) {
  $("#tweets").html('');
  $.each($tweets, function(key,value) {
    var tweetBox = "<div class='tweet'><div class='tweet-head'>";
    tweetBox += value[1];
    tweetBox += " (Retweeted " + value[2] + ' Times)';
    tweetBox += "</div><div class='tweet-body'>";
    tweetBox += value[0];
    tweetBox += "</div></div>";

    $("#tweets").append(tweetBox);
  });
}
