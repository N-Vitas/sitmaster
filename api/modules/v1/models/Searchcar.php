<?

namespace api\modules\v1\models;
use Yii;
use yii\helpers\ArrayHelper;
use common\models\Search_by_car as BaseSearch;

class Searchcar
{ // extends Model

	public static function test()
    {
        if(Yii::$app->request->post())
        {
            $where = count(Yii::$app->request->post());
        }
        else
        {
           $where = 'test '.$where;
        }
        return $where;
	}	
    #Функция выборки машины из справочника
	public static function getCar()
    {
        $where['make'] = null;
        #Проверка существует ли марка
        if(Yii::$app->request->post('make'))
        {
            $where['make'] = Yii::$app->request->post('make');
        }
        #Проверка существует ли модель
        if(Yii::$app->request->post('model'))
        {
            $where ['model'] = Yii::$app->request->post('model');
        }
        #Проверка существует ли год
        if(Yii::$app->request->post('year'))
        {
            $where ['year'] = Yii::$app->request->post('year');
        }
        #если ничего не существует вернет пустое значение
        
        #Общее колличество данных
        $count = count(Yii::$app->request->post());
        switch ($count)
        {
            /*
             * По общему числу определяем какое поле нужно вернуть
             * и по какому полю нужно сгруппировать выборку из базы
             * дабы не поворялись значения
            */
            case 1 :
                $group = 'model';
                break;
            case 2 :
                $group = 'year';
                break;
        }
        #Если колличество данных меньше 3 то выбрать из базы все найденые результаты
        if($count < 3)
        {
            $query = BaseSearch::find()->where($where)->groupBy($group);
            #Если модель нашла результат
            if($query->count()>0)
            {
                $models = $query->all();
                foreach ($models as $model)
                    $data[] =  [$group => $model->$group];
            }
            #Если модель пуста
            else
            {
                return ['error' => "Ничего не найдено!"];
            }

        }
        #Иначе вернуть один результат со всеми полями
        else
        {
            #Если модель нашла результат
            if($models = BaseSearch::find()->where($where)->one())
            {
                $data = ['id' => $models->id,'make' => $models->make,'model' => $models->model,'year' => $models->year];
            }
            #Если модель пуста
            else
            {
                return $data = ['error' => "Ничего не найдено!"];
            }
        }
        #Передача результата в контроллер
        return $data;
    }
}
