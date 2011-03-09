<?php
require 'dso/mail/imap/exception/ImapException.php';
require 'dso/mail/imap/Imap.php';

$username = 'usuario@gmail.com';
$password = 'senha';

if ( $username == 'usuario@gmail.com' && $password == 'senha' ) {
	throw new Exception( 'Defina o usuário e senha antes de executar o exemplo' );
} else {
	try {
		$imap = new Imap();
		$imap->open( '{imap.gmail.com:993/imap/ssl/novalidate-cert}' , $username , $password );

		for ( $mbi = $imap->getMailboxIterator() ; $mbi->valid() ; $mbi->next() ) {
			$mailbox = $mbi->current();
			$mailbox->open();

			printf( "%s\n" , $mailbox->getName() );

			for ( $mi = $imap->getMessageIterator() ; $mi->valid() ; $mi->next() ) {
				$message = $mi->current();
				$message->fetch();

				printf( "\tID: %s\n" , $message->getMessageId() );
				printf( "\tDe: %s\n" , $message->getFrom() );
				printf( "\tPara: %s\n" , $message->getTo() );
				printf( "\tAssunto: %s\n" , $message->getSubject() );
				printf( "\tData: %s\n\n" , $message->getDate() );
			}

			echo PHP_EOL;
		}
	} catch ( ImapException $e ) {
		echo $e->getMessage() , PHP_EOL;
	}
}