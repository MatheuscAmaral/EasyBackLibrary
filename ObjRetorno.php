<?php

class Response
{
    private $status = 200;
    private $message = null;
    private $data = null;
    private $messageErro = null;
    private $sql = null;

    public function setStatus(int $_status): void
    {
        $this->status = $_status;
    }

    public function setMessage(string $_message): void
    {
        $this->message = $_message;
    }

    public function setData(mixed $_data): void
    {
        $this->data = $_data;
    }

    public function setMessageErro(string $_messageErro): void
    {
        $this->messageErro = $_messageErro;
    }

    public function setSql(string $_sql): void
    {
        $this->sql = $_sql;
    }

    public function jsonResponse()
    {

        $httpsStatus = '';

        switch ($this->status) {
            case 200:
                $httpsStatus = 'OK';
                break;
            case 400:
                $httpsStatus = 'Bad Request';
                break;
            case 500:
                $httpsStatus = 'Internal Server Error';
                break;
            default:
                $httpsStatus = 'Cara a que ponto chegamos!!???';
                break;
        }

        http_response_code($this->status);

        $Obj = [
            'HTTP' => $httpsStatus,
            'status' => $this->status,
            'message' => $this->message,
            'data' => $this->data
        ];

        if (($this->messageErro != null) || ($this->sql != null)) {
            $Obj['messageErro'] = $this->messageErro;
            $Obj['sql'] = $this->sql;
        }

        return json_encode($Obj);
    }
}
