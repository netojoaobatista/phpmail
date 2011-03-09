<?php
/**
 * @author		João Batista Neto
 * @brief		Estados de conexão IMAP
 * @package		dso.mail.imap.state
 */

require_once 'dso/mail/MailContext.php';
require_once 'dso/mail/MailboxIterator.php';
require_once 'dso/mail/Message.php';
require_once 'dso/mail/MessageIterator.php';
require_once 'dso/mail/imap/state/ImapState.php';
require_once 'dso/mail/imap/ImapMailbox.php';
require_once 'dso/mail/imap/ImapMessage.php';

/**
 * Implementação de um estado de conexão IMAP aberto
 * @ingroup	IMAP
 */
class ImapOpenedState extends ImapState {
	/**
	 * @var	string
	 */
	private $ref;

	/**
	 * Constroi o objeto de estado de conexão aberta
	 * @param	string $ref
	 */
	public function __construct( $ref ) {
		$this->ref = $ref;
	}

	/**
	 * Fecha uma conexão IMAP previamente aberta
	 * @param	MailContext $context Contexto da conexão
	 * @see		ImapState::close()
	 * @throws	ImapStateException Se o estado atual não implementar o fechamento
	 * @throws	ImapException Caso ocorra algum erro ao fechar a conexão
	 */
	public function close( MailContext $context ) {
		if (  !imap_close( ImapState::$resource ) ) {
			$this->throwExceptionChain( 'Não foi possível fechar a conexão' );
		}
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
		$msgNum = imap_msgno( ImapState::$resource , $message->getUID() );

		$structure = imap_fetchstructure( ImapState::$resource , $msgNum );
		$overview = (array) current( imap_fetch_overview( ImapState::$resource , $msgNum ) );

		$message->setHeaders( imap_fetchheader( ImapState::$resource , $msgNum ) );
		$message->setOverview( $overview );

		if ( isset( $structure->parts ) && count( $structure->parts ) ) {
			foreach ( $structure->parts as $key => $part ) {
				$this->fetchContent( $message , $part->subtype , $msgNum , $key + 1 );
			}
		} else {
			$this->fetchContent( $message , $structure->subtype , $msgNum , 1 );
		}
	}

	private function fetchContent( Message $message , $subtype , $msgNum , $part , array $parameters = array() ) {
		$content = base64_decode( imap_fetchbody( ImapState::$resource , $msgNum , $part ) );

		foreach ( $parameters as $parameter ) {
			if ( $parameter->attribute == 'CHARSET' ) {
				$content = mb_convert_encoding( $content , 'UTF-8' , $parameter->value );
			}
		}

		$message->setContent( $subtype , $content );
	}

	/**
	 * Recupera um Iterator de caixas de correio
	 * @param	MailContext $context Contexto da conexão
	 * @param	string $pattern Padrão de busca
	 * @return	MailboxIterator
	 * @see		ImapState::getMailboxIterator()
	 * @throws	ImapStateException Se o estado atual não implementar o fechamento
	 * @throws	ImapException Caso ocorra algum erro ao recuperar a lista de caixas de correio
	 */
	public function getMailboxIterator( MailContext $context , $pattern = '*' ) {
		$mailboxesArray = imap_getmailboxes( ImapState::$resource , $this->ref , $pattern );
		$mailboxesIterator = new MailboxIterator();

		if ( is_array( $mailboxesArray ) ) {
			foreach ( $mailboxesArray as $mailbox ) {
				$mailboxesIterator->append( new ImapMailbox( $context , $mailbox->name , $this->ref ) );
			}

			return $mailboxesIterator;
		} else {
			$this->throwExceptionChain( 'Não foi possível recuperar a lista de caixas de correio' );
		}
	}

	/**
	 * Recupera um Iterator de mensagens de correio
	 * @param	MailContext $context Contexto da conexão
	 * @param	string $pattern Padrão de busca
	 * @return	MessageIterator
	 * @see		ImapState::getMessageIterator()
	 * @throws	MailStateException Se o estado atual não implementar o fechamento
	 * @throws	MailException Caso ocorra algum erro ao recuperar a lista de caixas de correio
	 */
	public function getMessageIterator( MailContext $context , $pattern = 'ALL' ) {
		$messagesArray = imap_search( ImapState::$resource , $pattern , SE_UID | SE_NOPREFETCH );
		$messagesIterator = new MessageIterator();

		if ( is_array( $messagesArray ) ) {
			foreach ( $messagesArray as $uid ) {
				$messagesIterator->append( new ImapMessage( $context , $uid ) );
			}

			return $messagesIterator;
		} else {
			$this->throwExceptionChain( 'Não foi possível recuperar as mensagens' );
		}
	}

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
		if (  !imap_reopen( ImapState::$resource , $mailbox , OP_SILENT ) ) {
			$this->throwExceptionChain( 'Não foi possível estabelecer uma conexão com o servidor de correio' );
		}
	}
}