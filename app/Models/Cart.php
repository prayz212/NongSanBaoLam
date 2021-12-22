<?php

namespace App\Models;

class Cart {
	public $items = null;
	
	public function __construct($oldCart)
	{
		if($oldCart)
		{
			$this->items = $oldCart->items;
		}
	}
	
	public function add($item, $quantity)
	{
		$cart = ['qty' => $quantity, 'price' => $item->price, 'item' => $item];
		if($this->items)
		{
			if(array_key_exists($item->id, $this->items))
			{
				$oldCart = $this->items[$id];
				$cart['qty'] += $oldCart['qty'];
			}
		}
		
		$this->items[$id] = $cart;
	}
	
	// public function removeItem($id)
	// {
	// 	$this->totalQty -= $this->items[$id]['qty'];
	// 	$this->totalPrice -= $this->items[$id]['price'];
	// 	unset($this->items[$id]);
	// }
	
	// public function decreaseItemByOne($id){
  //       $this->items[$id]['qty']--;
  //       $this->items[$id]['price'] -= $this->items[$id]['item']['unit_price'];
  //       $this->totalQty--;
  //       $this->totalPrice -= $this->items[$id]['item']['unit_price'];
  //       if($this->items[$id]['qty'] <= 0){
  //           unset($this->items[$id]);
  //       }
  //   }

  //   public function increaseItemByOne($id){
  //       $this->items[$id]['qty']++;
  //       $this->items[$id]['price'] += $this->items[$id]['item']['unit_price'];
  //       $this->totalQty++;
  //       $this->totalPrice += $this->items[$id]['item']['unit_price'];
  //   }
}


?>