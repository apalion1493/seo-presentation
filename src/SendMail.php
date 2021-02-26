<?php
class SendMail {

    private $_to      = 'seo@webdelo.org';
    private $_subject = 'Новое обращение с формы на сайте ';
    private $_message = '';

    private $_request;

    private $_errors     = array();
    private $_validation = array('name', 'email', 'message',);

    /**
     * SendMail constructor.
     *
     * @param $request
     */
    public function __construct( $request )
    {
        $this->_subject .= $_SERVER['HTTP_HOST'];
        $this->_request  = $request;
        $this->validate();
    }

    public function setTo( $to )
    {
        $this->_to = $to;
        return $this;
    }

    public function setSubject( $subject )
    {
        $this->_subject = $subject;
        return $this;
    }

    public function setMessage( $message )
    {
        $this->_message = $message;
        return $this;
    }

    public function validate()
    {
        foreach ($this->_validation as $item) {
            if ( empty($this->_request[$item]) ) {
                $this->_errors[] = array( $item => 'Field \''.$item.'\' is required' );
            }
        }
    }

    /**
     * @return array|bool
     */
    public function send()
    {
        if ( sizeof($this->_errors) > 0 ) {
            return $this->_errors;
        }

        $this->_message  = "
            Имя: ".$this->_request['name']." \r\n
            E-mail: ".$this->_request['email']." \r\n
            Сообщение: ".$this->_request['message']." \r\n
        ";

        return mail($this->_to, $this->_subject, $this->_message);
    }

}