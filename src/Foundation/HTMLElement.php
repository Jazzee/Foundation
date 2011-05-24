<?php
namespace Foundation;
/**
 * Dynamic HTML elements
 * @package Foundation
 */
class HTMLElement{
  /**
   * An array of all the possible attributes for this element and their member names
   * @var array
   */
  protected $attributes;
  
  /**
   * HTML element attributes
   * @var string
   */
  protected $id;
  protected $dir;
  protected $lang;
  protected $style;
  protected $title;
  protected $xmlLang;
  
  /**
   * The classes for an element
   * @var array
   */
  protected $classes;
  
  /**
   * Constructor
   */
  public function __construct(){
    $this->attributes = array();
    $this->classes = array();
    $this->attributes['class'] = 'class';
    $this->attributes['dir'] = 'dir';
    $this->attributes['id'] = 'id';
    $this->attributes['lang'] = 'lang';
    $this->attributes['style'] = 'style';
    $this->attributes['title'] = 'title';
    $this->attributes['xmlLang'] = 'xml:lang';
  }
  
  /**
   * Get all of the availalbe attributes for this element
   * @return array 
   */
  public function getAttributes(){
    return $this->attributes;
  }
  
  /**
   * Set the ID
   * @param string $id
   */
  public function setId($id){
    $this->id = $id;
  }
  
  /**
   * Get the ID
   * @return string
   */
  public function getId(){
    return $this->id;
  }
  
  /**
   * Set the dir
   * @param string $id
   */
  public function setDir($dir){
    $this->dir = $dir;
  }
  
  /**
   * Get the dir
   * @return string
   */
  public function getDir(){
    return $this->dir;
  }
  
  /**
   * Set the Lang
   * @param string $lang
   */
  public function setLang($lang){
    $this->lang = $lang;
  }
  
  /**
   * Get the Lang
   * @return string
   */
  public function getLang(){
    return $this->lang;
  }
  
  /**
   * Set the Style
   * @param string $style
   */
  public function setStyle($style){
    $this->style = $style;
  }
  
  /**
   * Get the Style
   * @return string
   */
  public function getStyle(){
    return $this->style;
  }
  
  /**
   * Set the Title
   * @param string $title
   */
  public function setTitle($title){
    $this->title = $title;
  }
  
  /**
   * Get the Title
   * @return string
   */
  public function getTitle(){
    return $this->title;
  }
  
  /**
   * Set the xml:lang
   * @param string $xmlLang
   */
  public function setXmlLang($xmlLang){
    $this->xmlLang = $xmlLang;
  }
  
  /**
   * Get the xml:lang
   * @return string
   */
  public function getXmlLang(){
    return $this->xmlLang;
  }
  
  /**
   * Set the class
   * Only used to override all the class values
   * @param string $classes
   */
  public function setClass($classes){
    if($classes == '') $this->classes = array();
    $this->classes = \explode(',',$classes);
  }
  /**
   * Set the classes
   * @param string $name
   */
  public function addClass($name){
    $this->classes[] = $name;
  }
  
  /**
   * Get the classes as a list
   */
  public function getClass(){
    if(empty($this->classes)) return null;
    return implode(' ', $this->classes);
  }
}
?>