<?php
namespace Acme\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
//use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class Language
 * @package BlogBundle\Entity
 * @ORM\Table(name="language")
 * @ORM\Entity
*/

class Language
{
	/**
 *@ORM\Column(type="integer")
 *@ORM\Id
 *@ORM\GeneratedValue(strategy="AUTO")
*/  
private $lang_id;
/**
*@ORM\Column(type="string")
*/
private $lang_name;
/**
*@ORM\Column(type="string")
*/
private $lang_symbol;
/**
*@ORM\Column(type="string")
*/
private $locale;
/**
*@ORM\Column(type="text")
*/
private $description_lang;
/**
 *@ORM\Column(type="date")
*/
private $created;

public function __construct()
{
	$this->created = new \DateTime();
}

    /**
     * Get langId
     *
     * @return integer
     */
    public function getLang_id()
    {
        return $this->lang_id;
    }

    /**
     * Set langName
     *
     * @param string $langName
     *
     * @return Language
     */
    public function setLangName($langName)
    {
        $this->lang_name = $langName;

        return $this;
    }

    /**
     * Get langName
     *
     * @return string
     */
    public function getLangName()
    {
        return $this->lang_name;
    }
	/**
     * Set LangSymbol
     *
     * @param string $langSymbol
     *
     * @return Language
     */
    public function setLangSymbol($langSymbol)
    {
        $this->lang_symbol = $langSymbol;

        return $this;
    }

    /**
     * Get LangSymbol
     *
     * @return string
     */
    public function getLangSymbol()
    {
        return $this->lang_symbol;
    }
		/**
     * Set Locale
     *
     * @param string $locale
     *
     * @return Language
     */
    public function setLocale($locale)
    {
        $this->locale = $locale;

        return $this;
    }

    /**
     * Get Locale
     *
     * @return string
     */
    public function getLocale()
    {
        return $this->locale;
    }
		/**
     * Set description_lang
     *
     * @param text $langDesc
     *
     * @return Language
     */
    public function setDescriptionLang($langDesc)
    {
        $this->description_lang = $langDesc;

        return $this;
    }

    /**
     * Get description_lang
     *
     * @return text
     */
    public function getDescriptionLang()
    {
        return $this->description_lang;
    }
    /**
     * Set created
     *
     * @param \DateTime $created
     *
     * @return Language
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }
}
