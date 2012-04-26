<?php
namespace Foundation\Navigation;
/**
 * Site Navigation Container
 * 
 * @package Foundation\navigation
 */
class Container extends \Foundation\HTMLElement
{
  /**
   * @var array $menus holds the menus
   */
  protected $menus;

  /**
   * The Links
   * @var array of \Foundation\Navitation\Link
   */
  protected $links;

  /**
   * Construct
   * 
   */
  public function __construct()
  {
    parent::__construct();
    $this->menus = array();
    $this->links = array();
  }

  /**
   * Add A menu to the container
   * @param \Foundation\Navigation\Menu $menu
   */
  public function addMenu(\Foundation\Navigation\Menu $menu)
  {
    $this->menus[] = $menu;
  }

  /**
   * Get the menus
   * @return array \Foundation\Navigation\Menu
   */
  public function getMenus()
  {
    return $this->menus;
  }

  /**
   * Add a link
   * @param \Foundation\Navigation\Link $link
   */
  public function addLink(\Foundation\Navigation\Link $link)
  {
    $this->links[] = $link;
  }

  /**
   * Get the links
   * return array
   */
  public function getLinks()
  {
    return $this->links;
  }

  /**
   * Does the container have links
   * @return bool true if there are any links false if not
   */
  public function hasLink()
  {
    return (bool) count($this->links);
  }
}