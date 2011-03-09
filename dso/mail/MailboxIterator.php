<?php
/**
 * @author		João Batista Neto
 * @brief		Classes e objetos relacionados com caixa e conexão com servidor de correio
 * @package		dso.mail
 */

require_once 'dso/mail/MailBox.php';

/**
 * Implementação de um Iterator de caixas de correio
 * @ingroup		Mail
 */
class MailboxIterator implements Iterator, Countable {
	/**
	 * @var	ArrayIterator
	 */
	private $arrayIterator;

	/**
	 * Constroi o Iterator de caixas de correio
	 * @param	array $mailboxArray
	 */
	public function __construct( array $mailboxArray = array() ) {
		$this->arrayIterator = new ArrayIterator( $mailboxArray );
	}

	/**
	 * Adiciona uma nova caixa de correio ao Iterator
	 * @param	MailBox $mailBox
	 */
	public function append( MailBox $mailBox ) {
		$this->arrayIterator->append( $mailBox );
	}

	/**
	 * @return	integer
	 * @see		Countable::count()
	 */
	public function count() {
		return $this->arrayIterator->count();
	}

	/**
	 * Recupera a caixa de correio atual
	 * @return	MailBox
	 * @see		Iterator::current()
	 */
	public function current() {
		return $this->arrayIterator->current();
	}

	/**
	 * @return	integer
	 * @see		Iterator::key()
	 */
	public function key() {
		return $this->arrayIterator->key();
	}

	/**
	 * @see		Iterator::next()
	 */
	public function next() {
		$this->arrayIterator->next();
	}

	/**
	 * @see		Iterator::rewind()
	 */
	public function rewind() {
		$this->arrayIterator->rewind();
	}

	/**
	 * @return	boolean
	 * @see		Iterator::valid()
	 */
	public function valid() {
		return $this->arrayIterator->valid();
	}
}