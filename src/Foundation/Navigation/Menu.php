<?php
namespace Foundation\Navigation;
/**
 * A single navigtion menu
 */
class Menu extends \Foundation\HTMLElement{
  /**
   * The Links
   * @var array of \Foundation\Navitation\Link
   */
  protected $links;
  
  /**
   * Construct
   */
  public function __construct(){
    $this->links = array();
  }
  
  /**
   * Add a link
   * @param \Foundation\Navigation\Link $link
   */
  public function addLink(\Foundation\Navigation\Link $link){
    $this->links[] = $link;
  }
  
  /**
   * Get the links
   * return array
   */
  public function getLinks(){
    return $this->links;
  }
  
  /**
   * Sort the links by title
   */
  public function sortLinks(){
    usort($this->links, function($a, $b){
      return strcmp($a->getText(), $b->getText());
    });
  }
  
  /**
   * Does the menu have links
   * @return bool true if there are any links false if not
   */
  public function hasLink(){
    return (bool)count($this->links);
  }
}
?>