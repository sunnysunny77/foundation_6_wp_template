<ul>
    <?php wp_list_comments(); ?>
  </ul>

  <?php comment_form(

    $args = array(
      'id_form'           => 'commentform',
      'id_submit'         => 'commentsubmit',
      'title_reply'       => __('Leave a Comment', 'wpt'),
      'title_reply_to'    => __('Leave a Comment to %s', 'wpt'),
      'cancel_reply_link' => __('Cancel Commnet', 'wpt'),
      'comment_field' =>  '<p><textarea placeholder="Start typing..." aria-required="true"></textarea></p>',
      'comment_notes_after' => '<p>' .
        __('You may use these <abbr title="HyperText Markup Language">HTML</abbr> tags and attributes:', 'wpt') .
        '</p><div>' . allowed_tags() . '</div>'
    )
  );
  ?>