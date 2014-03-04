<?php

namespace Tcx\Bundle\TcxAccountBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * TcxAccount
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Tcx\Bundle\TcxAccountBundle\Repository\TcxAccountRepository")
 */
class TcxAccount extends BaseUser
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="firstName", type="string", length=64)
     */
    protected $firstName;

    /**
     * @var string
     *
     * @ORM\Column(name="lastName", type="string", length=64)
     */
    protected $lastName;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="birthday", type="date")
     */
    protected $birthday;

    /**
     * @var string
     *
     * @ORM\Column(name="tcxAccountAvatar", type="string", length=128)
     */
    protected $tcxAccountAvatar;
    
	/**
     * @Assert\File(maxSize="6000000")
     */
    public $tcxAccountAvatarFile;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="creationDate", type="datetimetz")
     */
    protected $creationDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="lastModificationDate", type="datetimetz")
     */
    protected $lastModificationDate;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set firstName
     *
     * @param string $firstName
     * @return TcxAccount
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string 
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     * @return TcxAccount
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string 
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set birthday
     *
     * @param \DateTime $birthday
     * @return TcxAccount
     */
    public function setBirthday($birthday)
    {
        $this->birthday = $birthday;

        return $this;
    }

    /**
     * Get birthday
     *
     * @return \DateTime 
     */
    public function getBirthday()
    {
        return $this->birthday;
    }

    /**
     * Set creationDate
     *
     * @param \DateTime $creationDate
     * @return TcxAccount
     */
    public function setCreationDate($creationDate)
    {
        $this->creationDate = $creationDate;

        return $this;
    }

    /**
     * Get creationDate
     *
     * @return \DateTime 
     */
    public function getCreationDate()
    {
        return $this->creationDate;
    }

    /**
     * Set lastModificationDate
     *
     * @param \DateTime $lastModificationDate
     * @return TcxAccount
     */
    public function setLastModificationDate($lastModificationDate)
    {
        $this->lastModificationDate = $lastModificationDate;

        return $this;
    }
    
    public function getTcxAccountAvatar() {
    	return $this->tcxAccountAvatar;
    }

    public function setTcxAccountAvatar($tcxAccountAvatar) {
		$this->tcxAccountAvatar = $tcxAccountAvatar;
		return $this->tcxAccountAvatar;
	}

    /**
     * Get lastModificationDate
     *
     * @return \DateTime 
     */
    public function getLastModificationDate()
    {
        return $this->lastModificationDate;
    }
    
    public function displayBirthday()
    {
    	return $this->birthday->format('Y-m-d H:i');
    }
    public function displayCreationDate()
    {
    	return $this->creationDate->format('Y-m-d H:i');
    }
    public function displayLastModificationDate()
    {
    	return $this->lastModificationDate->format('Y-m-d H:i');
    }
    
    public function getAbsolutePath()
    {
    	return null === $this->tcxAccountAvatar ? null : $this->getUploadRootDir().'/'.$this->tcxAccountAvatar;
    }
    
    public function getWebPath()
    {
    	return null === $this->tcxAccountAvatar ? null : $this->getUploadDir().'/'.$this->tcxAccountAvatar;
    }
    
    protected function getUploadRootDir()
    {
    	// le chemin absolu du répertoire où les documents uploadés doivent être sauvegardés
    	return __DIR__.'/../../../../../web/'.$this->getUploadDir();
    }
    
    protected function getUploadDir()
    {
    	// on se débarrasse de « __DIR__ » afin de ne pas avoir de problème lorsqu'on affiche
    	// le document/image dans la vue.
    	return 'uploads/avatars';
    }
    
    public function upload()
    {
    	// la propriété « file » peut être vide si le champ n'est pas requis
    	if (null === $this->tcxAccountAvatarFile) {
    		return;
    	}
    
    	// utilisez le nom de fichier original ici mais
    	// vous devriez « l'assainir » pour au moins éviter
    	// quelconques problèmes de sécurité
    
    	// la méthode « move » prend comme arguments le répertoire cible et
    	// le nom de fichier cible où le fichier doit être déplacé
    	$this->tcxAccountAvatarFile->move($this->getUploadRootDir(), $this->tcxAccountAvatarFile->getClientOriginalName());
    
    	// définit la propriété « path » comme étant le nom de fichier où vous
    	// avez stocké le fichier
    	$this->tcxAccountAvatar = $this->tcxAccountAvatarFile->getClientOriginalName();
    
    	// « nettoie » la propriété « file » comme vous n'en aurez plus besoin
    	$this->tcxAccountAvatarFile = null;
    }
    
    
    public function __construct()
    {
    	parent::__construct();
    	$this->birthday = null;
    	$this->lastModificationDate = new \DateTime();
    	$this->creationDate = new \DateTime();
    }
}
