<?php

class ImapWrapperEmail
{
    const TYPE_TEXT_HTML = 1, TYPE_TEXT_PLAIN = 2;

    private $header;
    private $connection;
    private $message_number;
    private $body = null;
    private $uid = null;

    public function __construct($connection, $message_number) {
        $this->connection = $connection;
        $this->message_number = $message_number;
        $this->header = imap_header($connection, $message_number);
    }

    public function getAttachmentByName($name) {
        return $this->extractAttachmentsBySettings(array('byName' => $name));
    }

    public function getAllAttachments($nameOnly= false) {
        return $this->extractAttachmentsBySettings(array('nameOnly' => $nameOnly));
    }

    public function getToAddresses() {
        return $this->header->to;
    }

    public function getFromAddress() {
        return $this->header->from;
    }

    public function getReplyToAddress() {
        return $this->header->reply_to;
    }

    public function getSenderAddress() {
        return $this->header->sender;
    }

    public function getTimeInt() {
        return $this->header->udate;
    }

    public function getSize() {
        return $this->header->Size;
    }

    public function getMailDate() {
        return $this->header->MailDate;
    }

    public function getSubject() {
        return $this->header->subject;
    }

    public function getMessageId() {
        return $this->header->message_id;
    }

    public function getMsgno() {
        return trim($this->header->Msgno);
    }

    public function getUid($recache = false) {
        return!empty($this->uid) && !$recache ? $this->uid : $this->uid = imap_uid($this->connection, trim($this->header->Msgno));
    }

    public function getRecent() {
        return trim($this->header->Recent);
    }

    public function getUnseen() {
        return trim($this->header->Unseen);
    }

    public function getFlagged() {
        return trim($this->header->Flagged);
    }

    public function getAnswered() {
        return trim($this->header->Answered);
    }

    public function getDeleted() {
        return trim($this->header->Deleted);
    }

    public function getDraft() {
        return trim($this->header->Draft);
    }

    public function getHeaderInformation() {
        return $this->header;
    }

    public function getBody() {
        if (!empty($this->body)) {
            return $this->body;
        } else {
            $body = array();
            $body['body'] = $this->getPart($connection, $message_number, "TEXT/HTML");
            $body['type'] = ImapWrapperEmail::TYPE_TEXT_HTML;
            if (empty($body['body'])) {
                $body['body'] = $this->getPart($connection, $message_number, "TEXT/PLAIN");
                $body['type'] = ImapWrapperEmail::TYPE_TEXT_PLAIN;
            }
            return $this->body = $body;
        }
    }

    private function extractAttachmentsBySettings($settings = array()) {
        $attachments = array();
        $structure = imap_fetchstructure($this->connection, $this->message_number);

        if (isset($structure->parts) && count($structure->parts)) {
            $count = 0;
            $filefound = false;
            for ($i = 0; $i < count($structure->parts); $i++) {
                $continueLoop = false;
                $attachments[$count] = array(
                    'is_attachment' => false,
                    'filename' => '',
                    'name' => '',
                    'attachment' => '',
                    'id' => false
                );
                if (!empty($structure->parts[$i]->id)) {
                    $attachments[$count]['id'] = $structure->parts[$i]->id;
                }
                if ($structure->parts[$i]->ifdparameters) {
                    foreach ($structure->parts[$i]->dparameters as $object) {
                        if (strtolower($object->attribute) == 'filename') {
                            $attachments[$count]['is_attachment'] = true;
                            $attachments[$count]['filename'] = $object->value;
                        }
                    }
                }
                if ($structure->parts[$i]->ifparameters) {
                    foreach ($structure->parts[$i]->parameters as $object) {
                        if (strtolower($object->attribute) == 'name') {
                            $attachments[$count]['is_attachment'] = true;
                            $attachments[$count]['name'] = $object->value;
                            if (!empty($settings['byName'])) {
                                if ($settings['byName'] == $object->value) {
                                    $filefound = true;
                                    break;
                                } else {
                                    unset($attachments[$count]);
                                    $continueLoop = true;
                                }
                            }
                        }
                    }
                }
                if ($continueLoop) {
                    continue;
                }

                if ($attachments[$count]['is_attachment'] && empty($settings['nameOnly'])) {
                    $attachments[$count]['attachment'] = imap_fetchbody($this->connection, $this->message_number, $i + 1);
                    if ($structure->parts[$i]->encoding == 3) { // 3 = BASE64
                        $attachments[$count]['attachment'] = base64_decode($attachments[$count]['attachment']);
                    } elseif ($structure->parts[$i]->encoding == 4) { // 4 = QUOTED-PRINTABLE
                        $attachments[$count]['attachment'] = quoted_printable_decode($attachments[$count]['attachment']);
                    }
                }

                if ($attachments[$count]['is_attachment']) {
                    $count++;
                } else {
                    unset($attachments[$count]);
                }
                if ($filefound) {
                    break;
                }
            }
        }

        return $attachments;
    }

    private function get_mime_type(&$structure) {
        $primary_mime_type = array("TEXT", "MULTIPART", "MESSAGE", "APPLICATION", "AUDIO", "IMAGE", "VIDEO", "OTHER");
        if ($structure->subtype) {
            return $primary_mime_type[(int) $structure->type] . '/' . $structure->subtype;
        }
        return "TEXT/PLAIN";
    }

    private function getPart($stream, $msg_number, $mime_type, $structure = false, $part_number = false) {
        if (!$structure) {
            $structure = imap_fetchstructure($stream, $msg_number);
        }
        if ($structure) {
            if ($mime_type == $this->get_mime_type($structure)) {
                if (!$part_number) {
                    $part_number = "1";
                }
                $text = imap_fetchbody($stream, $msg_number, $part_number);
                if ($structure->encoding == 3) {
                    return imap_base64($text);
                } else if ($structure->encoding == 4) {
                    return imap_qprint($text);
                } else {
                    return $text;
                }
            }
            if ($structure->type == 1) { /* multipart */
                while (list($index, $sub_structure) = each($structure->parts)) {
                    $prefix = '';
                    if ($part_number) {
                        $prefix = $part_number . '.';
                    }
                    $data = $this->getPart($stream, $msg_number, $mime_type, $sub_structure, $prefix . ($index + 1));
                    if ($data) {
                        return $data;
                    }
                }
            }
        }
        return false;
    }

}