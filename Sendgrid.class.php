<?php
	class Sendgrid {

    private $params = array();
    
    function __construct()
    {
      $this->credenciales();
    }
    function sendRawEmail($to, $sender, $message, $subject, $attachements = array())
    {
      $url = 'http://sendgrid.com/';
      
      $this->to($to)
      ->subject($subject)
      ->plain_message($message)
      ->from($sender)
      ->respuesta('')
      ->code_response('');

      $request =  $url.'api/mail.send.json';

      // Generate curl request
      $session = curl_init($request);
      // Tell curl to use HTTP POST
      curl_setopt ($session, CURLOPT_POST, true);
      // Tell curl that this is the body of the POST
      curl_setopt ($session, CURLOPT_POSTFIELDS, $this->params);
      // Tell curl not to return headers, but do return the response
      curl_setopt($session, CURLOPT_HEADER, false);
      curl_setopt($session, CURLOPT_RETURNTRANSFER, true);

      // obtain response
      $response = curl_exec($session);
      
      $http_code = curl_getinfo($session, CURLINFO_HTTP_CODE);
      
      curl_close($session);

      $this->respuesta($response);
      $this->code_response($http_code);

      // do some checking to make sure it sent
      if($http_code !== 200)
        //return $http_code;
        return array(false, $this->params);
      else
        return array(true, "Message is Send OK");
    }    
    
    function to($to)
    {
      $this->params['to'] = $to;
      return $this;
    }
      
    function subject($subject)
    {
      $this->params['subject'] = $subject;
      return $this;
    }

    function html_message($html)
    {
      $this->params['html'] = $html;
      return $this;
    }

    function plain_message($msg)
    {
      $this->params['text'] = $msg;
      return $this;
    }
    
    function from($from)
    {
      $this->params['from'] = $from;
      return $this;
    }    
    
    function respuesta($respuesta)
    {
      $this->params['response'] = $respuesta;
      return $this;
    }

    function code_response($codigo_rta)
    {
      $this->params['codigo_rta'] = $codigo_rta;
      return $this;
    }
    
    /**
	 * Funcion que iniciliza las credenciales del servicio
	 * @param  array $credenciales array con las credenciales 
	 * para validacion de cuanta postmark
	 */

    public function credenciales(){
      $this->params['api_user'] = 'solatipruebas';
      $this->params['api_key'] = 'solati123';
    }
    
    
    /**
     * Funcion que verifica si un string es un email valido
     * @param  string  $email String que se desea veriricar
     * @return $valid         True si es valido, false en otro caso
    */
    public function _isEmail($email){
      return eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email);
    }  
  }
