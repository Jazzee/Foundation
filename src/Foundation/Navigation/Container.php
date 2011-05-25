<?php
namespace Foundation\Navigation;
/**
 * Site Navigation Container
 */
class Container extends \Foundation\HTMLElement{
  /**
   * @var array $menus holds the menus
   */
  protected $menus;
  
  /**
   * Construct
   * 
   */
  public function __construct(){
    parent::__construct();
    $this->menus = array();
  }
  
  /**
   * Add A menu to the container
   * @param \Foundation\Navigation\Menu $menu
   */
  public function addMenu(\Foundation\Navigation\Menu $menu){
    $this->menus[] = $menu;
  }
  
  /**
   * Get the menus
   * @return array \Foundation\Navigation\Menu
   */
  public function getMenus(){
    return $this->menus;
  }
}
?>