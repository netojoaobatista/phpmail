<?php
/**
 * @author		João Batista Neto
 * @brief		Estados de conexão IMAP
 * @package		dso.mail.imap.state
 */

require_once 'dso/mail/MailContext.php';
require_once 'dso/mail/MailState.php';
require_once 'dso/mail/imap/exception/ImapException.php';
require_once 'dso/mail/imap/exception/ImapStateException.php';

/**
 * Base para implementação de um estado de conexão IMAP
 * @ingroup		IMAP
 */
abstract class ImapState implements MailState {
	/**
	 * @var	resource
	 */
	protected static $resource;

	/**
	 * Fecha uma conexão IMAP previamente aberta
	 * @param	MailContext $context Contexto da conexão
	 * @throws	ImapStateException Se o estado atual não implementar o fechamento
	 * @throws	ImapException Caso ocorra algum erro ao fechar a conexão
	 */
	public function close( MailContext $context ) {
		throw new ImapStateException( 'O estado atual não implementa fechamento de conexão' );
	}

	/**
	 * Recupera o conteúdo de uma mensagem
	 * @param	MailContext $context Contexto da conexão
	 * @param	Message $message
	 * @return	Message A própria mensagem
	 * @throws	MailStateException Caso o estado do objeto não implemente abertura
	 * @throws	MailException Caso não seja possível recuperar o conteúdo da mensagem
	 */
	public function fetch( MailContext $context , Message $message ) {
		throw new ImapStateException( 'O estado atual não implementa recuperação de mensagens' );
	}

	/**
	 * Recupera um Iterator de caixas de correio
	 * @param	MailContext $context Contexto da conexão
	 * @param	string $pattern Padrão de busca
	 * @throws	ImapStateException Se o estado atual não implementar o fechamento
	 * @throws	ImapException Caso ocorra algum erro ao recuperar a lista de caixas de correio
	 */
	public function getMailboxIterator( MailContext $context , $pattern = '*' ) {
		throw new ImapStateException( 'O estado atual não implementa iterator de caixas de correio' );
	}

	/**
	 * Recupera um Iterator de mensagens de correio
	 * @param	MailContext $context Contexto da conexão
	 * @param	string $pattern Padrão de busca
	 * @return	MessageIterator
	 * @throws	MailStateException Se o estado atual não implementar o fechamento
	 * @throws	MailException Caso ocorra algum erro ao recuperar a lista de caixas de correio
	 */
	public function getMessageIterator( MailContext $context , $pattern = 'ALL' ) {
		throw new ImapStateException( 'O estado atual não implementa iterator de mensagens de correio' );
	}

	/**
	 * Abre uma conexão com uma caixa de correio IMAP
	 * @param	MailContext $context Contexto da conexão
	 * @param	string $mailbox Parâmetros de conexão
	 * @param	string $username Nome do usuário
	 * @param	string $password Senha do usuário
	 * @throws	ImapStateException Se o estado atual não implementar abertura
	 * @throws	ImapException Caso ocorra algum erro ao abrir a conexão
	 */
	public function open( MailContext $context , $mailbox , $username = null , $password = null ) {
		throw new ImapStateException( 'O estado atual não implementa abertura de conexão' );
	}

	/**
	 * Dispara uma cadeia de exceções referentes a todos os erros e alertas IMAP
	 * @param	string $message A mensagem da exceção principal
	 * @param	integer $code O código da exceção principal
	 * @throws	ImapException
	 */
	protected function throwExceptionChain( $message , $code = null ) {
		$errorArray = imap_errors();
		$alertArray = imap_alerts();
		$previousException = null;

		if ( is_array( $errorArray ) ) {
			foreach ( $errorArray as $error ) {
				$previousException = new ImapException( $error , null , $previousException );
			}
		}

		if ( is_array( $alertArray ) ) {
			foreach ( $alertArray as $alert ) {
				$previousException = new ImapException( $alert , null , $previousException );
			}
		}

		throw new ImapException( $message , $code , $previousException );
	}
}