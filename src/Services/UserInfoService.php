<?php


namespace App\Services;

use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;

class UserInfoService
{

    /**
     * @var FlashBagInterface
     */
    private $bag;

    public function __construct(FlashBagInterface $bag)
    {
        $this->bag = $bag;
    }

    public function validateUserInfoForm($data): string
    {
        $message = "";
//        foreach ($data as $field) {
//            dump($field);
//        }

        if (!preg_match('/^[A-Za-ząčęėįšųūžĄČĘĖĮŠŲŪŽ]+$/i', $data['name'])) {
            $error = 'Vardas gali susidaryti tik iš raidžių.';
            $message .= $error;
            $this->bag->add('error', $error);
        }
        if (!preg_match('/^[A-Za-ząčęėįšųūžĄČĘĖĮŠŲŪŽ]+$/i', $data['surname'])) {
            $error = 'Pavardė gali susidaryti tik iš raidžių.';
            $message .= $error;
            $this->bag->add('error', $error);
        }
        if (!filter_var($data['personalEmail'], FILTER_VALIDATE_EMAIL)) {
            $error = 'Blogas el. pašto formatas.';
            $message .= $error;
            $this->bag->add('error', $error);
        }
        if (!is_numeric($data['phoneNumber'])) {
            $error = 'Tel. numeris gali susidaryti tik iš skaičių.';
            $message .= $error;
            $this->bag->add('error', $error);
        }

        return $message;
    }
}
