<?php

class ImapWrapperMailBox
{

    private $connection;
    private $hostSting;
    private $mailboxName;

    public function __construct($connection, $hostSting, $mailBox) {
        $this->connection = $connection;
        $this->hostSting = $hostSting;
        $this->mailboxName = $mailBox;
    }

    public function getCurrentMailBoxInfo() {
        return imap_mailboxmsginfo($this->connection);
    }

    public function getHostString() {
        return $this->hostSting;
    }

    public function createMailbox($newMailbox) {
        return @imap_createmailbox($this->connection, $newMailbox);
    }

    public function deleteMailbox() {
        
    }

    public function changeMailbox($mailbox, $short = false) {
        return @imap_reopen($this->connection, $short ? $this->hostSting . $mailbox : $mailbox);
    }

    public function getStatusOfMailbox($mailbox, $short = false, $flag = SA_ALL) {
        return imap_status($this->connection, $short ? $this->hostSting . $mailbox : $mailbox, $flag);
    }

    public function getMailBoxes($querie = '*') {
        return imap_list($this->connection, $this->hostSting, $querie);
    }

}