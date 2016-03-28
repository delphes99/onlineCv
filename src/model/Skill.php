<?php
class Model_Skill {
  private $id;
  private $name;
  private $description;
  private $skillType;
  private $important;

  /*
   * Constructor
   */
  public function __construct($id, $name, $description, $skillType, $important) {
    $this->id = $id;
    $this->name = $name;
    $this->description = $description;
    $this->skillType = $skillType;
    $this->important = $important;
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
    * Return the description
    * @return String
    */
   public function getDescription() {
      return $this->description;
   }
   
   /**
    * Return the skill type
    * @return Model_SkillType
    */
   public function getSkillType() {
      return $this->skillType;
   }
   
   /**
    * Return if the skill is important
    * @return boolean
    */
   public function isImportant() {
      return $this->important;
   }
}
