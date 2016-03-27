<?php
/**
 * @package   yii2-user
 * @author    Yuri Shekhovtsov <shekhovtsovy@yandex.ru>
 * @copyright Copyright &copy; Yuri Shekhovtsov, lowbase.ru, 2015 - 2016
 * @version   1.0.0
 */

namespace lowbase\user\components\oauth;

use lowbase\user\models\User;
use lowbase\user\models\UserOauthKey;

class Yandex extends \yii\authclient\clients\YandexOAuth
{

    public function getViewOptions()
    {
        return [
            'popupWidth' => 900,
            'popupHeight' => 500
        ];
    }

    public function normalizeSex()
    {
        return [
            'male' => User::SEX_MALE,
            'female' => User::SEX_FEMALE
        ];
    }

    /**
     * @inheritdoc
     */
    protected function initUserAttributes()
    {
        $attributes =  $this->api('info', 'GET');

        $return_attributes = [
            'User' => [
                'email' => $attributes['emails'][0],
                'first_name' => $attributes['first_name'],
                'last_name' => $attributes['last_name'],
                'photo' => 'https://avatars.yandex.net/get-yapic/' . $attributes['default_avatar_id'] . '/islands-200',
                'sex' => $this->normalizeSex()[$attributes['sex']]
            ],
            'provider_user_id' => $attributes['id'],
            'provider_id' => UserOauthKey::getAvailableClients()['yandex'],
            'page' => null,
        ];

        return $return_attributes;
    }
}
