<?php

namespace App\DataFixtures;

use App\Entity\ClinicInfo;
use App\Entity\ClinicSpecialists;
use App\Entity\ClinicWorkHours;
use App\Entity\Language;
use App\Entity\Recipe;
use App\Entity\SendingToDoctor;
use App\Entity\SpecialistWorkHours;
use App\Entity\Specialty;
use App\Entity\User;
use App\Entity\UserEducation;
use App\Entity\UserInfo;
use App\Entity\UserLanguage;
use App\Entity\UserSpecialty;
use App\Entity\UserVisit;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Exception;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }


    public function load(ObjectManager $manager)
    {
        $count = 100;
        $this->loadUserData($count, $manager);
        $this->showTableLoadCompleteMessage('User');

        $this->loadUserInfoData($count, $manager);
        $this->showTableLoadCompleteMessage('UserInfo and ClinicInfo');

        $this->loadSpecialties($manager);
        $this->showTableLoadCompleteMessage('Specialties');

        $this->loadUserSpecialties($manager);
        $this->showTableLoadCompleteMessage('UserSpecialties');

        $this->loadClinicSpecialists($manager);
        $this->showTableLoadCompleteMessage('ClinicSpecialists');

        $this->loadClinicWorkHours($manager);
        $this->showTableLoadCompleteMessage('ClinicWorkHours');

        $this->loadSpecialistWorkHours($manager);
        $this->showTableLoadCompleteMessage('SpecialistWorkHours');

        $this->loadUserEducation($manager);
        $this->showTableLoadCompleteMessage('UserEducation');

        $this->loadLanguages($manager);
        $this->showTableLoadCompleteMessage('Languages');

        $this->loadUserLanguages($manager);
        $this->showTableLoadCompleteMessage('UserLanguages');

        $this->loadUserVisits($manager);
        $this->showTableLoadCompleteMessage('UserVisits and SendingsToDoctor and Recipes');
    }

    protected function loadUserData($count, ObjectManager $manager): void
    {
        for ($i = 0; $i < $count; $i++) {
            $user = new User();
            $rand = mt_rand(0, 100);
            if ($rand < 70) {
                $user->setRole(1);
            } elseif ($rand > 70 && $rand < 95) {
                $user->setRole(2);
            } else {
                $user->setRole(3);
            }
            $user->setPassword($this->encoder->encodePassword($user, 'testas'));
            $user->setRoles(['ROLE_USER', 'ROLE_ADMIN']);
            $user->setEmail("user$i@test.com");
            $manager->persist($user);
        }
        $manager->flush();
    }

    protected function loadUserInfoData($count, ObjectManager $manager): void
    {
        $user = $manager->getRepository(User::class)->findAll();
        foreach ($user as $usr) {
            if ($usr->getRole() == 1 || $usr->getRole() == 2) {
                $userInfo = new UserInfo();
                $name = $this->getNames();
                $userInfo->setName($name);
                $surname = $this->getSurname();
                $userInfo->setSurname($surname);
                $userInfo->setPhoneNumber($this->getPhoneNumber());
                $userInfo->setPersonalEmail($this->getEmail($name, $surname));

                $date = '19'.mt_rand(30, 90).'-'.mt_rand(1, 12).'-'.mt_rand(1, 28);
                try {
                    $userInfo->setDateOfBirth(new DateTime($date));
                } catch (Exception $e) {
                    throw (new Exception('No date found '.$e));
                }
                $userInfo->setCity('Kaunas');
                $userInfo->setPersonCode('3000000000');
                $userInfo->setDescription($this->getDescription());
                $userInfo->setUserId($usr);
                $manager->persist($userInfo);
            } else {
                $clinicInfo = new ClinicInfo();
                $clinicNames = $this->getClinicName();
                $clinicInfoName = $clinicNames[mt_rand(0, (sizeof($clinicNames) - 1))];
                $clinicInfo->setName($clinicInfoName);
                $clinicInfo->setAddress('Klinikos 14, Kaunas');
                $clinicInfo->setWebpage('https://'.$clinicInfoName.'.klinika.lt');
                $clinicInfo->setPhoneNumber($this->getPhoneNumber());
                $clinicInfo->setEmail('info@'.$clinicInfoName.'.klinika.com');
                $clinicInfo->setDescription($this->getDescription());
                $clinicInfo->setUserId($usr);
                $manager->persist($clinicInfo);
            }
        }
        $manager->flush();
    }

    protected function loadSpecialties(ObjectManager $manager): void
    {
        foreach ($this->getSpecialties() as $specialty) {
            $spec = new Specialty();
            $spec->setName($specialty);
            $manager->persist($spec);
        }
        $manager->flush();
    }

    protected function loadUserSpecialties(ObjectManager $manager): void
    {
        $users = $manager->getRepository(User::class)->getSpecialists();
        $specialties = $manager->getRepository(Specialty::class)->findAll();
        foreach ($users as $user) {
            $userSpecialty = new UserSpecialty();
            $userSpecialty->setUserId($user);
            $userSpecialty->setSpecialtyId($specialties[mt_rand(0, sizeof($specialties) - 1)]);
            $manager->persist($userSpecialty);
        }
        $manager->flush();
    }

    protected function loadClinicSpecialists(ObjectManager $manager): void
    {
        $clinics = $manager->getRepository(User::class)->getClinics();
        $specialists = $manager->getRepository(User::class)->getSpecialists();

        foreach ($specialists as $specialist) {
            $clinicSpecialist = new ClinicSpecialists();
            $clinicSpecialist->setSpecialistId($specialist);
            $clinicSpecialist->setClinicId($clinics[mt_rand(0, sizeof($clinics) - 1)]);
            $manager->persist($clinicSpecialist);
        }
        $manager->flush();
    }

    protected function loadClinicWorkHours(ObjectManager $manager): void
    {
        $clinics = $manager->getRepository(User::class)->getClinics();

        foreach ($clinics as $clinic) {
            for ($i = 1; $i <= 5; $i++) {
                $clinicWorkHours = new ClinicWorkHours();
                $clinicWorkHours->setClinicId($clinic);
                $clinicWorkHours->setDay($i);
                $startTime = mt_rand(8, 12);
                $endTime = mt_rand(13, 21);
                $clinicWorkHours->setStartTime(new DateTime("$startTime:00"));
                $clinicWorkHours->setEndTime(new DateTime("$endTime:00"));
                $manager->persist($clinicWorkHours);
            }
        }
        $manager->flush();
    }

    protected function loadSpecialistWorkHours(ObjectManager $manager): void
    {
        $clinicsSpecialists = $manager->getRepository(ClinicSpecialists::class)->findAll();

        foreach ($clinicsSpecialists as $spec) {
            for ($i = 1; $i <= 5; $i++) {
                $specialistWorkHours = new SpecialistWorkHours();
                $specialistWorkHours->setSpecialistId($spec->getSpecialistId());
                $specialistWorkHours->setClinicId($spec->getClinicId());
                $specialistWorkHours->setDay($i);
                $startTime = mt_rand(8, 12);
                $endTime = mt_rand(13, 21);
                $specialistWorkHours->setStartTime(new DateTime("$startTime:00"));
                $specialistWorkHours->setEndTime(new DateTime("$endTime:00"));
                $manager->persist($specialistWorkHours);
            }
        }
        $manager->flush();
    }

    protected function loadUserEducation(ObjectManager $manager): void
    {
        $specialists = $manager->getRepository(User::class)->getSpecialists();

        foreach ($specialists as $spec) {
            $userEducation = new UserEducation();
            $userEducation->setUserId($spec);
            $userEducation->setDescription($this->getDescription());
            $manager->persist($userEducation);
        }
        $manager->flush();
    }

    protected function loadLanguages(ObjectManager $manager): void
    {
        foreach ($this->getLanguages() as $key => $lang) {
            $language = new Language();
            $language->setNameShort($key);
            $language->setName($lang);
            $manager->persist($language);
        }
        $manager->flush();
    }

    protected function loadUserLanguages(ObjectManager $manager): void
    {
        $users = $manager->getRepository(User::class)->findBy(['role' => ['1', '2']]);
        $languages = $manager->getRepository(Language::class)->findAll();
        foreach ($users as $user) {
            $userLang = new UserLanguage();
            $userLang->setUserId($user);
            $userLang->setLanguageId($languages[mt_rand(0, sizeof($languages) - 1)]);
            $manager->persist($userLang);
        }
        $manager->flush();
    }

    protected function loadUserVisits(ObjectManager $manager): void
    {
        $clients = $manager->getRepository(User::class)->getUsers();
        $clinicSpecialists = $manager->getRepository(ClinicSpecialists::class)->findAll();
        $visitDescriptions = $this->getVisitDescriptions();
        foreach ($clients as $client) {
            if (mt_rand(0, 10) < 3) { //simuliuojam, kad ne visi pacientai turejo vizitu
                continue;
            }
            $visit = new UserVisit();
            $clinicSpec = $clinicSpecialists[mt_rand(0, sizeof($clinicSpecialists) - 1)];
            $visit->setClientId($client);
            $visit->setSpecialistId($clinicSpec->getSpecialistId());
            $visit->setClinicId($clinicSpec->getClinicId());
            $month = mt_rand(1, 12);
            $day = mt_rand(1, 28);
            $hour = mt_rand(8, 20);
            $visit->setVisitDate(new DateTime("2019-$month-$day $hour:00:00"));
            $visit->setDescription($visitDescriptions[mt_rand(0, sizeof($visitDescriptions) - 1)]);
            if (mt_rand(0, 10) < 3) { //simuliuojam, kad tik 30% vizitu metu bus gaunamas siuntimas
                $sendToDoctor = new SendingToDoctor();
                $sendToDoctor->setClientId($client);
                $sendToDoctor->setSpecialistId($clinicSpec->getSpecialistId());
                $sendToDoctor->setDescription($visitDescriptions[mt_rand(0, sizeof($visitDescriptions) - 1)]);
                $manager->persist($sendToDoctor);
                $manager->flush();
                $visit->setSendingToDoctorId($sendToDoctor);
            }

            if (mt_rand(0, 10) < 3) { //simuliuojam, kad tik 30% vizitu metu bus israsomas receptas
                $recipe = new Recipe();
                $drugNames = $this->getRecipeDrugNames();
                $drugAmounts = $this->getRecipeDrugAmounts();
                $drugSize = 0;
                $timesPerDay = mt_rand(1, 3);
                $timesPerDayPhrase = $timesPerDay == 1 ? 'kartą' : 'kartus';
                $amount = $drugAmounts[mt_rand(0, sizeof($drugAmounts) - 1)];
                if ($amount == 'tabletes') {
                    $drugSize = mt_rand(2, 5);
                } else {
                    $drugSize = mt_rand(0, 100);
                }
                $description = 'Vartoti '.$drugNames[mt_rand(0, sizeof($drugNames) - 1)].'  '.$timesPerDay. ' '
                    .$timesPerDayPhrase.' per dieną po '.$drugSize.' '.$amount;
                $recipe->setDescription($description);
                $recipe->setValidFrom(new DateTime("2019-$month-$day"));
                $recipe->setValidDuration("$day menesių nuo išrašymo datos");
                $manager->persist($recipe);
                $manager->flush();
                $visit->setRecipeId($recipe);
            }
            $manager->persist($visit);
            $manager->flush();
        }
    }

    protected function showTableLoadCompleteMessage($tableName): void
    {
        echo "Inserted $tableName table data\r\n";
        echo "====================================\r\n";
    }

    protected function getNames(): string
    {
        $nameArr = [
            'Aidas',
            'Aldas',
            'Algirdas',
            'Dainius',
            'Eimantas',
            'Gediminas',
            'Irmantas',
            'Jaunius',
            'Kęstas',
            'Linas',
            'Mantas',
            'Nerijus',
            'Rimas',
            'Tauras',
            'Ugnius',
            'Vaidas',
        ];

        return $nameArr[mt_rand(0, sizeof($nameArr) - 1)];
    }

    protected function getSurname(): string
    {
        return str_replace('as', '', $this->getNames()).'auskas';
    }

    protected function getPhoneNumber(): string
    {
        return '86'.mt_rand(1000000, 9999999);
    }

    protected function getEmail($name, $surname): string
    {
        return $name.'.'.$surname.'@test.com';
    }

    protected function getDescription(): string
    {
        return 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed tincidunt aliquam luctus. Suspendisse 
        vitae vehicula arcu, id consequat lacus. Aenean tincidunt eros at dui dignissim, vitae posuere sem lobortis. 
        Proin non justo eu nisl maximus dictum eu vel enim. Phasellus pellentesque leo nisi, non iaculis libero 
        condimentum eget. Aenean lacinia dolor dolor, vitae sollicitudin metus consectetur id. Duis elementum orci neque
        , nec rutrum purus dapibus non. Phasellus tincidunt diam ultrices, elementum mauris sed, scelerisque enim. Nunc 
        elementum erat ac libero feugiat imperdiet.';
    }

    protected function getSpecialties(): array
    {
        return [
            'Chirurgas',
            'Dermatologas',
            'Kardiologas',
            'Odontologas',
            'Endokrinologas',
            'Genetikas',
            'Imunologas',
            'Logopedas',
            'Neurologas',
            'Neurochirurgas',
            'Psichologas',
            'Toksikologas',
            'Vaikų chirurgas',
        ];
    }

    protected function getLanguages(): array
    {
        return [
            'LT' => 'Lietuvių',
            'EN' => 'Anglų',
            'RU' => 'Rusų',
            'FR' => 'Prancūzų',
            'DE' => 'Vokiečių',
        ];
    }

    protected function getClinicName(): array
    {
        return [
            'Centrinė konsultacinė poliklinika',
            'Aleksoto PSP poliklinika',
            'Baltic medicale',
            'Achemos poliklinika',
            'Lazdynų poliklinika',
            'Sveikatos priežiūros poliklinika',
            'Kauno klinikinė ligoninė',
            'Lietuvos respublikinė ligoninė',
            'Euromed klinika',
            'Naujosios Vilnios poliklinika',
        ];
    }

    protected function getVisitDescriptions(): array
    {
        return [
            'Peršalimas',
            'Kojos lūžis',
            'Nemiga',
            'Migrena',
            'Apetito dingimas',
            'Vizitas po operacijas',
            'Kraujo tyrimai',
            'Kraujo tyrimų aptarimas',
            'Nusimušė pirštą',
            'Išdžiuvo akys',
            'Akių tyrimas',
            'Skauda galvą',
            'Pučia pilvą',
            'Atminties praradimas',
        ];
    }

    protected function getRecipeDrugNames(): array
    {
        return [
            'Nimesil',
            'Ospamox',
            'Xanax',
            'Actifed',
            'Lexotanil',
            'Meurorubine',
            'Furadonins',
            'Cavinton Forte',
            'Omeprazol',
            'Boncel',
            'Cirrus',
            'Movalis',
            'Sirdalud',
            'Uvamin',
            'Mildronate',
            'Xefo',
            'Ventonil',
            'Tardyferon',
            'Olfen',
            'Gelomyrtol forte',
        ];
    }

    protected function getRecipeDrugAmounts(): array
    {
        return ['mg', 'ml', 'tabletes'];
    }
}
