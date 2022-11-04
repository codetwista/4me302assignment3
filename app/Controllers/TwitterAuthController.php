<?php

namespace App\Controllers;

// Require Twitter OAuth API
require APPPATH . 'Libraries/vendor/autoload.php';
use Abraham\TwitterOAuth\TwitterOAuth;

class TwitterAuthController extends BaseController
{
    private $consumerKey;
    private $consumerSecret;
    private $oauthCallback;
    
    public function __construct()
    {
        $this->consumerKey = getenv('TWITTER_CONSUMER_KEY');
        $this->consumerSecret = getenv('TWITTER_CONSUMER_SECRET');
        $this->oauthCallback = getenv('TWITTER_OAUTH_CALLBACK');
    }
    
    public function index()
    {
        $requestToken = [];
        $requestToken['oauth_token'] = $this->session->oauthToken;
        $requestToken['oauth_token_secret'] = $this->session->oauthTokenSecret;
    
        $oauthToken = $this->request->getVar('oauth_token');
    
        if (isset($oauthToken) && $requestToken['oauth_token'] !== $oauthToken) {
            // Abort! Something is wrong
            return false;
        }
    
        $connection = new TwitterOAuth($this->consumerKey, $this->consumerSecret, $requestToken['oauth_token'],
            $requestToken['oauth_token_secret']);
    
        if (! $this->request->getVar('oauth_verifier')) {
            return redirect()->to(base_url('login'));
        }
        $accessToken = $connection->oauth("oauth/access_token", [
            "oauth_verifier" => $this->request->getVar('oauth_verifier')
        ]);
    
        $this->session->set('accessToken', $accessToken);
    
        $twitterAccessToken = $this->session->accessToken;
    
        $connection = new TwitterOAuth($this->consumerKey, $this->consumerSecret, $twitterAccessToken['oauth_token'],
            $twitterAccessToken['oauth_token_secret']);
    
        $twitterProfile = $connection->get('account/verify_credentials', [
            'tweet_mode' => 'extended', 'include_entities' => 'true'
        ]);
        // print_r($user);
        
        if ($user = $this->db->table('user, role')->where('user.username', $twitterProfile->screen_name)->where('user.Role_IDrole = role.type')->get()->getRow()) {
            // Save user to session
            $this->session->set('userID', $user->userID);
            $this->session->set('username', $user->username);
            $this->session->set('email', $user->email);
            $this->session->set('profile', $user->name);
        
            // Redirect user to profile page
            return redirect()->to(base_url($this->session->profile));
        }
        
        return false;
    }
    
    public function login()
    {
        $this->session->remove('oauthToken');
        $this->session->remove('oauthTokenSecret');
        $this->session->remove('twitterAccessToken');
    
        //
        $connection = new TwitterOAuth($this->consumerKey, $this->consumerSecret);
    
        $requestToken = $connection->oauth('oauth/request_token', [
            'oauth_callback' => base_url($this->oauthCallback)
        ]);
    
        $this->session->set('oauthToken', $requestToken['oauth_token']);
        $this->session->set('oauthTokenSecret', $requestToken['oauth_token_secret']);
    
        $this->authorizeURL = $connection->url('oauth/authorize', [
            'oauth_token' => $requestToken['oauth_token']
        ]);
    
        if ($this->session->has('oauthToken')) {
            return redirect()->to($this->authorizeURL);
        }
        
        return false;
    }
}
