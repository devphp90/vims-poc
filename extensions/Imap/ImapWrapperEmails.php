<?php

class ImapWrapperEmails
{

    private $connection;

    public function __construct($connection) {
        $this->connection = $connection;
    }

    public function getNewMail() {
        $emails = imap_search($this->connection, 'NEW');
        return $this->getEmails($emails);
    }

    public function getAllMail() {
        $emails = imap_search($this->connection, 'ALL');
        return $this->getEmails($emails);
    }
    
    public function searchMail($params=array()) {
    	// Search based on params
    	$criteria = array();
    	
    	foreach($params as $key => $value) {
    		if(!$value) {
    			continue;
    		}
    		$criteria[$key] = strtoupper($key) . ' "'.$value.'"';
    	}
    	
    	// Make sure we have some
    	if(!count($criteria)) {
    		$criteria[] = 'ALL';
    	}
    	
    	$emails = imap_search($this->connection, implode(' ', $criteria));
        return $this->getEmails($emails);
    }

    public function getEmailByUid($uid) {
        $emailnr = @imap_msgno($this->connection, $uid);
        return $emailnr == 0 ? false : new ImapWrapperEmail($this->connection, $emailnr);
    }

    private function getEmails($emails) {
        $wrappers = array();
        if (!empty($emails)) {
            foreach ($emails as $emailnr) {
                $wrappers[] = new ImapWrapperEmail($this->connection, $emailnr);
            }
        }
        return $wrappers;
    }

}