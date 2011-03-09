<?php
/**
 * @author		João Batista Neto
 * @brief		Conexão de correio IMAP
 * @package		dso.mail.imap
 */

require_once 'dso/mail/MailContext.php';
require_once 'dso/mail/MailState.php';
require_once 'dso/mail/imap/state/ImapClosedState.php';

/**
 * Implementação de uma conexão com um servidor IMAP para leitura e envio
 * de correio eletrônico
 * @ingroup	IMAP
 */
class Imap implements MailContext {
	/**
	 * @var	MailState
	 */
	private $imapState;

	/**
	 * Constroi o objeto de leitura de caixas de corrio IMAP
	 */
	public function __construct() {
		$this->changeState( new ImapClosedState() );
	}

	/**
	 * Modifica o estado atual do objeto Imap
	 * @param	ImapState $imapState O novo estado do objeto
	 */
	public function changeState( MailState $imapState ) {
		$this->imapState = $imapState;
	}

	/**
	 * Fecha uma conexão com uma caixa de correio IMAP previamente aberta
	 * @throws	ImapStateException Caso o estado do objeto não implemente abertura
	 * @throws	ImapException Caso algum erro de conexão ocorra
	 */
	public function close() {
		$this->imapState->close( $this );
	}

	/**
	 * Recupera o conteúdo de uma mensagem
	 * @param	Message $message
	 * @return	Message A própria mensagem
	 * @throws	MailStateException Caso o estado do objeto não implemente abertura
	 * @throws	MailException Caso não seja possível recuperar o conteúdo da mensagem
	 */
	public function fetch( Message $message ) {
		return $this->imapState->fetch( $this , $message );
	}

	/**
	 * Recupera um Iterator de caixas de correio
	 * @param	Imap $pattern Padrão de busca
	 * @return	MailboxIterator
	 * @throws	ImapStateException Se o estado atual não implementar o fechamento
	 * @throws	ImapException Caso ocorra algum erro ao recuperar a lista de caixas de correio
	 */
	public function getMailboxIterator( $pattern = '*' ) {
		return $this->imapState->getMailboxIterator( $this , $pattern );
	}

	/**
	 * Recupera um Iterator com as mensagens de correio
	 * @param	string $pattern Padrão de busca
	 * @return	MessageIterator
	 * @throws	MailStateException Se o estado atual não implementar o fechamento
	 * @throws	MailException Caso ocorra algum erro ao recuperar a lista de mensagens de correio
	 */
	public function getMessageIterator( $pattern = 'ALL' ) {
		return $this->imapState->getMessageIterator( $this , $pattern );
	}

	/**
	 * Abre uma conexão com uma caixa de correio IMAP
	 * @param	string $mailbox Caixa de correio que será conectada
	 * @param	string $username Nome do usuário
	 * @param	string $password Senha do usuário
	 * @throws	ImapStateException Caso o estado do objeto não implemente abertura
	 * @throws	ImapException Caso algum erro de conexão ocorra
	 */
	public function open( $mailbox , $username = null , $password = null ) {
		$this->imapState->open( $this , $mailbox , $username , $password );
	}
}