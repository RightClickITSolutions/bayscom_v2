<?php 

namespace App;

class PostStatusHelper
{
    public $post_status = 'NONE';
    public $post_status_message = '';

    public function success($message="SUCCESSFUL")
    {
        $this->post_status = 'SUCCESS';
        $this->post_status_message = $message;
    }
    public function failed($message="FAILED")
    {
        $this->post_status = 'FAILED';
        $this->post_status_message = $message;
    }
}