<?php
class Model_Formation {
   /**
    * Table formation
    * @var int
    */
   const TYP_FORMATION = 1;
   /**
    * Table formation
    * @var int
    */
   const TYP_EDUCTION = 2;

   private $id;
   private $name;
   private $instructor;
   private $date;
   private $type;

  /*
   * Constructor
   */
  public function __construct($id, $name, $instructor, $date, $type) {
    $this->id = $id;
    $this->name = $name;
    $this->instructor = $instructor;
    $this->date = new Datetime($date);
    $this->type = $type;
  }
   
   /**
    * Return the name
    * @return String
    */
   public function getName() {
      return $this->name;
   }
   
   /**
    * Return the name
    * @return String
    */
   public function getInstructor() {
      return $this->instructor;
   }
   
   /**
    * Return the date
    * @return Datetime
    */
   public function getDate() {
      return $this->date;
   }
   
   /**
    * Return the date
    * @return String
    */
   public function getYear() {
      return $this->date->format('Y');
   }
   
   /**
    * Return the type
    * @return String
    */
   public function getType() {
      return $this->type;
   }
}
