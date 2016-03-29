<?php
class Company {
  private $id;
  private $name;
  private $icon;
  private $url;

  /*
   * Constructor
   */
  public function __construct($id, $name, $icon, $url) {
    $this->id = $id;
    $this->name = $name;
    $this->icon = $icon;
    $this->url = $url;
  }

   /**
    * Return the id
    * @return String
    */
   public function getId() {
      return $this->id;
   }
   
   /**
    * Return the name
    * @return String
    */
   public function getName() {
      return $this->name;
   }
   
   /**
    * Return the icon file name
    * @return String
    */
   public function getIcon() {
      return $this->icon;
   }
   
   /**
    * Return the site url
    * @return String
    */
   public function getUrl() {
      return $this->url;
   }
}
