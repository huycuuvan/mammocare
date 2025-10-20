<?php
/**
 * ContactForm class.
 * ContactForm is the data structure for keeping
 * contact form data. It is used by the 'contact' action of 'SiteController'.
 */
namespace frontend\models;
use Yii;
use yii\base\Model;

class ShopCart extends Model
{

    public $cart = array();
    public $order = array();
    public $type = array();


    public function init()
    {
        parent::init();
        $this->load();
    }

    public function add($id, $price , $type)
    {
        $str_item = $id;
        if (!in_array($str_item, $this->order))
        {
            $this->type[$str_item] = $type;
            $this->cart[$str_item] = $price;
            $this->order[]=$str_item;
            array_unique($this->order);
        }
//        else
//            $this->cart[$str_item] += $num;

        $this->save();
    }

    public function update($id, $num)
    {
        $str_item = $id;
        $this->cart[$str_item]= $num;
        $this->save();
    }
    public function remove($id)
    {
        $this->order = array_diff($this->order,array($id));
        $this->cart = array_diff_key($this->cart,array($id => ''));
        $this->type = array_diff_key($this->type,array($id => ''));
        $this->save();
    }

    public function quantity()
    {
        $num = 0;
        if (isset($this->cart)) {
            foreach ($this->cart as $val) {
                $num += $val;
            }
        }

        return $num;
    }

    public function getTotal(){
        $tong=0;
        if (!empty($this->cart)) {
            foreach ($this->cart as $key => $val) {
                $tam=explode(' ',$val);
                $tien=str_replace(',','',$tam[0]);
                $tien=str_replace('.','',$tien);
                $tong+=intval($tien);
            }
        }
        return $tong;
    }
    public function save()
    {
        $data = array(
            'cart_item' => $this->cart,
            'order_item' => $this->order,
            'type_item' => $this->type,
        );

        Yii::$app->session->set('shopcart', serialize($data));
    }

    public function isEmpty()
    {
        return empty($this->cart);
    }

    public function load()
    {
        if (Yii::$app->session->get('shopcart')) {
            $data=unserialize(Yii::$app->session->get('shopcart'));
            $this->cart=$data['cart_item'];
            $this->order=$data['order_item'];
            $this->type=$data['type_item'];
        }
    }

    public function reset()
    {
        $this->cart = [];
        $this->order = [];
        $this->type = [];
        $this->save();
    }

    public function getType()
    {
        return $this->type;
    }
    public function getPrice()
    {
        return $this->price;
    }
    public function getCart()
    {
        return $this->cart;
    }

    public function getOrder()
    {
        return $this->order;
    }

    public function getJson()
    {
        $arr = array();
        if (!empty($this->cart)) {
            foreach ($this->cart as $key => $val) {
                $arr[] = array(
                    'code' => $key,
                    'price' => $val,
                    'type' => $this->type[$key]
                );
            }
        }
        return $arr;
    }

    public function getBuyerJson()
    {
        return serialize($this->getJson());
    }
}
