<?php
/**
 * Wird geworfen, wenn eine Session schon benutzt wird.
 *
 * @author Uwe L. Korn <uwelk@xhochy.org>
 */
class XYException extends Exception
{
    public function __construct($message, $code = 0)
    {
        parent::__construct($message, $code);
        $this->aTrace = array();
        $this->aVars = array();
    }

	/**
	 * Der Stack des Programms bei Auftritt des Fehlers
	 * 
	 * @type array
	 */
    protected $aTrace;
    
    /**
     * Variablen, die vllt zur Behebung des Fehlers beitragen könnten
     * 
     * @type array 
     */
    protected $aVars;

    /**
     * Fuegt eine Ebene der Exception hinzu
     * Excpetions sollten möglichst spät erst zum Schluss des Scripts fuehren
     * 
     * @author Uwe L. Korn <uwelk@xhochy.org>
     * @param string $sLine
     * @param string $sFile
     * @param string $sFunction
     * @param string $sClass   
     */
    public function AddTrace($sFile, $sLine, $sFunction = '', $sClass = '')
    {
        $this->aTrace[] = array('File' => $sFile, 'Line' =>$sLine,
            'Class' => $sClass, 'Function' => $sFunction);
    }
    
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
     * Gibt aTrace als String aus
     * 
     * @return string
     */
    public function TraceToString()
    {
        $sResult = '';
        for($i = 0; $i < count($this->aTrace); $i++)
        {
        	$sResult.= "\t";	
            $sResult.= $this->aTrace[$i]['File'].':';
            $sResult.= $this->aTrace[$i]['Line'].':';
            if($this->aTrace[$i]['Class'] != '')
                $sResult.= "\t".$this->aTrace[$i]['Class'].'::';
            if($this->aTrace[$i]['Function'] != '')
                $sResult.= $this->aTrace[$i]['Function'];
            $sResult.= "\n";
        }
        return $sResult;
    }
    
    /**
     * Gibt die Debug-Variabeln aus
     * 
     * @return string
     */
    public function VarsToString()
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
    public function SendExcpetionPerMail()
    {
        Global $_CONFIG;
        $oMail = Mail::factory('smtp', $_CONFIG['Mail']);
        $headers = array();
        $headers['From'] = $_CONFIG['Mail']['From'];
        $headers['To'] = $_CONFIG['Mail']['To'];
        $headers['Subject'] = $this->getMailSubject();
        $body = 'Server: '.$_SERVER['HTTP_HOST']."\n";
        $body.= 'System: '.shell_exec('uname -a');
        $body.= 'Sofware: '.$_SERVER["SERVER_SOFTWARE"]."\n";
        $body.= "\n";
        $body.= $this->getMailBody();
        $oMail->send($_CONFIG['Mail']['Recipent'], $headers, $body); 
    }
}
?>
