<?php
/**
 * @author		João Batista Neto
 * @brief		Classes e objetos relacionados com caixa e conexão com servidor de correio
 * @package		dso.mail
 */

/**
 * Interface para uma mensagem de correio
 * @interface	Message
 * @ingroup		Mail
 */
interface Message {
	/**
	 * Recupera o conteúdo da mensagem
	 */
	public function fetch();

	/**
	 * Recupera o conteúdo da mensagem de um subtipo
	 * @param	string $subtype
	 */
	public function getBody( $subtype = null );

	/**
	 * Recupera a data da mensagem
	 * @return	string
	 */
	public function getDate();

	/**
	 * Recupera o remetente da mensagem
	 * @return	string
	 */
	public function getFrom();

	/**
	 * Recupera o conjunto de cabeçalhos da mensagem
	 * @return	string
	 */
	public function getHeaders();

	/**
	 * Recupera o conjunto de cabeçalhos interpretados segundo a RFC-822
	 * @return	stdClass
	 */
	public function getRFC822Headers();

	/**
	 * Recupera o assunto da mensagem
	 * @return	string
	 */
	public function getSubject();

	/**
	 * Recupera o destinatário da mensagem
	 * @return	string
	 */
	public function getTo();

	/**
	 * Recupera o ID da mensagem
	 * @return	string
	 */
	public function getMessageId();

	/**
	 * Recupera o UID da mensagem
	 * @return	integer
	 */
	public function getUID();

	/**
	 * Verifica se a mensagem já foi vista anteriormente
	 * @return	boolean
	 */
	public function hasSeen();

	/**
	 * Verifica se a mensagem já foi respondida
	 * @return	boolean
	 */
	public function isAnswered();

	/**
	 * Verifica se a mensagem foi deletada
	 * @return	boolean
	 */
	public function isDeleted();

	/**
	 * Verifica se a mensagem é um rascunho
	 * @return	boolean
	 */
	public function isDraft();

	/**
	 * Verifica se a mensagem possui alguma marcação
	 * @return	boolean
	 */
	public function isFlagged();

	/**
	 * Verifica se é uma mensagem recente
	 * @return	boolean
	 */
	public function isRecent();

	/**
	 * Define o conteúdo da mensagem segundo seu subtipo
	 * @param	string $subtype O subtipo da mensagem
	 * @param	string $content O conteúdo da mensagem
	 */
	public function setContent( $subtype , $content );

	/**
	 * Define os cabeçalhos da mensagem
	 * @param	string $headers
	 */
	public function setHeaders( $headers );

	/**
	 * Define o overview da mensagem
	 * @param	array $overview
	 */
	public function setOverview( array $overview );
}