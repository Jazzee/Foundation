<?php
namespace Foundation\Navigation;
/**
 * A single Navigation link
 * @author Jon Johnson <jon.johnson@ucsf.edu>
 * @license http://jazzee.org/license.txt
 * @package foundation
 * @subpackage navigation
 */
class Link extends \Foundation\HTMLElement{
  /**
   * The Content of the Link
   * @var string
   */
  protected $text;
  
  /**
   * Is this the current page
   */
  protected $current;
  
  /**
   * HTML Attributes
   */
  protected $charset;
  protected $coords;
  protected $href;
  protected $hreflang;
  protected $name;
  protected $rel;
  protected $rev;
  protected $shape;
  
  /**
   * Constructor
   * @param string $test
   */
  public function __construct($text){
    parent::__construct();
    $this->text = $text;
    $this->current = false;
    $this->attributes['charset'] = 'charset';
    $this->attributes['coords'] = 'coords';
    $this->attributes['href'] = 'href';
    $this->attributes['hreflang'] = 'hreflang';
    $this->attributes['name'] = 'name';
    $this->attributes['rel'] = 'rel';
    $this->attributes['rev'] = 'rev';
    $this->attributes['shape'] = 'shape';
  }
  
  /**
   * Set text
   * @param string $text
   */
  public function setText($text){
    $this->text = $text;
  }
  
  /**
   * Get Text
   * @return string
   */
  public function getText(){
    return $this->text;
  }
  
  /**
   * Set current
   * @param boolean $current
   */
  public function setCurrent($current){
    $this->current = (bool)$current;
  }
  
  /**
   * Get current
   * @return boolean
   */
  public function getCurrent(){
    return $this->current;
  }
  
  /**
   * Set the charset
   * @param string $charset
   */
  public function setCharset($charset){
    $this->charset = $charset;
  }
  
  /**
   * Get the charset
   * @return string $charset
   */
  public function getCharset(){
    return $this->charset;
  }
  
  /**
   * Set the coords
   * @param string $coords
   */
  public function setCoords($coords){
    $this->coords = $coords;
  }
  
  /**
   * Get the coords
   * @return string $coords
   */
  public function getCoords(){
    return $this->coords;
  }
  
  /**
   * Set the href
   * @param string $href
   */
  public function setHref($href){
    $this->href = $href;
  }
  
  /**
   * Get the href
   * @return string $href
   */
  public function getHref(){
    return $this->href;
  }
  
  /**
   * Set the hreflang
   * @param string $hreflang
   */
  public function setHreflang($hreflang){
    $this->hreflang = $hreflang;
  }
  
  /**
   * Get the hreflang
   * @return string $hreflang
   */
  public function getHreflang(){
    return $this->hreflang;
  }
  
  /**
   * Set the name
   * @param string $name
   */
  public function setName($name){
    $this->name = $name;
  }
  
  /**
   * Get the name
   * @return string $name
   */
  public function getName(){
    return $this->name;
  }
  
  /**
   * Set the rel
   * @param string $rel
   */
  public function setRel($rel){
    $this->rel = $rel;
  }
  
  /**
   * Get the rel
   * @return string $rel
   */
  public function getRel(){
    return $this->rel;
  }
  
  /**
   * Set the rev
   * @param string $rev
   */
  public function setRev($rev){
    $this->rev = $rev;
  }
  
  /**
   * Get the rev
   * @return string $rev
   */
  public function getRev(){
    return $this->rev;
  }
  
  /**
   * Set the shape
   * @param string $shape
   */
  public function setShape($shape){
    $this->shape = $shape;
  }
  
  /**
   * Get the shape
   * @return string $shape
   */
  public function getShape(){
    return $this->shape;
  }
  

}
?>