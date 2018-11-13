<?php
/**
 * Created by PhpStorm.
 * User: jesda
 * Date: 14/11/18
 * Time: 00:07
 */

namespace App\Utility;

use Symfony\Component\Validator\Constraints as Assert;


class Contact
{


    /**
     * @Assert\NotBlank()
     */
    private $lastname;

    /**
     * @Assert\NotBlank()
     */
    private $firstname;

    /**
     * @Assert\NotBlank()
     * @Assert\Email(
     *     message="L'email n'est pas correct"
     * )
     */
    private $email;


    /**
     * @Assert\NotBlank()
     */
    private $subject;

    /**
     * @Assert\NotBlank()
     */
    private $message;

    /**
     * @return mixed
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * @param mixed $lastname
     */
    public function setLastname($lastname): void
    {
        $this->lastname = $lastname;
    }

    /**
     * @return mixed
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * @param mixed $firstname
     */
    public function setFirstname($firstname): void
    {
        $this->firstname = $firstname;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email): void
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * @param mixed $subject
     */
    public function setSubject($subject): void
    {
        $this->subject = $subject;
    }

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param mixed $message
     */
    public function setMessage($message): void
    {
        $this->message = $message;
    }


}