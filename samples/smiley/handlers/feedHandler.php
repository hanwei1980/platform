<?php
  /*
   * feedHandler.php - Feed form handler
   *
   */
include_once '../constants.php';
include_once LIB_PATH.'moods.php';
include_once LIB_PATH.'display.php';

$fb     = get_fb();

// The smiley that was chosen
$picked = $_POST['picked'];
$moods  = get_moods();
$canvas_url = $fb->get_facebook_url('apps') . APP_SUFFIX;


if ($picked != -1) {
  // Set data for this option. Use preferences for simplicity
  $old = $fb->api_client->data_getUserPreference(0);
  $fb->api_client->data_setUserPreference(0, '' . $picked . $old);

  $image = IMAGE_LOCATION . '/smile'.$picked.'.jpg';

  $images = array(array('src'  => $image,
                        'href' => $canvas_url));
  error_log($moods[$picked][0]);
  error_log($picked);
  $feed = array('template_id' => FEED_STORY_1,
                'template_data' => array('mood' => $moods[$picked][0],
                                         'images' => $images,
                                         'mood_src' => $image)
                );

  $data = array('method'=> 'feedStory',
                'content' => array( 'feed'    => $feed,
                                    'next'    => $canvas_url));

} else {
  $data = array('errorCode'=> VALIDATION_ERROR,
                'errorTitle'=> 'No smiley selected',
                'errorMessage'=>'Please select a smiley.');
}

echo json_encode($data);
