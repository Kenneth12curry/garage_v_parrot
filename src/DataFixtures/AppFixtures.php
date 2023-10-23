<?php

namespace App\DataFixtures;

use App\Entity\Administrateur;
use App\Entity\Avis;
use App\Entity\ContactForm;
use App\Entity\Employe;
use App\Entity\Service;
use App\Entity\Vehicule;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    
    public function load(ObjectManager $manager): void
    {
        /* for ($i = 0; $i < 15; $i++) {

            $v = new Vehicule();
            //Donner des états aux attributs
            $v->setPrix(1000+$i);
            $v->setImage('car-'.$i.'.jpg');
            $v->setAnnee(2009+$i);
            $v->setNom("Mercedes Grand Sedan".$i);
            $v->setMarque("Cheverolet".$i);
            $v->setKilometrage(177220+$i);

            $manager->persist($v);
        }
        // $product = new Product();
        // $manager->persist($product);

        $manager->flush(); */

        # Insérer des employés dans la base de données
        /* for ($i = 0; $i < 5; $i++) {

            $emp = new Employe();
            //Donner des états aux attributs
            $emp->setLogin("john".$i."@gmail.com");
            $emp->setNom("Terry".$i);
            $emp->setPrenom("John".$i);
            $emp->setTel("77989124".$i);
            $emp->setAdresse("Point-E".$i);
            $emp->setPhoto("team-".$i.".jpg");
            $plainPassword = 'passer'; // Remplacez par le mot de passe de votre choix
            $hashedPassword = $this->passwordHasher->hashPassword($emp, $plainPassword);
            $emp->setPassword($hashedPassword);

            $manager->persist($emp);
            
        }
        # insérer les objets dans la bd #
        $manager->flush(); */

        /* for ($i=0; $i < 6; $i++){

            $service=new Service();
            $service->setNomService("Réparation mécanique générale");
            $service->setDescription("Cela inclut des travaux tels que les réparations 
            du moteur, de la transmission, des freins, de la suspension, etc.");
            $service->setDisponible("Disponible");
            $service->setCategorie("Réparation automobile");

            $manager->persist($service);

        }
        # insérer les objets dans la bd #
        $manager->flush(); */
 
        /*

        $admin=new Administrateur();
        $admin->setNom("Parrot");
        $admin->setPrenom("Vincent");
        $admin->setLogin("v_parrot@gmail.com");
        $plainPassword = 'parrot98'; // Remplacez par le mot de passe de votre choix
        $hashedPassword = $this->passwordHasher->hashPassword($admin, $plainPassword);
        $admin->setPassword($hashedPassword);
        $manager->persist($admin);

        
        # insérer les objets dans la bd #
        $manager->flush(); 

        */

        /* for ($i=0; $i < 6; $i++){

            $contact=new ContactForm();
            $contact->setSujet("Black Range Rover".$i);
            $contact->setNom("harry".$i);
            $contact->setEmail("ad@gmail.com".$i);
            $contact->setPrenom("jean".$i);
            $contact->setTel("77965783".$i);
            $contact->setMessage("Je désire avoir des informations sur cette voiture");

            $manager->persist($contact);

        }

        # insérer les objets dans la bd #
        $manager->flush(); */


        for ($i=0; $i < 6; $i++){

            $avis=new Avis;
            $avis->setNom("jerome".$i);
            $avis->setNote(4.5+$i);
            $avis->setCommentaire("Très satisfait de vos services");
            $avis->setEtat("Refusée");
            $manager->persist($avis);

        }

        # insérer les objets dans la bd #
        $manager->flush(); 
        

    }
}
