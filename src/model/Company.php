<?php
class Model_Company {
  private $id;
  private $name;
  private $icon;

  /*
   * Constructor
   */
  public function __construct($id, $name, $icon) {
    $this->id = $id;
    $this->name = $name;
    $this->icon = $icon;
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
}
