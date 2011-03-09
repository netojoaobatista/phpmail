<?php
/**
 * @author		João Batista Neto
 * @brief		Classes e objetos relacionados com caixa e conexão com servidor de correio
 * @package		dso.mail
 */

require_once 'dso/mail/MailContext.php';

/**
 * Estado de uma conexão com um servidor de correio
 * @interface	MailState
 * @ingroup		Mail
 */
interface MailState {
	/**
	 * Fecha uma conexão previamente aberta
	 * @param	MailContext $context Contexto da conexão
	 * @throws	MailStateException Se o estado atual não implementar o fechamento
	 * @throws	MailException Caso ocorra algum erro ao fechar a conexão
	 */
	public function close( MailContext $context );

	/**
	 * Recupera o conteúdo de uma mensagem
	 * @param	MailContext $context Contexto da conexão
	 * @param	Message $message
	 * @return	Message A própria mensagem
	 * @throws	MailStateException Caso o estado do objeto não implemente abertura
	 * @throws	MailException Caso não seja possível recuperar o conteúdo da mensagem
	 */
	public function fetch( MailContext $context , Message $message );

	/**
	 * Recupera um Iterator de caixas de correio
	 * @param	MailContext $context Contexto da conexão
	 * @param	string $pattern Padrão de busca
	 * @return	MailboxIterator
	 * @throws	MailStateException Se o estado atual não implementar o fechamento
	 * @throws	MailException Caso ocorra algum erro ao recuperar a lista de caixas de correio
	 */
	public function getMailboxIterator( MailContext $context , $pattern = '*' );

	/**
	 * Recupera um Iterator de mensagens de correio
	 * @param	MailContext $context Contexto da conexão
	 * @param	string $pattern Padrão de busca
	 * @return	MessageIterator
	 * @throws	MailStateException Se o estado atual não implementar o fechamento
	 * @throws	MailException Caso ocorra algum erro ao recuperar a lista de caixas de correio
	 */
	public function getMessageIterator( MailContext $context , $pattern = 'ALL' );

	/**
	 * Abre uma conexão com uma caixa de correio
	 * @param	MailContext $context Contexto da conexão
	 * @param	string $mailbox Parâmetros de conexão
	 * @param	string $username Nome do usuário
	 * @param	string $password Senha do usuário
	 * @throws	MailStateException Se o estado atual não implementar abertura
	 * @throws	MailException Caso ocorra algum erro ao abrir a conexão
	 */
	public function open( MailContext $context , $mailbox , $username = null , $password = null );
}