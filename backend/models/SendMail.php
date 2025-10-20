<?php
namespace backend\models;

use Yii;
use yii\base\Model;
use backend\models\Configure;

class SendMail extends Model
{
	public $content;
	public $subject;
	public $email_list;

	public function rules()
	{
		return [
			['content, subject, email_list', 'required'],
			['subject, email_list, content', 'safe'],
		];
	}

	function send()
	{
		require 'mailgun/autoload.php';
		$conf = Configure::getConfigure();

		# Instantiate the client.
		$client = new \GuzzleHttp\Client(['verify' => false]);
		$adapter = new \Http\Adapter\Guzzle6\Client($client);
		$mgClient = new \Mailgun\Mailgun($conf->mailgun_key, $adapter);
		$domain = $conf->mailgun_domain;

		$list_email=explode(',', $this->email_list);
		# Make the call to the client.
		if (count($list_email) == 1) {
			return $mgClient->sendMessage($domain, [
					'from'    => $conf->sender_label.' <'.$conf->email_label.'>',
					'to'      => $list_email[0],
					'subject' => $this->subject,
					'html'    => $this->content
			]);
		} else {
			//$bcc_email = explode(',',$list_email);
			return $mgClient->sendMessage($domain, [
					'from'    => $conf->sender_label.' <'.$conf->email_label.'>',
					'to'      => $list_email[0],
					'bcc'	  => $list_email,
					'subject' => $this->subject,
					'html'    => $this->content
			]);
		}
	}
}
