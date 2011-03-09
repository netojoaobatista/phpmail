<?php
/**
 * @author		João Batista Neto
 * @brief		Classes e objetos relacionados com caixa e conexão com servidor de correio
 * @package		dso.mail
 */

require_once 'dso/mail/Message.php';

/**
 * Implementação de um Iterator de mensagens de correio
 * @ingroup		Mail
 */
class MessageIterator implements Iterator, Countable {
	/**
	 * @var	ArrayIterator
	 */
	private $arrayIterator;

	/**
	 * Constroi o Iterator de mensagens de correio
	 * @param	array $messageArray
	 */
	public function __construct( array $messageArray = array() ) {
		$this->arrayIterator = new ArrayIterator( $messageArray );
	}

	/**
	 * Adiciona uma nova mensagem de correio ao Iterator
	 * @param	Message $message
	 */
	public function append( Message $message ) {
		$this->arrayIterator->append( $message );
	}

	/**
	 * @return	integer
	 * @see		Countable::count()
	 */
	public function count() {
		return $this->arrayIterator->count();
	}

	/**
	 * Recupera a mensagem de correio atual
	 * @return	Message
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