<?php
error_reporting(E_ALL);
ini_set("display_errors", true);

class SendPush  
{

    private $credentials = [
        'url'   => 'https://fcm.googleapis.com/fcm/send',
        // 'token' => "AAAAAFq70T8:APA91bFVe5inYE4c5znEVMiqNVneOnVpZyKe6VaWED-CMOnPzBqmQMMMy2K5HM_2ugx_81LySXuDdnJk5dS4LlYCs_UvNvpN6OoVmdfNbER4RA5E9Dlmd0aywPlubGS6MnRHPiSNta-4"
        'token' => 'AAAAQUi716g:APA91bEYSU6namsg8ix3j5hk2sh0Oz2rDF9NuZXCJOZQi_Esd8gAavBOfS_wnveeaa2kHCu9qZIyVPem5K_6EfYbEK-Q1Gr2HzOzfvS2e6QcnaFwn3pdwk-DX7D7pVz1nGtGzK9yUMIW'
    ]; 
    protected $tokens;
    protected $title;
    protected $body;
    protected $click_action;
    protected $client;
 

    public function __construct($tokens, $title, $body, $click_action="", $client="Android")
    {
        $this->tokens = $tokens;
        $this->title  = $title;
        $this->body   = $body;
        $this->click_action = $click_action;
        $this->client = $client;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        try 
        {   
            $requestData = array(
                'title' => $this->title, 
                'body'  => $this->body, 
                'click_action' => $this->click_action
            );
        
            if ($this->client == 'Android')
            {
                $arrayToSend = array(
                    'registration_ids' => (is_array($this->tokens)?$this->tokens:[$this->tokens]), 
                    'priority' => 'high', 
                    // "notification" => $requestData, 
                    'data' => $requestData
                );
            }
            else
            {
               $arrayToSend = array(
                    'to' => (is_array($this->tokens)?$this->tokens:[$this->tokens]), 
                    'priority' => 'high', 
                    'notification' => $requestData
                );
            } 

            $ch = curl_init();
            curl_setopt_array($ch, array(
                CURLOPT_URL        => $this->credentials['url'],
                CURLOPT_HTTPHEADER => array(
                    'Authorization: key=' . $this->credentials['token'],
                    'Content-Type: application/json',
                    'Accept: application/json'
                ),
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => json_encode($arrayToSend),
                CURLINFO_HEADER_OUT => true
            ));

            $result = curl_exec($ch);
            $headerSent = curl_getinfo($ch, CURLINFO_HEADER_OUT);
            curl_close($ch);

            if ($result === FALSE) {
                return ('Curl failed: ' . curl_error($ch));
            }

            return $result;
        } 
        catch (\Exception $e) 
        {
            return $e->getMessage();
        }
    }
}



$push = new SendPush('token', "Push Notification", "Sometext");
$result = $push->handle();
print_r($result);