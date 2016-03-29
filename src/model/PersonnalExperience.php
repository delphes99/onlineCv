<?php
class PersonnalExperience {
  private $id;
  private $title;
  private $html;
  private $beginning;
  private $end;
  private $skills;

  public function __construct($id, $title, $html, $beginning, $end) {
    $this->id = $id;
    $this->title = $title;
    $this->html = $html;
    $this->beginning = new DateTime($beginning);
    $this->end = new DateTime($end);
    
    $this->skills = array();
  }

   /**
   * Return the technical id
   * @return number
   */
   public function getId() {
      return $this->id;
   }

   /**
   * Return the title
   * @return String
   */
   public function getTitle() {
      return $this->title;
   }

   /**
   * Return the html code
   * @return String
   */
   public function getHTML() {
      return $this->html;
   }

   /**
   * Return the mission start
   * @return String / date
   */
   public function getBeginning() {
      return $this->beginning;
   }

   /**
    * Return the mission end
    * @return String / date
    */
   public function getEnd() {
      return $this->end;
   }

   /**
    * Return the mission duration
    * @return number number of month
    */
   public function getDuration() {
    $interval = $this->getBeginning()->diff($this->getEnd());
    return $interval->m + $interval->y * 12 + 1;
   }
   
   /**
    * Return the different skills
    * @return Model_ExperienceSkill
    */
   public function getSkills() {
      return $this->skills;
   }

   /**
    * Add a skill
    * @param Model_ExperienceSkill $skill
    */
   public function addSkill($skill) {
      $this->skills[] = $skill;
   }
   
   /**
    * all skills of $typeSkill
    * @param Model_MajorSkillType
    * @return Model_ExperienceSkill all skills of $typeSkill 
    */
   public function getSkillByMajorTypeSkill($majorTypeSkill) {
    $skillsList = array();
    foreach ($this->skills as $skill) {
      if($skill->getSkill()->getSkillType()->getMajorSkillType()->getId() == $majorTypeSkill->getId()) {
        $skillsList[] = $skill;
      }
    }

    return $skillsList;
   }
}
