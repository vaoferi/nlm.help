<?php

namespace common\behaviors;

use Yii;
use yii\behaviors\SluggableBehavior;
use yii\db\ActiveRecord;

class ProfileSluggableBehavior extends SluggableBehavior
{
    public $slugAttribute = 'slug'; // Атрибут, в который будет записан слаг
    public $attributes = []; // Атрибуты, которые будут использоваться для генерации слага
    public $ensureUnique = true; // Уникальность слага

    public function events()
    {
        return [
            ActiveRecord::EVENT_BEFORE_INSERT => 'generateSlug',
        ];
    }

    public function generateSlug($slugParts)
    {
        $model = $this->owner;
        if (empty($this->attributes)) {
            throw new \yii\base\InvalidConfigException('Attributes cannot be empty.');
        }

         $slugArr = [];
         foreach ($this->attributes as $attr) {
             $slugArr[] = $model->{$attr};
         }
        $implodedSlug = implode('-', $slugArr);
        $slug = $this->transliterateToLatin($implodedSlug);
        // Проверка уникальности, если это необходимо
        if ($this->ensureUnique) {
            $baseSlug = $slug;
            $i = 1;
            while ($model::find()->where([$this->slugAttribute => $slug])->exists()) {
                $slug = $baseSlug . '-' . $i++;
            }
        }
        // Сохранение слага в атрибуте
        $model->{$this->slugAttribute} = $slug;
    }


    protected function transliterateToLatin($string)
    {
        $transliterationTable = [
            'а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd',
            'е' => 'e', 'ё' => 'yo', 'ж' => 'zh', 'з' => 'z', 'и' => 'i',
            'й' => 'y', 'к' => 'k', 'л' => 'l', 'м' => 'm', 'н' => 'n',
            'о' => 'o', 'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't',
            'у' => 'u', 'ф' => 'f', 'х' => 'kh', 'ц' => 'ts', 'ч' => 'ch',
            'ш' => 'sh', 'щ' => 'shch', 'ъ' => '', 'ы' => 'y', 'ь' => '',
            'э' => 'e', 'ю' => 'yu', 'я' => 'ya',
            // Пробелы и специальные символы
            ' ' => '-', '.' => '', ',' => '', '—' => '-', '’' => '', "'" => '',
            // Добавьте другие символы по мере необходимости
        ];

        $string = mb_strtolower($string, 'UTF-8'); // Приводим к нижнему регистру
        $string = strtr($string, $transliterationTable); // Транслитерация

        // Удаляем лишние дефисы и пробелы
        $string = preg_replace('/-+/', '-', $string); // Убираем повторяющиеся дефисы
        $string = trim($string, '-'); // Убираем дефисы в начале и в конце

        return $string;
    }

}