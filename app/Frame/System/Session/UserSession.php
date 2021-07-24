<?php
/**
 * Skripsi
 *
 * @package   Rental
 * @author    Valerius Iman Supriyatno
 * @copyright 2021 Multi Mutiara Rental.
 */

namespace App\Frame\System\Session;

use App\Frame\Formatter\DataParser;
use Illuminate\Support\Facades\DB;

/**
 *
 *
 * @package    app
 * @subpackage Frame\System\Session
 * @author     Valerius Iman Supriyatno
 * @copyright  2021 Multi Mutiara Rental.
 */
class UserSession
{
    /**
     * Property to store all the right for current page.
     *
     * @var array
     */
    private $Data;

    /**
     * Property to store all the system settings data
     *
     * @var SystemSettingSession $Settings
     */
    public $Settings;

    /**
     * UserSession constructor.
     * @param array $user To store the user data.
     */
    public function __construct(array $user = [])
    {
        $this->Data = $user;
        if (empty($this->Data) === true && session()->exists('user') === true) {
            $this->Data = session('user', []);
        }
        $this->Settings = new SystemSettingSession($this->Data);
    }

    /**
     * Function to get user id
     *
     * @return bool
     */
    public function isSet(): bool
    {
        return !empty($this->Data);
    }

    /**
     * Function to get user id
     *
     * @param array $data to store the data.
     *
     * @return void
     */
    public function setData(array $data): void
    {
        $this->Data = $data;
        $this->Settings->setData($this->Data);
    }

    /**
     * Function to get user id
     *
     * @return int
     */
    public function getId(): int
    {
        return $this->getIntValue('us_id');
    }

    /**
     * Function to get user id
     *
     * @return int
     */
    public function getSsId(): int
    {
        return $this->Settings->getId();
    }

    /**
     * Function to get user id
     *
     * @return string
     */
    public function getNameSpace(): string
    {
        return $this->Settings->getNameSpace();
    }

    /**
     * Function to get user name
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->getStringValue('us_name');
    }

    /**
     * Function to get user userName
     *
     * @return string
     */
    public function getUserName(): string
    {
        return $this->getStringValue('us_username');
    }

    /**
     * Function to get user System
     *
     * @return bool
     */
    public function isUserSystem(): bool
    {
        $val = $this->getStringValue('us_system');
        return ($val === 'Y');
    }

    /**
     * Function to get User mapping id
     *
     * @return int
     */
    public function getMappingId(): int
    {
        return $this->getIntValue('ump_id');
    }

    /**
     * Function to get all user data
     *
     * @return array
     */
    public function getAllData(): array
    {
        return $this->Data;
    }

    /**
     * Function to get all user mapping
     *
     * @return array
     */
    public function getMapping(): array
    {
        if (array_key_exists('systems', $this->Data) === true && $this->Data['systems'] !== null) {
            return $this->Data['systems'];
        }
        return [];
    }


    /**
     * Function to check is user allow e-mail
     *
     * @return bool
     */
    public function isMappingEnabled(): bool
    {
        return !empty($this->getMapping());
    }

    /**
     * Function to get user id
     *
     * @param string $keyWord To store the keyword.
     *
     * @return string
     */
    private function getStringValue(string $keyWord): string
    {
        if (array_key_exists($keyWord, $this->Data) === true && $this->Data[$keyWord] !== null) {
            return $this->Data[$keyWord];
        }
        return '';
    }

    /**
     * Function to get user id
     *
     * @param string $keyWord To store the keyword.
     *
     * @return int
     */
    private function getIntValue(string $keyWord): int
    {
        if (array_key_exists($keyWord, $this->Data) === true && $this->Data[$keyWord] !== null && is_numeric($this->Data[$keyWord]) === true) {
            return (int)$this->Data[$keyWord];
        }
        return 0;
    }


}
