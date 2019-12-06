<?php


namespace App\Services;


use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;

class ClinicInfoService
{
    /**
     * @var FlashBagInterface
     */
    private $bag;

    public function __construct(FlashBagInterface $bag)
    {
        $this->bag = $bag;
    }

    public function validateClinicInfoForm($data): string
    {
        $message = "";
//        $data['webpage'] = 'https://' . $data['webpage'];
//        if (!filter_var($data['webpage'], FILTER_VALIDATE_URL)) {
//            $error = 'Blogas svetainės formatas.';
//            $message .= $error;
//            $this->bag->add('error', $error);
//        }
        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
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