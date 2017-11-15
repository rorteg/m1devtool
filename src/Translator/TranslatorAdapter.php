<?php
/**
 * @see       https://github.com/rorteg/m1devtools for the canonical source repository
 * @copyright Copyright (c) 2017 Rafael Ortega Bueno. (https://github.com/rorteg)
 * @license   https://github.com/rorteg/m1devtools/blob/master/LICENSE.md New BSD License
 */

namespace ROB\M1devtools\Translator;

use Zend\I18n\Translator\Translator;
use Zend\I18n\Translator\TranslatorInterface;

class TranslatorAdapter extends Translator implements TranslatorInterface
{
    /**
     * {@inheritDoc}
     */
    public function translate($message, $textDomain = 'default', $locale = null)
    {
        if (! extension_loaded('intl')) {
            return $message;
        }

        return parent::translate($message, $textDomain, $locale);
    }
}
