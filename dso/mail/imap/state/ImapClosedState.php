<?php
/**
 * @author		João Batista Neto
 * @brief		Estados de conexão IMAP
 * @package		dso.mail.imap.state
 */

require_once 'dso/mail/MailContext.php';
require_once 'dso/mail/imap/state/ImapState.php';
require_once 'dso/mail/imap/state/ImapOpenedState.php';

/**
 * Implementação de um estado de conexão IMAP fechado
 * @ingroup	IMAP
 */
class ImapClosedState extends ImapState {
	/**
	 * Abre uma conexão com uma caixa de correio IMAP
	 * @param	MailContext $context Contexto da conexão
	 * @param	string $mailbox Parâmetros de conexão
	 * @param	string $username Nome do usuário
	 * @param	string $password Senha do usuário
	 * @see		ImapState::open()
	 * @throws	ImapStateException Se o estado atual não implementar abertura
	 * @throws	ImapException Caso ocorra algum erro ao abrir a conexão
	 */
	public function open( MailContext $context , $mailbox , $username = null , $password = null ) {
		$imapResource = imap_open( $mailbox , $username , $password , OP_SILENT );

		if ( is_resource( $imapResource ) ) {
			ImapState::$resource = $imapResource;
			$context->changeState( new ImapOpenedState( $mailbox ) );
		} else {
			$this->throwExceptionChain( 'Não foi possível estabelecer uma conexão com o servidor de correio' );
		}
	}
}