<?php
/**
 * The main file of the XYException Library
 *
 * @package XYException
 * @author Uwe L. Korn <uwelk@xhochy.org>
 */
 
/**
 * The parent class for using the framework. Do not use this class directly!
 *
 * Based on the standard {@link http://php.net/manual/en/language.exceptions.php}
 *
 * @author Uwe L. Korn <uwelk@xhochy.org>
 * @package XYException
 * @see Exception
 */
class XYException extends Exception
{
    public function __construct($message, $code = 0)
    {
        parent::__construct($message, $code);
        
        $this->aVars = array();
    }
    
    /**
     * Variablen, die vllt zur Behebung des Fehlers beitragen könnten
     * 
     * @var array 
     */
    protected $aVars;
    
    /**
     * Fuegt eine Variable den Debug-Informationen hinzu
     * 
     * @param string $sKey
     * @param string $sValue
     */
    public function AddVar($sKey, $sValue)
    {
    	$this->aVars[$sKey] = $sValue;
    }
    
    /**
     * Gibt die Debug-Variabeln aus
     * 
     * @return string
     */
    public function getVarsAsString()
    {
    	$sResult = '';
    	foreach($this->aVars as $sKey=>$sValue)
    	{
    		$sResult.= "\t";
    		$sResult.= $sKey."\t=>\t";
    		$sResult.= $sValue."\n";
       	}
    	return $sResult;
    }

    /**
     * Sendet die Exception per Mail an z.B. den Administrator
     *
     * @author Uwe L. Korn <uwelk@xhochy.org>
     */
    public function SendExceptionPerMail()
    {
        Global $_CONFIG;

        $body = 'Server: '.$_SERVER['HTTP_HOST']."\n";
        $body.= 'System: '.shell_exec('uname -a');
        $body.= 'Sofware: '.$_SERVER["SERVER_SOFTWARE"]."\n";
        $body.= "\n";
        $body.= $this->getMailBody();

        $oMail = new PHPMailer();
        $oMail->Host = $_CONFIG['Errors']['Mail']['Host'];
        $oMail->SMTPAuth = $_CONFIG['Errors']['Mail']['SMTPAuth'];
        $oMail->Username = $_CONFIG['Errors']['Mail']['Username'];
        $oMail->Password = $_CONFIG['Errors']['Mail']['Password'];
        $oMail->From = $_CONFIG['Errors']['Mail']['From'];
        $oMail->FromName = $_CONFIG['Errors']['Mail']['FromName'];
        $oMail->AddAddress($_CONFIG['Errors']['Mail']['To']);
        $oMail->IsHTML(false);
        $oMail->Subject = $this->getMailSubject();
        $oMail->Body = $body;
        $oMail->Send();
    }

    /**
     * Gets the Subject of the Message
     *
     * @abstract
     * @author Uwe L. Korn <uwelk@xhochy.org>
     * @return string
     */
    public function getMailSubject()
    {
        $aTrace = $this->getTrace();
        return __CLASS__.' in file '.$aTrace[1]['file']
            .' at line '.$aTrace[1]['line'];
    }

    /**
     * Gets the main bod of the Message
     * 
     * @abstract
     * @author Uwe L. Korn <uwelk@xhochy.org>
     * @return string
     */
    public function getMailBody()
   {
        $aTrace = $this->getTrace();
        $sResult = __CLASS__.' in file '.$aTrace[1]['file']
            .' at line '.$aTrace[1]['line']."\n";
        $sResult.= "\nTrace:\n";
        $sResult.= $this->getTraceAsString();
        $sResult.= "\nVars:\n";
        $sResult.= $this->getVarsAsString();
        return $sResult;
    }
}