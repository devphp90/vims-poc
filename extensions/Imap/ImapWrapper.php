<?php

include 'ImapWrapperEmails.php';
include 'ImapWrapperEmail.php';
include 'ImapWrapperMailBox.php';

class ImapWrapper
{

    private $connection;
    private $imapWrapperEmails;
    private $imapWrapperMailBox;
    private $hostString;

    public function __construct($hostString, $username, $password, $mailbox='INBOX') {
        $this->connection = imap_open($hostString . $mailbox, $username, $password);
        $this->imapWrapperEmails = new ImapWrapperEmails($this->connection);
        $this->imapWrapperMailBox = new ImapWrapperMailBox($this->connection, $hostString, $mailbox);
    }

    /**
     * @return ImapWrapperEmails
     */
    public function email() {
        return $this->imapWrapperEmails;
    }

    /**
     * @return ImapWrapperMailBox
     */
    public function mailBox() {
        return $this->imapWrapperMailBox;
    }

}