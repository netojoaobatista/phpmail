<?php
/**
 * @author		João Batista Neto
 * @brief		Conexão de correio IMAP
 * @package		dso.mail.imap
 */

require_once 'dso/mail/Message.php';

/**
 * Implementação de uma mensagem de correio IMAP
 * @ingroup		IMAP
 */
class ImapMessage implements Message {
	/**
	 * @var	array
	 */
	private $content;

	/**
	 * @var	string
	 */
	private $headers;

	/**
	 * @var	IMAP
	 */
	private $imap;

	/**
	 * @var	array
	 */
	private $overview;

	/**
	 * @var	integer
	 */
	private $uid;

	public function __construct( Imap $imap , $uid ) {
		$this->content = array();
		$this->imap = $imap;
		$this->uid = $uid;
		$this->overview = array();
	}

	/**
	 * Recupera o conteúdo da mensagem
	 */
	public function fetch() {
		$this->imap->fetch( $this );
	}

	/**
	 * Recupera o conteúdo da mensagem de um subtipo
	 * @param	string $subtype
	 */
	public function getBody( $subtype = null ) {
		if ( $subtype == null ) {
			$subtype = current( array_keys( $this->content ) );
		}

		if ( isset( $this->content[ $subtype ] ) ) {
			$content = $this->content[ $subtype ];

			return mb_convert_encoding( $content , 'UTF-8' );
		} else {
			throw new UnexpectedValueException( 'Subtipo inexistente' );
		}
	}

	/**
	 * Recupera a data da mensagem
	 * @return	string
	 */
	public function getDate() {
		return isset( $this->overview[ 'date' ] ) ? (string) $this->overview[ 'date' ] : null;
	}

	/**
	 * Recupera o remetente da mensagem
	 * @return	string
	 */
	public function getFrom() {
		return isset( $this->overview[ 'from' ] ) ? (string) $this->overview[ 'from' ] : null;
	}

	/**
	 * Recupera o conjunto de cabeçalhos da mensagem
	 * @return	string
	 */
	public function getHeaders() {
		return $this->headers;
	}

	/**
	 * Recupera o conjunto de cabeçalhos interpretados segundo a RFC-822
	 * @return	stdClass
	 */
	public function getRFC822Headers() {
		return (object) $this->parseHeaders( (array) imap_rfc822_parse_headers( $this->headers ) );
	}

	/**
	 * Recupera o assunto da mensagem
	 * @return	string
	 */
	public function getSubject() {
		return isset( $this->overview[ 'subject' ] ) ? (string) $this->overview[ 'subject' ] : null;
	}

	/**
	 * Recupera o destinatário da mensagem
	 * @return	string
	 */
	public function getTo() {
		return isset( $this->overview[ 'to' ] ) ? (string) $this->overview[ 'to' ] : null;
	}

	/**
	 * Recupera o ID da mensagem
	 * @return	string
	 */
	public function getMessageId() {
		return isset( $this->overview[ 'message_id' ] ) ? (string) $this->overview[ 'message_id' ] : null;

	}

	/**
	 * Recupera o UID da mensagem
	 * @return	integer
	 */
	public function getUID() {
		return $this->uid;
	}

	/**
	 * Verifica se a mensagem já foi vista anteriormente
	 * @return	boolean
	 */
	public function hasSeen() {
		return isset( $this->overview[ 'seen' ] ) ? (bool) $this->overview[ 'seen' ] : false;
	}

	/**
	 * Verifica se a mensagem já foi respondida
	 * @return	boolean
	 */
	public function isAnswered() {
		return isset( $this->overview[ 'answered' ] ) ? (bool) $this->overview[ 'answered' ] : false;
	}

	/**
	 * Verifica se a mensagem foi deletada
	 * @return	boolean
	 */
	public function isDeleted() {
		return isset( $this->overview[ 'deleted' ] ) ? (bool) $this->overview[ 'deleted' ] : false;
	}

	/**
	 * Verifica se a mensagem é um rascunho
	 * @return	boolean
	 */
	public function isDraft() {
		return isset( $this->overview[ 'draft' ] ) ? (bool) $this->overview[ 'draft' ] : false;
	}

	/**
	 * Verifica se a mensagem possui alguma marcação
	 * @return	boolean
	 */
	public function isFlagged() {
		return isset( $this->overview[ 'flagged' ] ) ? (bool) $this->overview[ 'flagged' ] : false;
	}

	/**
	 * Verifica se é uma mensagem recente
	 * @return	boolean
	 */
	public function isRecent() {
		return isset( $this->overview[ 'recent' ] ) ? (bool) $this->overview[ 'recent' ] : false;
	}

	/**
	 * Decodifica a lista de cabeçalhos da mensagem
	 * @param	array $headers
	 * @return	array
	 */
	private function parseHeaders( array $headers ) {
		foreach ( $headers as $field => $value ) {
			$mimeHeader = current( imap_mime_header_decode( $value ) );

			if ( $mimeHeader->charset != 'default' && $mimeHeader->charset != 'UTF-8' ) {
				$headers[ $field ] = mb_convert_encoding( $mimeHeader->text , 'UTF-8' , $mimeHeader->charset );
			}
		}

		return $headers;
	}

	/**
	 * Define o conteúdo da mensagem segundo seu subtipo
	 * @param	string $subtype O subtipo da mensagem
	 * @param	string $content O conteúdo da mensagem
	 */
	public function setContent( $subtype , $content ) {
		$this->content[ $subtype ] = $content;
	}

	/**
	 * Define os cabeçalhos da mensagem
	 * @param	string $headers
	 */
	public function setHeaders( $headers ) {
		$this->headers = (string) $headers;
	}

	/**
	 * Define o overview da mensagem
	 * @see		Message::setOverview()
	 */
	public function setOverview( array $overview ) {
		$this->overview = $this->parseHeaders( $overview );
	}
}