<?php
class Experience {
  private $id;
  private $title;
  private $status;
  private $type;
  private $location;
  private $shortDesc;
  private $longDesc;
  private $client;
  private $employer;
  private $beginning;
  private $end;
  private $goals;
  private $skills;

  public function __construct($id, $title, $status, $type, $location, $shortDesc, $longDesc, $client, $employer, $beginning, $end) {
    $this->id = $id;
    $this->title = $title;
    $this->status = $status;
    $this->type = $type;
    $this->location = $location;
    $this->shortDesc = $shortDesc;
    $this->longDesc = $longDesc;
    $this->client = $client;
    $this->employer = $employer;
    $this->beginning = new DateTime($beginning);
    $this->end = new DateTime($end);

    $this->goals = array();
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
    * Set the technical id
    * @param number $title
    */
   public function setTitle($id) {
      $this->id = $id;
   }
    
   /**
   * Return the title
   * @return String
   */
   public function getTitle() {
      return $this->title;
   }

   /**
   * Return the status
   * @return String
   */
   public function getStatus() {
      return $this->status;
   }

   /**
   * Return the type
   * @return String
   */
   public function getType() {
      return $this->type;
   }
    
   /**
   * Return the mission location
   * @return String
   */
   public function getLocation() {
      return $this->location;
   }
    
   /**
   * Return the short mission desciption
   * @return String
   */
   public function getShortDescription() {
      return $this->shortDesc;
   }
   
   /**
    * Return the complete mission desciption
    * @return String
    */
   public function getLongDescription() {
      return $this->longDesc;
   }
    
   /**
   * Return the client Company
   * @return String
   */
   public function getClient() {
      return $this->client;
   }
   
   /**
    * Return the employer Company
    * @return String
    */
   public function getEmployer() {
      return $this->employer;
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
    * Return the employer Company
    * @return Model_ExperienceGoal
    */
   public function getGoals() {
      return $this->goals;
   }

   /**
    * Add a goal
    * @param Model_ExperienceGoal $goal
    */
   public function addGoal($goal) {
      $this->goals[] = $goal;
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
