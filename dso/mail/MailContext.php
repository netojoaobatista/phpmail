<?php
/**
 * @author		João Batista Neto
 * @brief		Classes e objetos relacionados com caixa e conexão com servidor de correio
 * @package		dso.mail
 */

/**
 * Contexto de conexão com um servidor de correio
 * @interface	Mailcontext
 * @ingroup		Mail
 */
interface MailContext {
	/**
	 * Modifica o estado atual do objeto de contexto
	 * @param	MailState $mailState O novo estado do objeto
	 */
	public function changeState( MailState $mailState );

	/**
	 * Fecha uma conexão com uma caixa de correio previamente aberta
	 * @throws	MailStateException Caso o estado do objeto não implemente abertura
	 * @throws	MailException Caso algum erro de conexão ocorra
	 */
	public function close();

	/**
	 * Recupera o conteúdo de uma mensagem
	 * @param	Message $message
	 * @return	Message A própria mensagem
	 * @throws	MailStateException Caso o estado do objeto não implemente abertura
	 * @throws	MailException Caso não seja possível recuperar o conteúdo da mensagem
	 */
	public function fetch( Message $message );

	/**
	 * Recupera um Iterator de caixas de correio
	 * @param	string $pattern Padrão de busca
	 * @return	MailboxIterator
	 * @throws	MailStateException Se o estado atual não implementar o fechamento
	 * @throws	MailException Caso ocorra algum erro ao recuperar a lista de caixas de correio
	 */
	public function getMailboxIterator( $pattern = '*' );

	/**
	 * Recupera um Iterator com as mensagens de correio
	 * @param	string $pattern Padrão de busca
	 * @return	MessageIterator
	 * @throws	MailStateException Se o estado atual não implementar o fechamento
	 * @throws	MailException Caso ocorra algum erro ao recuperar a lista de mensagens de correio
	 */
	public function getMessageIterator( $pattern = 'ALL' );

	/**
	 * Abre uma conexão com uma caixa de correio
	 * @param	string $mailbox Caixa de correio que será aberta
	 * @param	string $username Nome do usuário
	 * @param	string $password Senha do usuário
	 * @throws	MailStateException Caso o estado do objeto não implemente abertura
	 * @throws	MailException Caso algum erro de conexão ocorra
	 */
	public function open( $mailbox , $username = null , $password = null );
}