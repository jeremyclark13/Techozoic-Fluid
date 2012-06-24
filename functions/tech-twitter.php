<?php

/**
 * Techozoic twitter feed
 *
 * @param string $user user of twitter feed to retrieve.
 * @param string $count number of tweets to retrive.
 * @param string $type type of info to retrive.
 * @param int $cache number of seconds transient is valid for.
 * 
 * Inspiration for code:
 * Chip Bennet's oenology theme https://github.com/chipbennett/oenology and
 * catswhocode http://www.catswhocode.com/blog/snippets/grab-tweets-from-twitter-feed
 * 
 * @return string of formatted API data
 * 
 * @since 2.0.7
 */
function tech_twitter_info($user = 'clarktechnet', $count = '3', $type = 'feed', $cache = 2160) {
    if ($type == 'feed') {
        // Build Twitter api url
        $apiurl = "http://api.twitter.com/1/statuses/user_timeline.json?screen_name=$user&count=$count&include_entities=true";
        //cache request
        $transient_key = "tech_" . $user . "_twitter";
    } elseif ($type == 'followers') {
        // Build Twitter api url
        $apiurl = "http://api.twitter.com/1/users/show.json?screen_name={$user}";
        //cache request
        $transient_key = "tech_" . $user . "_twitter_follow";
    }
    $i = 1;
    // If cached (transient) data are used, output an HTML
    // comment indicating such
    $cached = get_transient($transient_key);

    if (false !== $cached) {
        //return $cached;
    }

    // Request the API data, using the constructed URL
    $remote = wp_remote_get($apiurl);

    // If the API data request results in an error, return
    // an appropriate comment
    if (is_wp_error($remote)) {
        return '<p>' . __('Twitter unaviable', 'techozoic') . '</p>';
    }

    // If the API returns a server error in response, output
    // an error message indicating the server response.
    if ('200' != $remote['response']['code']) {
        return '<p>' . __('Twitter responded with an HTTP status code of ', 'techozoic') . esc_html($remote['response']['code']) . '.</p>';
    }

    // If the API returns a valid response, the data will be
    // json-encoded; so decode it.
    $data = json_decode($remote['body']);

    if ($type == 'feed') {
        $output = "<ul>\r\n";

        while ($i <= $count) {
            //Assign feed to $feed
            if (isset($data[$i - 1])) {
                if (isset($data[$i - 1]->in_reply_to_status_id_str)) {
                    $replyid = $data[$i - 1]->in_reply_to_status_id_str;
                    $reply = wp_remote_get("http://api.twitter.com/1/statuses/show/$replyid.json?include_entities=true");
                    if (!is_wp_error($reply)) {
                        $replydata = json_decode($reply['body']);
                        $replytext = $replydata->text;
                        $replytext = tech_twitter_format($replytext, $replydata);
                        $replyuser = $data[$i - 1]->in_reply_to_screen_name;
                        $replyid = $replydata->id_str;
                        $output .= "<li class='tweet reply'>" . $replytext . " - <em>\r\n<a href='http://twitter.com/$replyuser/status/$replyid'>" . human_time_diff(strtotime($replydata->created_at), current_time('timestamp')) . " " . __('ago', 'techozoic') . "</a></em><ul>\r\n";
                    }
                }
                $feed = tech_twitter_format($data[$i - 1]->text, $data[$i - 1]);
                $id_str = $data[$i - 1]->id_str;
                $output .= "<li class='tweet'>" . $feed . " - <em>\r\n<a href='http://twitter.com/$user/status/$id_str'>" . human_time_diff(strtotime($data[$i - 1]->created_at), current_time('timestamp')) . " " . __('ago', 'techozoic') . "</a></em></li>\r\n";
                if (isset($data[$i - 1]->in_reply_to_status_id_str)) {
                    $output .= "</ul></li>\r\n";
                }
            }
            $i++;
        }

        $output .="</ul>";
    } elseif ($type == 'followers') {
        $output = $data->followers_count . " " . __('followers', 'techozoic');
    }
    set_transient($transient_key, $output, $cache);

    return $output;
}

/**
 * Formats the tweet using the given entities element.
 *
 * @param string $raw_text just the text of the tweet
 * @param object $tweet an array of the tweet including entites
 * @return string the tweet text with entities replaced with hyperlinks
 * 
 * source: http://dmblog.ca/2011/08/how-to-use-tweet-entities/
 * 
 * @since 2.0.9
 */
function tech_twitter_format($raw_text, $tweet = NULL) {
    // first set output to the value we received when calling this function
    $output = $raw_text;

    // create xhtml safe text (mostly to be safe of ampersands)
    $output = htmlentities(html_entity_decode($raw_text, ENT_NOQUOTES, 'UTF-8'), ENT_NOQUOTES, 'UTF-8');

    // parse urls
    if ($tweet == NULL) {
        // for regular strings, just create <a> tags for each url
        $pattern = '/([A-Za-z]+:\/\/[A-Za-z0-9-_]+\.[A-Za-z0-9-_:%&\?\/.=]+)/i';
        $replacement = '<a href="${1}" rel="external">${1}</a>';
        $output = preg_replace($pattern, $replacement, $output);
    } else {
        // for tweets, let's extract the urls from the entities object
        foreach ($tweet->entities->urls as $url) {
            $old_url = $url->url;
            $expanded_url = (empty($url->expanded_url)) ? $url->url : $url->expanded_url;
            $display_url = (empty($url->display_url)) ? $url->url : $url->display_url;
            $replacement = '<a href="' . $expanded_url . '" rel="external">' . $display_url . '</a>';
            $output = str_replace($old_url, $replacement, $output);
        }

        // let's extract the hashtags from the entities object
        foreach ($tweet->entities->hashtags as $hashtags) {
            $hashtag = '#' . $hashtags->text;
            $replacement = '<a href="http://twitter.com/search?q=%23' . $hashtags->text . '" rel="external">' . $hashtag . '</a>';
            $output = str_ireplace($hashtag, $replacement, $output);
        }

        // let's extract the usernames from the entities object
        foreach ($tweet->entities->user_mentions as $user_mentions) {
            $username = '@' . $user_mentions->screen_name;
            $replacement = '<a href="http://twitter.com/' . $user_mentions->screen_name . '" rel="external" title="' . $user_mentions->name . ' on Twitter">' . $username . '</a>';
            $output = str_ireplace($username, $replacement, $output);
        }

        // if we have media attached, let's extract those from the entities as well
        if (isset($tweet->entities->media)) {
            foreach ($tweet->entities->media as $media) {
                $old_url = $media->url;
                $replacement = '<a href="' . $media->expanded_url . '" rel="external" class="twitter-media" data-media="' . $media->media_url . '">' . $media->display_url . '</a>';
                $output = str_replace($old_url, $replacement, $output);
            }
        }
    }

    return $output;
}

?>