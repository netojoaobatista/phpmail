<?php
/**
 * @author		João Batista Neto
 * @brief		Classes e objetos relacionados com caixa e conexão com servidor de correio
 * @package		dso.mail
 */

/**
 * Interface para uma caixa de correio
 * @interface	Mailbox
 * @ingroup		Mail
 */
interface MailBox {
	/**
	 * Recupera o nome completo da caixa de correio
	 * @return	string
	 */
	public function getFullname();

	/**
	 * Recupera o nome da caixa de correio
	 * @return	string
	 */
	public function getName();

	/**
	 * Abre a caixa de correio
	 */
	public function open();
}