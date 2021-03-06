<?php
namespace Foundation\Form\Validator;

/**
 * Check to see if the captcha was valid
 * 
 * @package Foundation\form\validator
 * @author  Jon Johnson <jon.johnson@ucsf.edu>
 * @license BSD http://jazzee.org/license.html
 */
class Captcha extends AbstractValidator
{
    /**
     * The verification server
     */

    const VERIFY_SERVER = 'www.google.com';

    /**
     * Use ValidateNull becuase the actual input for the element is not what is important
     * @param \Foundation\Form\Input $input
     */
    public function validateNull(\Foundation\Form\Input $input)
    {
        //discard empty submissions
        if ($input->get('recaptcha_challenge_field') == null or
            \strlen($input->get('recaptcha_challenge_field')) == 0 or
            $input->get('recaptcha_response_field') == null or
            \strlen($input->get('recaptcha_response_field')) == 0
        ) {
            $this->e->errorString = 'incorrect-captcha-sol';
            $this->addError('');

            return false;
        }

        $response = $this->httpPost(
            self::VERIFY_SERVER,
            "/recaptcha/api/verify",
            array(
                'privatekey' => $this->ruleSet,
                'remoteip' => $_SERVER['REMOTE_ADDR'],
                'challenge' => $input->get('recaptcha_challenge_field'),
                'response' => $input->get('recaptcha_response_field')
            )
        );

        $answers = explode("\n", $response[1]);
        if (trim($answers[0]) == 'false') {
            $this->e->errorString = $answers[1];
            $this->addError('');

            return false;
        }

        return true;
    }

    /**
     * Encodes the given data into a query string format
     * @param $data - array of string elements to be encoded
     * @return string - encoded request
     */
    private function qsencode($data)
    {
        $req = "";
        foreach ($data as $key => $value) {
            $req .= $key . '=' . \urlencode(\stripslashes($value)) . '&';
        }
        // Cut the last '&'
        $req = substr($req, 0, \strlen($req) - 1);

        return $req;
    }

    /**
     * Submits an HTTP POST to a reCAPTCHA server
     * @param string $host
     * @param string $path
     * @param array $data
     * @param int port
     * @return array response
     */
    private function httpPost($host, $path, $data, $port = 80)
    {
        $req = $this->qsencode($data);

        $httpRequest = "POST $path HTTP/1.0\r\n";
        $httpRequest .= "Host: $host\r\n";
        $httpRequest .= "Content-Type: application/x-www-form-urlencoded;\r\n";
        $httpRequest .= "Content-Length: " . \strlen($req) . "\r\n";
        $httpRequest .= "User-Agent: reCAPTCHA/PHP\r\n";
        $httpRequest .= "\r\n";
        $httpRequest .= $req;

        $response = '';
        if (false == ($fs = @\fsockopen($host, $port, $errno, $errstr, 10))) {
            throw new \Foundation\Exception('reCaptcha could not open network socket');
        }

        \fwrite($fs, $httpRequest);

        while (!\feof($fs)) {
            $response .= \fgets($fs, 1160); // One TCP-IP packet
        }
        \fclose($fs);
        $response = \explode("\r\n\r\n", $response, 2);

        return $response;
    }
}
