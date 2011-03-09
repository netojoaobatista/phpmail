<?php
/**
 * @author		João Batista Neto
 * @brief		Exceções IMAP
 * @package		dso.mail.imap.exception
 */

require_once 'dso/mail/exception/MailStateException.php';

/**
 * Exceção de estado de conexão IMAP
 * @ingroup		Exception
 */
class ImapStateException extends MailStateException {
}