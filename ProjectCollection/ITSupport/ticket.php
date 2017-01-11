<?php
class Ticket {
	public $fname, $lname, $email, $subject, $description, $timeReceived, $admin, $open, $id;

	public function __construct($newFname, $newLname, $newEmail, $newSubject, $newDescription, $newTimeReceived, $newAdmin, $newOpen, $newID) {
		$this->id = $newID;
		$this->fname = $newFname;
		$this->lname = $newLname;
		$this->email = $newEmail;
		$this->subject = $newSubject;
		$this->description = $newDescription;
		$this->timeReceived = $newTimeReceived;
		$this->admin = $newAdmin;
		if($newOpen == 0) {
			$this->open = "open";
		} else {
			$this->open = "closed";
		}
	}
}
?>