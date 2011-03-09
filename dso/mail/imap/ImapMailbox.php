<?php
/**
 * @author		João Batista Neto
 * @brief		Conexão de correio IMAP
 * @package		dso.mail.imap
 */

require_once 'dso/mail/imap/Imap.php';
require_once 'dso/mail/MailBox.php';

/**
 * Implementação de uma caixa de correio IMAP
 * @ingroup		IMAP
 */
class ImapMailbox implements MailBox {
	/**
	 * @var	string
	 */
	private $fullname;

	/**
	 * @var	Imap
	 */
	private $imap;

	/**
	 * @var	string
	 */
	private $name;

	/**
	 * Constroi a baixa de correio
	 * @param	Imap $imap
	 * @param	string $fullname
	 * @param	string $ref
	 */
	public function __construct( Imap $imap , $fullname , $ref ) {
		$this->fullname = $fullname;
		$this->imap = $imap;
		$this->name = mb_convert_encoding( imap_utf7_decode( str_replace( $ref , null , $fullname ) ) , 'UTF-8' );

	}

	/**
	 * Recupera o nome completo da caixa de correio
	 * @return	string
	 */
	public function getFullname() {
		return $this->fullname;
	}

	/**
	 * Recupera o nome da caixa de correio
	 * @return	string
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * Abre a caixa de correio
	 * @throws	ImapException Caso algum erro de conexão ocorra
	 */
	public function open() {
		$this->imap->open( $this->fullname );
	}
}