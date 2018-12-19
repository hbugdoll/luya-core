<?php

namespace luya\tag\tags;

use yii\helpers\Html;
use luya\tag\BaseTag;

/**
 * TagParser MailTag.
 *
 * The mail Tag allows you to create E-Mail links to an address. Example use `mail[info@luya.io]` or with an additional value info use `mail[info@luya.io](send mail)`
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
class MailTag extends BaseTag
{
    /**
     * An example of how to use the MailTag.
     *
     * @return string The example string
     * @see \luya\tag\TagInterface::example()
     */
    public function example()
    {
        return 'mail[info@luya.io](Mail us!)';
    }
    
    /**
     * The readme instructions string for the MailTag.
     *
     * @return string The readme text.
     * @see \luya\tag\TagInterface::readme()
     */
    public function readme()
    {
        return <<<EOT
The mail Tag allows you to create E-Mail links to an address. Example use `mail[info@luya.io]` or with an additional value info use `mail[info@luya.io](send mail)`.      
EOT;
    }
    
    /**
     * Generate the Mail Tag.
     *
     * @param string $value The Brackets value `[]`.
     * @param string $sub The optional Parentheses value `()`
     * @see \luya\tag\TagInterface::parse()
     * @return string The parser tag.
     */
    public function parse($value, $sub)
    {
        return Html::tag('a', Html::encode($sub) ?: $this->obfuscate($value), [
            'rel' => 'nofollow',
            'href' => 'mailto:'.$this->obfuscate($value),
            'encoding' => false,
        ]);
    }

    /**
     * Obfucscate email adresse
     *
     * @param string $email
     * @return string
     * @see http://php.net/manual/de/function.bin2hex.php#11027
     */
    public function obfuscate($email)
    {
        $output = null;
        for ($i = 0; $i < strlen($email); $i++) {
            $output .= '&#'.ord($email[$i]).';';
        }
        
	    return $output;
    }
}
