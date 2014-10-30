<?phprequire_once 'Google/Client.php';require_once 'Google/Service/YouTube.php';/*Plugin Name: SyN's Youtube WidgetPlugin URI: http://testytraitors.com/pluginsDescription: Creates a widget with a list of CoC youtube vidsVersion: 0.1Author: Corey Jones (SyNiK4L)Author URI: http://testytraitors.comLicense: A "Slug" license name e.g. GPL2*/class youtube_widget extends WP_Widget{    function youtube_widget()    {        $widget_ops = array('classname' => 'youtube_widget', 'description' => 'Displays a widget with a list of youtube videos. ');        $this->WP_Widget('youtube_widget', 'Youtube Widget', $widget_ops);    }    function form($instance)    {        $instance = wp_parse_args((array)$instance, array('title' => '', 'content' => ''));        $title = $instance['title'];        $game = $instance['game'];        $limit = $instance['limit'];        $type = $instance['type'];        $order = $instance['order'];        ?>        <p><label for="<?php echo $this->get_field_id('title'); ?>">Title: <input class="widefat"                                                                                  id="<?php echo $this->get_field_id('title'); ?>"                                                                                  name="<?php echo $this->get_field_name('title'); ?>"                                                                                  type="text"                                                                                  value="<?php echo attribute_escape($title); ?>"/></label>        </p>        <p><label for="<?php echo $this->get_field_id('game'); ?>">Game: <input class="widefat"                                                                                id="<?php echo $this->get_field_id('game'); ?>"                                                                                name="<?php echo $this->get_field_name('game'); ?>"                                                                                type="text"                                                                                value="<?php echo attribute_escape($game); ?>"/></label>        </p>        <p><label for="<?php echo $this->get_field_id('limit'); ?>">Limit: <input class="widefat"                                                                                  id="<?php echo $this->get_field_id('limit'); ?>"                                                                                  name="<?php echo $this->get_field_name('limit'); ?>"                                                                                  type="text"                                                                                  value="<?php echo attribute_escape($limit); ?>"/></label>        </p>        <p><label for="<?php echo $this->get_field_id('type'); ?>">Type(eg: channel, video,playlist): <input                    class="widefat"                    id="<?php echo $this->get_field_id('type'); ?>"                    name="<?php echo $this->get_field_name('type'); ?>"                    type="text"                    value="<?php echo attribute_escape($type); ?>"/></label>        </p>        <p><label for="<?php echo $this->get_field_id('order'); ?>">Order(eg: rating,                date,relevence,title,videoCount,viewCount): <input class="widefat"                                                                   id="<?php echo $this->get_field_id('order'); ?>"                                                                   name="<?php echo $this->get_field_name('order'); ?>"                                                                   type="text"                                                                   value="<?php echo attribute_escape($order); ?>"/></label>        </p>    <?php    }    function update($new_instance, $old_instance)    {        $instance = $old_instance;        $instance['title'] = strip_tags($new_instance['title']);        $instance['game'] = strip_tags($new_instance['game']);        $instance['limit'] = strip_tags($new_instance['limit']);        $instance['type'] = strip_tags($new_instance['type']);        $instance['type'] = strip_tags($new_instance['order']);        return $instance;    }    function widget($args, $instance)    {        extract($args, EXTR_SKIP);        echo $before_widget;        $attrs = array();        $attrs['title'] = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);        $attrs['query'] = urlencode($instance['game']);        $attrs['limit'] = empty($instance['limit']) ? 5 : $instance['limit'];        $attrs['type'] = empty($instance['type']) ? "video" : $instance['type'];        $attrs['order'] = empty($instance['order']) ? "rating" : $instance['order'];        if (empty($title))            echo "<div>Missing widget title</div>";        else            echo $before_title . $title . $after_title;        if (empty($game))            echo "<div>Please select a game to search for</div>";        $videosResponse = youTubeCall($attrs,0);        $videos = "";        foreach ($videosResponse['items'] as $videoResult) {            $videos .= sprintf('<li>%s<iframe src="http://youtube.com/embed/%s"></iframe></li>',                $videoResult['snippet']['title'],                $videoResult['id']);        }        echo "<ul>$videos</ul>";        echo $after_widget;    }}/* * * * * Below is the Video Page * * * * */function youtubeVids($atts){    #Shortcode Defaults    $attrs = shortcode_atts(array(        'query' => 'Clash of clans',        'limit' => '20',        'type' => 'video',        'order' => 'viewCount'    ), $atts);    #checking if get parameters exists if so they overwrite the defaults set in the page parameters    parse_str($_SERVER['QUERY_STRING'], $params);    foreach($params as $param=>$value) {        $cleanedParam = filter_var($value, FILTER_SANITIZE_STRING);        $attrs[$param] = $cleanedParam;    }    if(isset($attrs['townhall']))        $attrs['query'] .= " ".$attrs['townhall'];    #thx for the data youtube    $response = youTubeCall($attrs, 0);    $htmlData = buildHTML($response, $attrs);    ?>    <h1 style="text-align:center;">Youtube Clash Videos</h1>    <div id="control_container">        <div id="sort_controls">            <label for="search_type">Select a Search Term</label><br>            <select name="search_type" id="search_type">                <option value="Clash of Clans">Clash of Clans</option>                <option value="Clash of Clans Attack Strategies">Clash of Clans Attack Strategies</option>                <option value="Clash of Clans Bases">Clash of Clans Bases</option>                <option value="Clash of Clans War Bases">Clash of Clans War Bases</option                <option value="Clash of Clans Farming Bases">Clash of Clans Farming Bases</option                <option value="Clash of Clans Strategies">Clash of Clans Strategies</option>                <option value="Clash of Clans Tips">Clash of Clans Tips</option>            </select><br>            <label for="th_level">Select a town hall level. This is optional.</label><br>            <select name="th_level" id="th_level">                <option value="NotSelected">Not Selected</option>                <option value="th10">TH10</option>                <option value="th9">TH9</option>                <option value="th8">TH8</option>                <option value="th7">TH7</option>                <option value="th6">TH6</option>                <option value="th5">TH5</option>                <option value="th4">TH4</option>            </select>            <br>            <label for="sort_order">Select a Sort Order</label><br>            <select name="sort_order" id="sort_order">                <option value="viewCount">View Count</option>                <option value="relevance">Relevance</option>                <option value="rating">Rating</option>                <option value="date">Date</option>                <option value="title">Title</option>                <option value="videoCount">Video Count</option>            </select>            <br><label for="video_type">Select a type</label><br>            <select name="video_type" id="video_type">                <option value="video">Video</option>                <option value="channel">Channel</option>                <!--  <option value="viewCount">Playlist</option>-->            </select>            <span id="search_display"><?php echo "Currently searching: <b>" . $attrs['query'] . "</b>" ?></span>        </div>        <div id="right_control_container">            <label for="result_limit">Result limit:</label>            <select name="result_limit" id="result_limit">                <option value="50">50</option>                <option value="40">40</option>                <option value="30">30</option>                <option value="20">20</option>                <option value="10">10</option>                <option value="5">5</option>            </select>            <div id="sort_direction">            <a href="#" class="sort_direction" id="asc">Ascending</a>            <a href="#" class="sort_direction" id="desc">Descending</a>            </div>        <div id="pagination">            <span class="page_control prev-page" id="prev_page">Prev Page</span> |            <span class="page_control next-page" id="next_page">Next Page</span>        </div>        </div>    </div>    <div id='video_container'><?php echo $htmlData; ?> </div>    <div id="pagination_bottom">        <span class="page_control prev-page" id="prev_page_bottom">Prev Page</span> |        <span class="page_control next-page" id="next_page_bottom">Next Page</span>    </div>    <div id='player_container' style='display:none;'></div><?php}function buildHTML($response, $attrs){    $htmlData = '';    #looping through the youtube call results    foreach ($response['items'] as $result) {        #If the type of youtube search is video        if ($attrs['type'] == "video") {            $htmlData .= sprintf('<div class="single_video" channel="%s" id="%s">        <div class="user_content video_title">%s</div>        <div class="preview_div user_content"><img src="%s" class="user_content preview_image"></div>        <div class="user_content view_count">Views: %s</div>        <div class="user_content like_count">Likes: %s</div>        <div class="user_content dislike_count">Dislikes: %s</div>        <div class="user_content video_popout"><a href="http://youtube.com/embed/%s" target="_blank">Open video in new window</a></div>        </div>',                $result['snippet']['channelTitle'],                $result['id'],                $result['snippet']['title'],                $result['snippet']['thumbnails']['medium']['url'],                $result['statistics']['viewCount'],                $result['statistics']['likeCount'],                $result['statistics']['dislikeCount'],                $result['id']            );        }#If the type of youtube search is channel        else if ($attrs['type'] == "channel") {            $htmlData .= sprintf('<div class="single_video channel" channel="%s" id="%s">        <a href="http://youtube.com/channel/%s" target="_blank"><div class="user_content video_title">%s</div>        <div class="preview_div user_content"><img src="%s" class="user_content preview_image"></div></a>        <div class="user_content view_count">Views: %s</div>        <div class="user_content video_popout"><a href="http://youtube.com/channel/%s" target="_blank">Open video in new window</a></div>        </div>',                $result['snippet']['channelTitle'],                $result['id'],                $result['id'],                $result['snippet']['title'],                $result['snippet']['thumbnails']['medium']['url'],                $result['statistics']['viewCount'],                $result['id']            );        }    }    return $htmlData;}function youTubeCall($params,$debug = 0){    #initialization details    $client = new Google_Client();    $key = file_get_contents('/home/ttraiters/key.txt');    $client->setDeveloperKey($key);    $youtube = new Google_Service_YouTube($client);    $videoResults = array();    $response = '';    $params['pageKey'] = '';    # Make the call to the API doing a basic search for either channel or video ids    try {        $searchResponse = $youtube->search->listSearch('id,snippet', array(            'q' => $params['query'],            'maxResults' => $params['limit'],            'type' => $params['type'],            'order' => $params['order'],            'pageToken' => $params['pageKey']        ));        echo sprintf('<meta id="next_page_id" the_id="%s"><meta id="prev_page_id" the_id="%s">',            $searchResponse['nextPageToken'],            $searchResponse['prevPageToken']        );        #Debug        if ($debug == 1 || $debug == 3) echo "Search Response: <pre>" . print_r($searchResponse, true) . "</pre>";    } catch (Google_Service_Exception $e) {        echo '<script type="text/javascript">console.log(' . json_encode($e) . ')</script>';    }    # Call the videos.list method to retrieve location details for each video.    if ($params['type'] == "channel") {        foreach ($searchResponse['items'] as $searchResult) {            array_push($videoResults, $searchResult['id']['channelId']);        }        if (isset($params['sort'])) {            if ($params['sort'] == "asc") $videoResults = array_reverse($videoResults);        }        $channelIds = implode(',', $videoResults);        $response = $youtube->channels->listChannels('snippet,statistics', array(            'id' => $channelIds        ));    } else if ($params['type'] == "video") {        foreach ($searchResponse['items'] as $searchResult) {            array_push($videoResults, $searchResult['id']['videoId']);        }        if (isset($params['sort'])) {            if ($params['sort'] == "asc") $videoResults = array_reverse($videoResults);        }        $videoIds = implode(',', $videoResults);        $response = $youtube->videos->listVideos('snippet, statistics', array(            'id' => $videoIds,        ));    }    if ($debug == 2 || $debug == 3) echo "Video Data Response: <pre>" . print_r($response, true) . "</pre>";    return $response;}function youtube_scripts(){    wp_enqueue_style("rbw_css2", path_join(WP_PLUGIN_URL, basename(dirname(__FILE__)) . "/styles.css"));    wp_enqueue_script('mainyoutube', path_join(WP_PLUGIN_URL, basename(dirname(__FILE__)) . '/main.js', array(), '1.0.0', true));}add_action('wp_enqueue_scripts', 'youtube_scripts');add_action('widgets_init', create_function('', 'return register_widget("youtube_widget");'));add_shortcode('youtubeVids', 'youtubeVids');