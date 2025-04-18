# base.module.migration.userfields.provider.enumeration

<table>
<tr>
<td>
<a href="https://github.com/Liventin/base.module.migration.userfields">Bitrix Base Module Service Migration User Fields</a>
</td>
</tr>
</table>

install | update

```
"require": {
    "liventin/base.module.migration.userfields.provider.enumeration": "dev-main"
}
"repositories": [
    {
      "type": "vcs",
      "url": "git@github.com:liventin/base.module.migration.userfields.provider.enumeration"
    }
]
```
redirect (optional)
```
"extra": {
  "service-redirect": {
    "liventin/base.module.migration.userfields.provider.enumeration": "module.name",
  }
}
```
PhpStorm Live Template
```php
<?php

namespace ${MODULE_PROVIDER_CAMMAL_CASE}\\${MODULE_CODE_CAMMAL_CASE}\Migration\UserFields;

use ${MODULE_PROVIDER_CAMMAL_CASE}\\${MODULE_CODE_CAMMAL_CASE}\Service\Container;
use ${MODULE_PROVIDER_CAMMAL_CASE}\\${MODULE_CODE_CAMMAL_CASE}\Service\Migration\UserField\UserFieldEntity;
use ${MODULE_PROVIDER_CAMMAL_CASE}\\${MODULE_CODE_CAMMAL_CASE}\Service\Migration\UserField\UserFieldService;
use ${MODULE_PROVIDER_CAMMAL_CASE}\\${MODULE_CODE_CAMMAL_CASE}\Src\Migration\UserField\Providers\EnumerationProvider;
use Bitrix\Main\ObjectNotFoundException;
use Bitrix\Main\SystemException;
use Psr\Container\NotFoundExceptionInterface;
use ReflectionException;

class ExampleEnumerationUserField implements UserFieldEntity
{
    public static function getEntityId(): string
    {
        return 'USER';
    }

    public static function getFieldName(): string
    {
        return 'UF_EXAMPLE_ENUMERATION_FIELD';
    }

    public static function getUserTypeId(): string
    {
        return 'enumeration';
    }

    /**
     * @throws NotFoundExceptionInterface
     * @throws ObjectNotFoundException
     * @throws ReflectionException
     * @throws SystemException
     */
    public static function getParams(): array
    {
        /** @var EnumerationProvider ${DS}provider */
        ${DS}provider = Container::get(UserFieldService::SERVICE_CODE)->getProvider(self::getUserTypeId());

        ${DS}provider->createEnumValue()
            ->setValue('Значение 1')
            ->setXmlId('VALUE_1')
            ->setSort(321)
            ->setIsDefault(true);

        ${DS}provider->createEnumValue()
            ->setValue('Значение 2')
            ->setXmlId('VALUE_2')
            ->setSort(123);

        return ${DS}provider
            ->setSort(150)
            ->setMandatory(false)
            ->setShowFilter(true)
            ->setIsSearchable(true)
            ->setLabels('Дата и время пользователя')
            ->getParamsToArray();
    }
}
```
